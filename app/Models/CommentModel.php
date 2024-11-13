<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table            = 'comment';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_user', 'id_comment_parent','content','entity_id','entity_type'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getAllCommentsByIdItem($id_item) {
        return $this->where('entity_id', $id_item)->where('entity_type', 'item')->findAll();
    }

    public function insertItemComment($data) {
        $data['entity_type'] = "item";
        return $this->insert($data);
    }
    public function insertCollectionComment($data) {
        $data['entity_type'] = "collection";
        return $this->insert($data);
    }

    public function getAllCommentsByItem($id_item) {
        $this->select("comment.id, comment.content, comment.updated_at as date, u.username, m.file_path as profile_file_path");
        $this->join('TableUser u', 'u.id = comment.id_user');
        $this->join("media m", "comment.id_user = m.entity_id and m.entity_type = 'user'", "left");
        $this->where("comment.entity_type", "item");
        $this->where("comment.entity_id", $id_item);
        return $this->findAll();
    }

    public function getAllCommentsWithChildByItem($id_item) {
        // Sélection des commentaires et des informations utilisateur et média
        $this
            ->select("comment.id, comment.content, comment.updated_at as date, comment.id_comment_parent, u.username, m.file_path as profile_image")
            ->join('TableUser u', 'u.id = comment.id_user')
            ->join('media m', "comment.id_user = m.entity_id AND m.entity_type = 'user'", 'left')
            ->where('comment.entity_type', 'item')
            ->where('comment.entity_id', $id_item)
            ->orderBy('comment.id_comment_parent ASC, comment.updated_at DESC'); // Tri par parent puis par date

        // Récupérer tous les commentaires
        $comments = $this->findAll();

        // Structurer les commentaires pour gérer les enfants
        return $this->organizeComments($comments);
    }

    private function organizeComments($comments) {
        $commentTree = [];
        $childrenMap = [];

        // Organiser les commentaires dans une structure parent/enfant
        foreach ($comments as $comment) {
            $comment['children'] = []; // Préparer l'espace pour les enfants

            // Si c'est un commentaire enfant
            if ($comment['id_comment_parent'] !== null) {
                // Ajouter dans le tableau des enfants
                $childrenMap[$comment['id_comment_parent']][] = $comment;
            } else {
                // C'est un commentaire parent
                $commentTree[$comment['id']] = $comment;
            }
        }

        // Ajouter les enfants aux parents
        foreach ($childrenMap as $parentId => $children) {
            if (isset($commentTree[$parentId])) {
                // Ajouter les enfants à ce parent
                $commentTree[$parentId]['children'] = $children;
            }
        }

        // Retourner l'arbre des commentaires
        return array_values($commentTree); // Transformer en tableau indexé
    }


    public function getAllCommentsByCollection($id_collection) {
        $this->select("comment.id, comment.content, comment.updated_at as date, u.username, m.file_path as profile_file_path");
        $this->join('TableUser u', 'u.id = comment.id_user');
        $this->join("media m", "comment.id_user = m.entity_id and m.entity_type = 'user'", "left");
        $this->where("comment.entity_type", "collection");
        $this->where("comment.entity_id", $id_collection);
        return $this->findAll();
    }

    public function getPaginated($start, $length, $searchValue, $orderColumnName, $orderDirection, $entity_type="item",$custom_filter = null,$custom_filter_value=null)
    {
        $builder = $this->builder();

        $builder->select('comment.id, comment.id_user, comment.created_at, comment.id_comment_parent, SUBSTRING(comment.content, 1, 20) as content , u.username, i.name as item_name, i.id as id_item');
        $builder->join('TableUser u', 'u.id = comment.id_user');
        $builder->join('item i', 'i.id = comment.entity_id');
        $builder->where('comment.entity_type', $entity_type);
        if ($custom_filter) {
            switch ($custom_filter) {
                case "user" :
                    $builder->where('u.id', $custom_filter_value);
                    break;
                case "item" :
                    $builder->where('i.id', $custom_filter_value);
                    break;
            }
        }

        // Recherche
        if ($searchValue != null) {
            $builder->groupStart();
            $builder->like('u.username', $searchValue);
            $builder->orLike('comment.id', $searchValue);
            $builder->orLike('comment.id_comment_parent', $searchValue);
            $builder->orLike('i.name', $searchValue);
            $builder->groupEnd();
        }

        // Tri
        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }

        $builder->limit($length, $start);

        return $builder->get()->getResultArray();
    }

    public function getTotal($entity_type="item",$custom_filter = null,$custom_filter_value=null)
    {
        $builder = $this->builder();
        $builder->select('comment.id, comment.id_user, comment.created_at, comment.id_comment_parent, SUBSTRING(comment.content, 1, 20) as content , u.username, i.name as item_name, i.id as id_item');
        $builder->join('TableUser u', 'u.id = comment.id_user');
        $builder->join('item i', 'i.id = comment.entity_id');
        $builder->where('comment.entity_type', $entity_type);
        if ($custom_filter) {
            switch ($custom_filter) {
                case "user" :
                    $builder->where('u.id', $custom_filter_value);
                    break;
                case "item" :
                    $builder->where('i.id', $custom_filter_value);
                    break;
            }
        }
        return $builder->countAllResults();
    }

    public function getFiltered($searchValue, $entity_type="item",$custom_filter = null,$custom_filter_value=null)
    {
        $builder = $this->builder();
        $builder->select('comment.id, comment.id_user, comment.created_at, comment.id_comment_parent, SUBSTRING(comment.content, 1, 20) as content , u.username, i.name as item_name, i.id as id_item');
        $builder->join('TableUser u', 'u.id = comment.id_user');
        $builder->join('item i', 'i.id = comment.entity_id');
        $builder->where('comment.entity_type', $entity_type);
        if ($custom_filter) {
            switch ($custom_filter) {
                case "user" :
                    $builder->where('u.id', $custom_filter_value);
                    break;
                case "item" :
                    $builder->where('i.id', $custom_filter_value);
                    break;
            }
        }
        if (!empty($searchValue)) {
            $builder->groupStart();
            $builder->like('u.username', $searchValue);
            $builder->orLike('comment.id', $searchValue);
            $builder->orLike('comment.id_comment_parent', $searchValue);
            $builder->orLike('i.name', $searchValue);
            $builder->groupEnd();
        }

        return $builder->countAllResults();
    }

    public function getCommentById($id) {
        $this->select('comment.id, comment.id_user, comment.created_at, comment.id_comment_parent, comment.content , u.username, i.name as item_name, i.id as id_item');
        $this->join('TableUser u', 'u.id = comment.id_user');
        $this->join('item i', 'i.id = comment.entity_id');
        $this->where('comment.id', $id);
        return $this->first();
    }

    public function updateComment($data) {
        return $this->update($data['id'],$data);
    }

    public function getTotalByIdAndActive($id_item) {
        $builder = $this->builder();
        $builder->where('entity_id', $id_item);
        $builder->where('deleted_at', NULL);
        return $builder->countAllResults();
    }

}
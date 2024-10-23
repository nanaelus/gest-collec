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
    protected $allowedFields    = ['id', 'id_user', 'entity_id', 'content', 'entity_type', 'created_at', 'updated_at', 'deleted_at, id_comment_parent'];


    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;


    public function createCollectionComment($data) {
        $data['entity_type'] = 'item';
        return $this->insert($data);
    }
    public function insertItemComment($data)
    {
        $data['entity_type'] = "item";
//        print_r($data); die();
        return $this->insert($data);
    }

    public function updateComment($id, $data) {
        return $this->update($id, $data);
    }


    public function getAllCommentsByEntitySlug($slug, $id) {
        $builder = $this->db->table('comment c');
        $builder->select('c.content, i.slug, i.id, c.entity_id');
        $builder->join('item i', 'i.id = c.entity_id');
        $builder->where('i.slug', $slug)->where('c.entity_id', $id);
        $comments = $builder->get()->getResultArray();
        return $comments;
    }

    public function getAllCommentsByItem($id_item) {
        $this->select("comment.id, comment.content, comment.updated_at as date, u.username, m.file_path as profile_file_path,comment.deleted_at");
        $this->join('TableUser u', 'u.id = comment.id_user');
        $this->join("media m", "comment.id_user = m.entity_id and m.entity_type = 'user'", "left");
        $this->where("comment.entity_type", "item");
        $this->where("comment.entity_id", $id_item);
        $this->orderBy("comment.updated_at", "ASC");
        return $this->findAll();
    }

    public function getCommentsByUserId($id_user) {
        $this->select("comment.id, comment.content, comment.updated_at as date, u.username, m.file_path as profile_file_path, comment.deleted_at");
        $this->join('TableUser u', 'u.id = comment.id_user');
        $this->join("media m", "comment.id_user = m.entity_id and m.entity_type = 'user'", "left");
        $this->where("comment.entity_type", "item");
        $this->where("comment.id_user", $id_user);
        return $this->findAll();
    }

    public function getAllCommentsByCollection($id_collection)
    {
        $this->select("comment.id, comment.content, comment.updated_at as date, u.username, m.file_path as profile_file_path");
        $this->join('TableUser u', 'u.id = comment.id_user');
        $this->join("media m", "comment.id_user = m.entity_id and m.entity_type = 'user'", "left");
        $this->where("comment.entity_type", "collection");
        $this->where("comment.entity_id", $id_collection);
        return $this->findAll();
    }
    public function getAllComments() {
        return $this->findAll();
    }

    public function getFullCommentById($id) {
        $builder = $this->builder();
        $builder->select('comment.id,comment.id_user ,u.username, comment.created_at, comment.updated_at, i.name, comment.entity_id, comment.content, comment.deleted_at');
        $builder->join('TableUser u', 'u.id = comment.id_user');
        $builder->join('item i', 'i.id = comment.entity_id');
        $builder->where('comment.id', $id);
        $comment = $builder->get()->getRowArray();
        return $comment;
    }
    public function getPaginated($start, $length, $searchValue, $orderColumnName, $orderDirection, $entity_type = 'item', $custom_filter = null, $custom_filter_value = null)
    {
        $builder = $this->builder();
        $builder->select('comment.id, comment.id_user, comment.created_at, comment.id_comment_parent, SUBSTRING(comment.content, 1, 20) as content , u.username, i.name as item_name, i.id as id_item, comment.updated_at as date, comment.entity_id, comment.deleted_at');
        $builder->join('TableUser u', 'u.id = comment.id_user');
        $builder->join('item i', 'i.id = comment.entity_id');
        $builder->where('comment.entity_type', $entity_type);
        if($custom_filter) {
            switch($custom_filter) {
                case "user":
                    $builder->where('u.id', $custom_filter_value);
                    break;
                case 'item' :
                    $builder->where('i.id', $custom_filter_value);
                    break;
            }
        }

        // Recherche
        if ($searchValue != null) {
            $builder->groupStart();
            $builder->like('name', $searchValue);
            $builder->orLike('u.username', $searchValue);
            $builder->orLike('content', $searchValue);
            $builder->orLike('entity_id', $searchValue);
            $builder->groupEnd();
        }

        // Tri
        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }

        $builder->limit($length, $start);

        return $builder->get()->getResultArray();
    }

    public function getTotal($entity_type = 'item', $custom_filter = null, $custom_filter_value = null)
    {
        $builder = $this->builder();
        $builder->select('comment.id, comment.id_user, comment.created_at, comment.id_comment_parent, SUBSTRING(comment.content, 1, 20) as content , u.username, i.name as item_name, i.id as id_item, comment.updated_at as date, comment.entity_id, comment.deleted_at');
        $builder->join('TableUser u', 'u.id = comment.id_user');
        $builder->join('item i', 'i.id = comment.entity_id');
        $builder->where('comment.entity_type', $entity_type);
        if($custom_filter) {
            switch($custom_filter) {
                case "user":
                    $builder->where('u.id', $custom_filter_value);
                    break;
                case 'item' :
                    $builder->where('i.id', $custom_filter_value);
                    break;
            }
        }
        return $builder->countAllResults();
    }

    public function getFiltered($searchValue, $entity_type = 'item', $custom_filter = null, $custom_filter_value = null)
    {
        $builder = $this->builder();
        $builder->select('comment.id, comment.id_user, comment.created_at, comment.id_comment_parent, SUBSTRING(comment.content, 1, 20) as content , u.username, i.name as item_name, i.id as id_item, comment.updated_at as date, comment.entity_id, comment.deleted_at');
        $builder->join('TableUser u', 'u.id = comment.id_user');
        $builder->join('item i', 'i.id = comment.entity_id');
        $builder->where('comment.entity_type', $entity_type);
        if($custom_filter) {
            switch($custom_filter) {
                case "user":
                    $builder->where('u.id', $custom_filter_value);
                    break;
                case 'item' :
                    $builder->where('i.id', $custom_filter_value);
                    break;
            }
        }
        if (!empty($searchValue)) {
            $builder->groupStart();
            $builder->like('name', $searchValue);
            $builder->orLike('u.username', $searchValue);
            $builder->orLike('content', $searchValue);
            $builder->orLike('entity_id', $searchValue);
            $builder->groupEnd();
        }
        return $builder->countAllResults();
    }

    public function deleteComment($id) {
        return $this->delete($id);
    }

    public function activateComment($id) {
        $builder = $this->builder();
        $builder->set('deleted_at', NULL);
        $builder->where('id', $id);
        return $builder->update();
    }

    public function getTotalByIdAndActive($id_item) {
        $builder = $this->builder();
        $builder->where('entity_id', $id_item);
        $builder->where('deleted_at', NULL);
        return $builder->countAllResults();
    }
}
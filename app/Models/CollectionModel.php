<?php

namespace App\Models;

use CodeIgniter\Model;

class CollectionModel extends Model
{
    protected $table            = 'collection';
    protected $primaryKey       = 'id_item';
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['id_item','id_user','id_loan'];

    public function insertCollection($id_user,$id_item, $id_loan = null) {
        $builder = $this->db->table($this->table);
        $builder->set('id_user', $id_user);
        $builder->set('id_item', $id_item);
        if ($id_loan != null) {
            $builder->set('id_loan', $id_loan);
        }
        return $builder->insert();
    }

    public function deleteCollection($id_user, $id_item) {
        $builder = $this->db->table($this->table);
        $builder->where('id_user', $id_user);
        $builder->where('id_item', $id_item);
        return $builder->delete();
    }

    public function haveInCollection($id_user,$id_item) {
        $builder = $this->db->table($this->table);
        $builder->where('id_user', $id_user);
        $builder->where('id_item', $id_item);
        $count = $builder->countAllResults();
        if ($count > 0) {
            return true;
        }else{
            return false;
        }
    }
    public function haveInCollectionByUsername($username,$id_item) {
        $builder = $this->db->table($this->table);
        $builder->join('TableUser u', 'u.id = collection.id_user');
        $builder->where('username', $username);
        $builder->where('id_item', $id_item);
        $count = $builder->countAllResults();
        if ($count > 0) {
            return true;
        }else{
            return false;
        }
    }

    public function getAllCollectionByUsername($username) {
        $builder = $this->db->table($this->table);
        $builder->select("*");
        $builder->join("item i", "collection.id_item = i.id");
        $builder->join("TableUser u","collection.id_user = u.id");
        $builder->where("u.username",$username);
        return $builder->get()->getResultArray();
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class CollectionModel extends Model
{
    protected $table = 'collections';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = 'array';

    protected $allowedFields = ['id_item', 'id_user', 'id_loan'];

    public function insertCollection($id_item, $id_user, $id_loan = null) {
        $builder = $this->db->table('collection');
        $builder->set('id_user', $id_user);
        $builder->set('id_item', $id_item);
        if($id_loan != null) {
            $builder->set('id_loan', $id_loan);
        }
        return $builder->insert();
    }

    public function deleteCollection($id_item, $id_user) {
    $builder = $this->db->table('collection');
    $builder->where('id_user', $id_user);
    $builder->where('id_item', $id_item);
    return $builder->delete();
}

    public function haveInCollection($id_user, $id_item) {
        $builder = $this->db->table('collection');
        $builder->where('id_user', $id_user);
        $builder->where('id_item', $id_item);
        $count = $builder->countAllResults();
        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }
}
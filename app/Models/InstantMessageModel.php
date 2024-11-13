<?php

namespace App\Models;
use CodeIgniter\Model;

class InstantMessageModel extends Model
{
    protected $table = 'instant_message';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_receiver','id_sender','content',  'created_at'];
    protected $useTimestamps = false;
    protected $useSoftDeletes = false;
    public function insertMessage($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->insert($data);
    }

    public function getMessageHistory($id_1, $id_2, $limit = 10, $offset = 0) {
        $this->select('*');
        $this->groupStart();
        $this->where('id_sender', $id_1);
        $this->where('id_receiver', $id_2);
        $this->groupEnd();
        $this->orGroupStart();
        $this->where('id_sender', $id_2);
        $this->where('id_receiver', $id_1);
        $this->groupEnd();
        $this->orderBy('created_at', 'desc');
        return $this->findAll($limit, $offset);
    }

    public function getLastMessageHistory($id_1, $id_2, $limit, $offset, $timestamp) {
        $this->select('*');
        $this->groupStart();
        $this->where('id_sender', $id_1);
        $this->where('id_receiver', $id_2);
        $this->where('created_at > ', $timestamp);
        $this->groupEnd();
        $this->orGroupStart();
        $this->where('id_sender', $id_2);
        $this->where('id_receiver', $id_1);
        $this->where('created_at > ', $timestamp);
        $this->groupEnd();
        $this->orderBy('created_at', 'desc');
        return $this->findAll($limit, $offset);
    }
}
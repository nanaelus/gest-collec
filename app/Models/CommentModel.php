<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table            = 'comment';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'id_user', 'entity_id', 'comment',	'created_at', 'updated_at', 'deleted_a'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function createComment($data) {
        return $this->insert($data);
    }

    public function getAllCommentsByEntitySlug($slug, $id) {
        $builder = $this->db->table('comment c');
        $builder->select('c.comment, i.slug, i.id, c.entity_id');
        $builder->join('item i', 'i.id = c.entity_id');
        $builder->where('i.slug', $slug)->where('c.entity_id', $id);
        $comments = $builder->get()->getResultArray();
        return $comments;
    }
}

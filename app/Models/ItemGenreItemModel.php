<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemGenreItemModel extends Model
{
    protected $table            = 'genre_item';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_genre', 'id_item'];

    public function insertMultipleGenre($data) {
        return $this->insertBatch($data);
    }

    public function totalItemByGenre($id_genre) {
        return $this->select('COUNT(*) as total')->where('id_genre', $id_genre)->first();
    }

    public function getAllItemGenre($id_genre) {
        return $this->select('COUNT(*) as total')->where('id_genre', $id_genre)->first();
    }

    public function getAllItemGenreByIdItem($id_item) {
        $builder = $this->db->table('genre_item gi');
        $builder->select('gi.id_genre, g.name');
        $builder->join('genre g', 'gi.id_genre = g.id');
        $builder->where('gi.id_item', $id_item);
        return $builder->get()->getResultArray();
    }

    public function deleteMultipleGenre($id_item, array $id_genre) {
        foreach ($id_genre as $id) {
            if (!$this->where('id_item', $id_item)->where('id_genre', $id)->delete() ) {
                return false;
            }
        }
        return true;
    }
}

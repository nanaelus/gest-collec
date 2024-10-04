<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemBrandModel extends Model
{
    protected $table            = 'brand';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnBrand       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name','slug','id_brand_parent'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

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

    public function getBrandById($id) {
        return $this->find($id);
    }

    public function getAllBrands() {
        return $this->findAll();
    }

    public function deleteBrand($id) {
        return $this->delete($id);
    }

    public function getBrandBySlug($slug) {
        return $this->where('slug',$slug)->first();
    }
    public function insertBrand($item) {
        if(isset($item['id_brand_parent']) && (empty($item['id_brand_parent']) || $item['id_brand_parent'] == 'none')) {
            unset($item['id_brand_parent']);
        }
        if (isset($item['name'])) {
            $item['slug'] = $this->generateUniqueSlug($item['name']);
        }
        return $this->insert($item);
    }

    public function updateBrand($id, $data) {
        if (isset($data['name'])) {
            $data['slug'] = $this->generateUniqueSlug($data['name'],$id);
        }
        if ($data['id_brand_parent'] == 'none') {
            $data['id_brand_parent'] = null;
        }
        return $this->update($id, $data);
    }

    private function generateUniqueSlug($name, $currentId = null) {
        $slug = generateSlug($name);
        $builder = $this->builder();
        // Vérifie si le slug existe déjà pour un autre enregistrement
        if ($currentId !== null) {
            $builder->where('id !=', $currentId);
        }
        $count = $builder->where('slug', $slug)->countAllResults();
        // Si aucun conflit, on retourne le slug
        if ($count === 0) {
            return $slug;
        }
        // Génération d'un nouveau slug unique
        $i = 1;
        $newSlug = $slug;
        while ($count > 0) {
            $newSlug = $slug . '-' . $i;
            $builder->where('slug', $newSlug);
            // Ignorer l'élément en cours de modification dans la recherche
            if ($currentId !== null) {
                $builder->where('id !=', $currentId);
            }
            $count = $builder->countAllResults();
            $i++;
        }
        return $newSlug;
    }

    public function getPaginated($start, $length, $searchValue, $orderColumnName, $orderDirection)
    {
        $builder = $this->builder();
        // Recherche
        if ($searchValue != null) {
            $builder->like('name', $searchValue);
        }

        // Tri
        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }

        $builder->limit($length, $start);

        return $builder->get()->getResultArray();
    }

    public function getTotal()
    {
        $builder = $this->builder();
        return $builder->countAllResults();
    }

    public function getFiltered($searchValue)
    {
        $builder = $this->builder();
        // @phpstan-ignore-next-line
        if (!empty($searchValue)) {
            $builder->like('name', $searchValue);
        }

        return $builder->countAllResults();
    }
}
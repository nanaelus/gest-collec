<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemLicenseModel extends Model
{
    protected $table            = 'license';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnLicense       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name','slug','id_license_parent'];

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

    public function getLicenseById($id) {
        return $this->find($id);
    }

    public function getAllLicenses() {
        return $this->findAll();
    }

    public function deleteLicense($id) {
        return $this->delete($id);
    }

    public function getLicenseBySlug($slug) {
        return $this->where('slug',$slug)->first();
    }
    public function insertLicense($data) {
        if(isset($data['id_license_parent']) && empty($data['id_license_parent']) || $data['id_license_parent'] == 'none')  {
            unset($data['id_license_parent']);
        }
        if (isset($data['name'])) {
            $data['slug'] = $this->generateUniqueSlug($data['name']);
        }
        return $this->insert($data);
    }

    public function updateLicense($id,$data) {
        if (isset($data['name'])) {
            $data['slug'] = $this->generateUniqueSlug($data['name'], $id);
        }
        if ($data['id_license_parent'] == 'none') {
            $data['id_license_parent'] = null;
        }
        return $this->update($id,$data);
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
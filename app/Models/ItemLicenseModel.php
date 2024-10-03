<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemLicenseModel extends Model
{
    protected $table            = 'license';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'slug', 'id_license_parent'];

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

    public function getAllLicenses()
    {
        return $this->findAll();
    }

    public function insertLicense($data) {
        if(isset($data['id_license_parent']) && empty($data['id_license_parent'])) {
            unset($data['id_license_parent']);
        }
        if (isset($data['name'])) {
            $data['slug'] = $this->generateUniqueSlug($data['name']);
        }
        return $this->insert($data);
    }

    public function deleteLicense($id) {
        return $this->delete($id);
    }

    private function generateUniqueSlug($name)
    {
        $slug = generateSlug($name); // Utilisez la fonction du helper pour générer le slug de base
        $builder = $this->builder();

        // Vérifiez si le slug existe déjà
        $count = $builder->where('slug', $slug)->countAllResults();

        if ($count === 0) {
            return $slug;
        }

        // Si le slug existe, ajoutez un suffixe numérique pour le rendre unique
        $i = 1;
        while ($count > 0) {
            $newSlug = $slug . '-' . $i;
            $count = $builder->where('slug', $newSlug)->countAllResults();
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

    public function updateLicense($id, $data) {
        if(isset($data['name'])) {
            $data['slug'] = $this->generateUniqueSlug($data['name']);
        }
        return $this->update($id, $data);
    }
    public function getLicenseById($id)
    {
        return $this->find($id);
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class UserPermissionModel extends Model
{
    protected $table = 'TableUserPermission';
    protected $primaryKey = 'id';

    // Champs permis pour les opérations d'insertion et de mise à jour
    protected $allowedFields = ['name'];

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Le nom de la permission est requis.',
            'min_length' => 'Le nom de la permission doit comporter au moins 3 caractères.',
            'max_length' => 'Le nom de la permission ne doit pas dépasser 100 caractères.',
        ],
    ];

    // Relations avec les utilisateurs
    public function getUsersByPermission($permissionId)
    {
        return $this->join('TableUser', 'TableUserPermission.id = TableUser.id_permission')
            ->where('TableUserPermission.id', $permissionId)
            ->select('TableUser.*, TableUserPermission.name as permission_name')
            ->findAll();
    }
    public function getAllPermissions()
    {
        return $this->findAll();
    }
}
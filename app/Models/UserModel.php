<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'TableUser';
    protected $primaryKey = 'id';

    // Champs permis pour les opérations d'insertion et de mise à jour
    protected $allowedFields = ['username', 'email', 'password', 'id_permission', 'created_at', 'updated_at', 'deleted_at'];

    // Activer le soft delete
    protected $useSoftDeletes = true;

    // Champs de gestion des dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[100]',
        'email'    => 'required|valid_email|is_unique[TableUser.email,id,{id}]',
        'password' => 'required|min_length[8]',
        'id_permission' => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'username' => [
            'required'   => 'Le nom d\'utilisateur est requis.',
            'min_length' => 'Le nom d\'utilisateur doit comporter au moins 3 caractères.',
            'max_length' => 'Le nom d\'utilisateur ne doit pas dépasser 100 caractères.',
        ],
        'email' => [
            'required'   => 'L\'email est requis.',
            'valid_email' => 'L\'email doit être valide.',
            'is_unique'   => 'Cet email est déjà utilisé.',
        ],
        'password' => [
            'required'   => 'Le mot de passe est requis.',
            'min_length' => 'Le mot de passe doit comporter au moins 8 caractères.',
        ],
        'id_permission' => [
            'required'          => 'La permission est requise.',
            'is_natural_no_zero' => 'La permission doit être un entier positif.',
        ],
    ];

    // Callbacks pour le hachage du mot de passe
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        return $data;
    }

    // Relations avec les permissions
    public function getPermissions()
    {
        return $this->join('TableUserPermission', 'TableUser.id_permission = TableUserPermission.id')
            ->select('TableUser.*, TableUserPermission.name as permission_name')
            ->findAll();
    }

    public function getUserById($id)
    {
        return $this->find($id);
    }

    public function getAllUsers()
    {
        return $this->findAll();
    }

    public function createUser($data)
    {
        return $this->insert($data);
    }
    public function updateUser($id, $data)
    {
        $builder = $this->builder();
        if (isset($data['password'])) {
            if($data['password'] == '') {
                unset($data['password']);
            } else {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }
        }
        $builder->where('id', $id);
        return $builder->update($data);
    }
    public function deleteUser($id)
    {
        return $this->delete($id);
    }

    public function countUserByPermission() {
        $builder = $this->db->table('TableUser U');
        $builder->select('UP.name, count(U.id) as count');
        $builder->join('TableUserPermission UP', 'U.id_permission = UP.id');
        $builder->groupBy('U.id_permission');
        return $builder->get()->getResultArray();
    }

    public function activateUser($id) {
        $builder = $this->builder();
        $builder->set('deleted_at', NULL);
        $builder->where('id', $id);
        return $builder->update();
    }

    public function verifyLogin($email, $password)
    {
        // Rechercher l'utilisateur par email
        $user = $this->withDeleted()->where('email', $email)->first();

        // Si l'utilisateur existe, vérifier le mot de passe
        if ($user && password_verify($password, $user['password'])) {
            // Le mot de passe est correct, retourner les informations de l'utilisateur
            return $user;
        }

        // Si l'utilisateur n'existe pas ou si le mot de passe est incorrect, retourner false
        return false;
    }

    public function getPaginatedUser($start, $length, $searchValue, $orderColumnName, $orderDirection)
    {
        $builder = $this->builder();
        $builder->join('TableUserPermission', 'TableUser.id_permission = TableUserPermission.id', 'left');
        $builder->join('media', 'TableUser.id = media.entity_id AND media.entity_type = "user"', 'left');
        $builder->select('TableUser.*, TableUserPermission.name as permission_name, media.file_path as avatar_url');

        // Recherche
        if ($searchValue != null) {
            $builder->like('username', $searchValue);
            $builder->orLike('email', $searchValue);
            $builder->orLike('TableUserPermission.name', $searchValue);
        }

        // Tri
        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }

        $builder->limit($length, $start);

        return $builder->get()->getResultArray();
    }

    public function getTotalUser()
    {
        $builder = $this->builder();
        $builder->join('TableUserPermission', 'TableUser.id_permission = TableUserPermission.id');
        return $builder->countAllResults();
    }

    public function getFilteredUser($searchValue)
    {
        $builder = $this->builder();
        $builder->join('TableUserPermission', 'TableUser.id_permission = TableUserPermission.id', 'left');
        $builder->join('media', 'TableUser.id = media.entity_id AND media.entity_type = "user"', 'left');
        $builder->select('TableUser.*, TableUserPermission.name as permission_name, media.file_path as avatar_url');

        // @phpstan-ignore-next-line
        if (! empty($searchValue)) {
            $builder->like('username', $searchValue);
            $builder->orLike('email', $searchValue);
            $builder->orLike('TableUserPermission.name', $searchValue);
        }

        return $builder->countAllResults();
    }


}
<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    // Définir les propriétés accessibles
    protected $attributes = [
        'id'            => null,
        'username'      => null,
        'email'         => null,
        'password'      => null,
        'id_permission' => null,
        'created_at'    => null,
        'updated_at'    => null,
        'deleted_at'    => null,
    ];

    // Cast des types
    protected $casts = [
        'id'            => 'integer',
        'id_permission' => 'integer',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
        'deleted_at'    => 'datetime',
    ];

    protected $hidden = ['password'];

    // Automatiser le hachage du mot de passe
    public function setPassword(string $password)
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }
    public function isAdmin(): bool
    {
        return $this->check('administrateur');
    }

    // Méthode pour récupérer le niveau de permission
    public function getPermissions(): string
    {
        return $this->getPermissionName();
    }

    public function isActive(): bool
    {
        return $this->attributes['deleted_at'] === null;
    }

    public function check(string $slug): bool
    {
        $userPermissionSlug  = $this->getPermissionSlug();

        return $userPermissionSlug === $slug;
    }

    public function getPermissionName()
    {
        $upm = Model('UserPermissionModel');
        $permission = $upm->find($this->attributes['id_permission']);
        return $permission ? $permission['name'] : null;
    }

    public function getPermissionSlug(): string
    {
        $upm = Model('UserPermissionModel');
        $permission = $upm->find($this->attributes['id_permission']);

        return $permission ? $permission['slug'] : '';  // Assurez-vous que 'slug' est dans le modèle PermissionModel
    }

    static public function permission_levels(): array
    {
        return [
            '' => 'Utilisateur',
            'administrateur' => 'Administrateur',        // Utilisez des slugs au lieu de noms
            'super-admininistrateur' => 'Super Administrateur'
        ];
    }
}

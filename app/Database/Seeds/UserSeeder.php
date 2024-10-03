<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'      => 'alice',
                'email'         => 'alice@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 3,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'bob',
                'email'         => 'bob@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 2,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'charlie',
                'email'         => 'charlie@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 3,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'dave',
                'email'         => 'dave@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 3,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'eve',
                'email'         => 'eve@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 2,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'frank',
                'email'         => 'frank@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 3,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'grace',
                'email'         => 'grace@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 2,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'heidi',
                'email'         => 'heidi@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 2,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'ivan',
                'email'         => 'ivan@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 3,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'judy',
                'email'         => 'judy@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 3,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'kate',
                'email'         => 'kate@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 2,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'leo',
                'email'         => 'leo@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 3,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'mia',
                'email'         => 'mia@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 2,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'nina',
                'email'         => 'nina@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 2,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'oscar',
                'email'         => 'oscar@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 3,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'pat',
                'email'         => 'pat@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 3,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'quinn',
                'email'         => 'quinn@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 2,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'ruth',
                'email'         => 'ruth@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 3,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'sam',
                'email'         => 'sam@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 2,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'tina',
                'email'         => 'tina@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_permission' => 2,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        // Insérer les données dans la table
        $this->db->table('TableUser')->insertBatch($data);
    }
}
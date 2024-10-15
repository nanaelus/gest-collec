<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAdminUser extends Migration
{
    public function up()
    {
        // Insérer un utilisateur administrateur par défaut
        $data = [
            'username'     => 'admin',
            'email'        => 'admin@admin.fr',
            'password'     => password_hash('admin', PASSWORD_DEFAULT),
            'id_permission' => 1, // Id de la permission Administrateur
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ];

        $this->db->table('TableUser')->insert($data);
    }

    public function down()
    {
        $this->db->table('TableUser')
            ->where('username', 'admin')
            ->delete();
    }
}

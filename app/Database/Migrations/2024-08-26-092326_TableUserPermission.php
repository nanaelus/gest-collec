<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableUserPermission extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('TableUserPermission');

        // Insérer les 3 permissions par défaut
        $data = [
            ['name' => 'Administrateur'],
            ['name' => 'Collaborateur'],
            ['name' => 'Utilisateur'],
        ];
        $this->db->table('TableUserPermission')->insertBatch($data);

        $this->db->query('ALTER TABLE TableUser ADD CONSTRAINT fk_id_permission FOREIGN KEY (id_permission) REFERENCES TableUserPermission(id) ON DELETE CASCADE ON UPDATE CASCADE');


    }

    public function down()
    {
        $this->db->query('ALTER TABLE TableUser DROP FOREIGN KEY fk_id_permission');
        $this->forge->dropTable('TableUserPermission');
    }
}

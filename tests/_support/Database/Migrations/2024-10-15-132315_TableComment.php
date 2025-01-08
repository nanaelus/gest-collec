<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableComment extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                ],
            'entity_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'comment' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);

        //Clef primaire
        $this->forge->addKey('id', true);

        //Clefs étrangères
        $this->forge->addForeignKey('id_user', 'TableUser', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('entity_id', 'item', 'id', 'CASCADE', 'CASCADE');

        //Création de la table
        $this->forge->createTable('comment');
    }

    public function down()
    {
        $this->forge->dropTable('comment');
    }
}

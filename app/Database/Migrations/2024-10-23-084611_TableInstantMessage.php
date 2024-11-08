<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InstantMessages extends Migration
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
            'id_sender' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_receiver' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_sender', 'TableUser', 'id');
        $this->forge->addForeignKey('id_receiver', 'TableUser', 'id');
        $this->forge->createTable('instant_message');
    }

    public function down()
    {
        $this->forge->dropTable('instant_message');
    }
}
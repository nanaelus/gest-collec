<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableGenre extends Migration
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
                'constraint' => '50',
            ],
            'id_genre_parent' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'default' => null,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_genre_parent', 'genre', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('genre');
    }

    public function down()
    {
        $this->forge->dropTable('genre');
    }
}
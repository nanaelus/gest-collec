<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableGenreItem extends Migration
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
            'id_genre' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => null,
            ],
            'id_item' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => null,
            ],
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('id_genre', 'genre', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_item', 'item', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('genre_item');
    }

    public function down()
    {
        $this->forge->dropTable('genre_item');
    }
}
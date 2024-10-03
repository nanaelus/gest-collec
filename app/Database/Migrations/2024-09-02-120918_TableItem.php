<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableItem extends Migration
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
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'price' => [
                'type' => 'FLOAT',
                'unsigned' => true,
                'default' => '0',
            ],
            'release_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'active' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'id_license' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'default'        => 1
            ],
            'id_brand' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'default'        => 1
            ],
            'id_type' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'default'        => 1
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ]
        ]);

        //clé primaire
        $this->forge->addPrimaryKey('id');

        //clé étrangère
        $this->forge->addForeignKey('id_license', 'license', 'id','CASCADE','RESTRICT');
        $this->forge->addForeignKey('id_brand', 'brand', 'id','CASCADE','RESTRICT');
        $this->forge->addForeignKey('id_type', 'type', 'id','CASCADE','RESTRICT');

        //création de la table
        $this->forge->createTable('item');

    }

    public function down()
    {
        $this->forge->dropTable('item');
    }
}

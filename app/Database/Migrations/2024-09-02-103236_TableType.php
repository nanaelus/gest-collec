<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableType extends Migration
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
            'id_type_parent' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'default'        => null
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_type_parent', 'type', 'id','CASCADE','SET NULL');
        $this->forge->createTable('type');
    }

    public function down()
    {
        $this->forge->dropTable('type');
    }
}
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableComment extends Migration
{
    public function up()
    {
        $fields = [
            'entity_type' => [
                'type' => 'ENUM',
                'constraint' => ['user', 'item','brand','license'],
                'default' => 'item',
            ],
        ];
        $forge = \Config\Database::forge();
        $forge->addColumn('comment', $fields);
    }

    public function down()
    {
        //
    }
}

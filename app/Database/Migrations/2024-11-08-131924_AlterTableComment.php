<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableComment extends Migration
{
    public function up()
    {
        $fields = [
            'comment' => [
                'name' => 'content',
                'type' => 'TEXT',
                'null' => true,
            ],
        ];
        $this->forge->modifyColumn('comment', $fields);
    }

    public function down()
    {
        //
    }
}

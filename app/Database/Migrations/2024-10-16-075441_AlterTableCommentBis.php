<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableCommentBis extends Migration
{
    public function up()
    {
        $field = [
            'id_comment_parent' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ]
        ];
        $this->forge->addColumn('comment', $field);
        $this->forge->addForeignKey('id_comment_parent', 'comment', 'id', 'CASCADE', 'SET NULL');
    }

    public function down()
    {
        //
    }
}

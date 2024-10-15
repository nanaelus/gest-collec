<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DefaultItemValues extends Migration
{
    public function up()
    {
            $this->db->table('license')->insert(['name' =>'Non classé']);
            $this->db->table('genre')->insert(['name' =>'Aucun genre']);
            $this->db->table('type')->insert(['name' =>'Non classé']);
            $this->db->table('brand')->insert(['name' =>'Aucune marque']);
    }

    public function down()
    {
        $this->db->table('license')->where('name', 'Non classé')->delete();
        $this->db->table('genre')->where('name', 'Aucun genre')->delete();
        $this->db->table('license')->where('name', 'Non classé')->delete();
        $this->db->table('license')->where('name', 'Aucune marque')->delete();
    }
}

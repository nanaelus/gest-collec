<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTablesItemGenreMedia extends Migration
{
    public function up()
    {
        //TableItem
        $this->forge->addColumn('item', [
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
                'after'      => 'name',
            ],
            'id_default_img' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
                'after' => 'id_type',
            ]
        ]);
        $this->updateSlugs('item');

        //Genre
        $this->forge->dropForeignKey('genre', 'genre_id_genre_parent_foreign');
        $this->forge->dropColumn('genre', 'id_genre_parent');

        //MEDIA
        $this->forge->addColumn('media', [
            'mime_type'  => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
                'after' => 'file_path',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('item', 'slug');
        $this->forge->dropColumn('item', 'id_default_img');
        $this->forge->dropColumn('media', 'mime_type');
        $this->forge->addColumn('genre', [
            'id_genre_parent' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'default'        => null
            ]
        ]);
    }
    private function updateSlugs($table)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($table);
        $results = $builder->get()->getResultArray();
        foreach ($results as $row) {
            $slug = $this->generateSlug($row['name']); // Utilisez la fonction du helper ou définie ici
            $builder->where('id', $row['id'])->update(['slug' => $slug]);
        }
    }

    private function generateSlug($string)
    {
        // Normaliser la chaîne pour enlever les accents
        $string = \Normalizer::normalize($string, \Normalizer::FORM_D);
        $string = preg_replace('/[\p{Mn}]/u', '', $string);

        // Convertir les caractères spéciaux en minuscules et les espaces en tirets
        $string = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));

        return $string;
    }
}
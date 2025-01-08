<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTablesAddSlug extends Migration
{
    public function up()
    {
        // Charger le helper si nécessaire
        helper('utils'); // Assurez-vous que 'utils' est le nom correct du fichier sans l'extension

        // TableUserPermission
        $this->forge->addColumn('TableUserPermission', [
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
                'after'      => 'name',
            ],
        ]);
        $this->updateSlugs('TableUserPermission');

        // license
        $this->forge->addColumn('license', [
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
                'after'      => 'name',
            ],
        ]);
        $this->updateSlugs('license');

        // brand
        $this->forge->addColumn('brand', [
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
                'after'      => 'name',
            ],
        ]);
        $this->updateSlugs('brand');

        // type
        $this->forge->addColumn('type', [
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
                'after'      => 'name',
            ],
        ]);
        $this->updateSlugs('type');

        // genre
        $this->forge->addColumn('genre', [
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
                'after'      => 'name',
            ],
        ]);
        $this->updateSlugs('genre');
    }

    public function down()
    {
        $this->forge->dropColumn('TableUserPermission', 'slug');
        $this->forge->dropColumn('license', 'slug');
        $this->forge->dropColumn('brand', 'slug');
        $this->forge->dropColumn('type', 'slug');
        $this->forge->dropColumn('genre', 'slug');
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

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TypeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Livres', 'slug' => 'livres', 'id_type_parent' => null],
            ['name' => 'Bande Dessinée', 'slug' => 'bande-dessinee', 'id_type_parent' => 1],
            ['name' => 'Manga', 'slug' => 'manga', 'id_type_parent' => 1],
            ['name' => 'Shonen', 'slug' => 'shonen', 'id_type_parent' => 3],
            ['name' => 'Seinen', 'slug' => 'seinen', 'id_type_parent' => 3],
            ['name' => 'Figurines', 'slug' => 'figurines', 'id_type_parent' => null],
            ['name' => 'Jouets', 'slug' => 'jouets', 'id_type_parent' => null],
            ['name' => 'Jeux Vidéo', 'slug' => 'jeux-video', 'id_type_parent' => null],
            ['name' => 'DVD', 'slug' => 'dvd', 'id_type_parent' => null],
            ['name' => 'Bluray', 'slug' => 'bluray', 'id_type_parent' => null],
            ['name' => 'Comics', 'slug' => 'comics', 'id_type_parent' => 1],
            ['name' => 'Artbook', 'slug' => 'artbook', 'id_type_parent' => 1],
            ['name' => 'Roman', 'slug' => 'roman', 'id_type_parent' => 1],
            ['name' => 'Films', 'slug' => 'films', 'id_type_parent' => null],
            ['name' => 'Séries TV', 'slug' => 'series-tv', 'id_type_parent' => null],
        ];

        // Insertion des données dans la table `type`
        $this->db->table('type')->insertBatch($data);
    }
}
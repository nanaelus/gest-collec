<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Science-Fiction', 'slug' => 'science-fiction'],
            ['name' => 'Fantasy', 'slug' => 'fantasy'],
            ['name' => 'Horreur', 'slug' => 'horreur'],
            ['name' => 'Aventure', 'slug' => 'aventure'],
            ['name' => 'Historique', 'slug' => 'historique'],
            ['name' => 'Romance', 'slug' => 'romance'],
            ['name' => 'Mystère', 'slug' => 'mystere'],
            ['name' => 'Policier', 'slug' => 'policier'],
            ['name' => 'Super-héros', 'slug' => 'super-heros'],
            ['name' => 'Fantastique', 'slug' => 'fantastique'],
            ['name' => 'Thriller', 'slug' => 'thriller'],
            ['name' => 'Drame', 'slug' => 'drame'],
            ['name' => 'Biographie', 'slug' => 'biographie'],
            ['name' => 'Humour', 'slug' => 'humour'],
            ['name' => 'Western', 'slug' => 'western'],
        ];

        // Insertion des données dans la base de données
        $this->db->table('genre')->insertBatch($data);
    }
}
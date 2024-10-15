<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LicenseSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Naruto', 'slug' => 'naruto', 'id_license_parent' => null],
            ['name' => 'Pokémon', 'slug' => 'pokemon', 'id_license_parent' => null],
            ['name' => 'Marvel', 'slug' => 'marvel', 'id_license_parent' => null],
            ['name' => 'DC Comics', 'slug' => 'dc-comics', 'id_license_parent' => null],
            ['name' => 'Iron Man', 'slug' => 'iron-man', 'id_license_parent' => 3],
            ['name' => 'Spider-Man', 'slug' => 'spider-man', 'id_license_parent' => 3],
            ['name' => 'X-Men', 'slug' => 'x-men', 'id_license_parent' => 3],
            ['name' => 'Batman', 'slug' => 'batman', 'id_license_parent' => 4],
            ['name' => 'Superman', 'slug' => 'superman', 'id_license_parent' => 4],
            ['name' => 'Harry Potter', 'slug' => 'harry-potter', 'id_license_parent' => null],
            ['name' => 'Lord of the Rings', 'slug' => 'lord-of-the-rings', 'id_license_parent' => null],
            ['name' => 'Star Wars', 'slug' => 'star-wars', 'id_license_parent' => null],
            ['name' => 'Transformers', 'slug' => 'transformers', 'id_license_parent' => null],
            ['name' => 'Saw', 'slug' => 'saw', 'id_license_parent' => null],
            ['name' => 'Avatar', 'slug' => 'avatar', 'id_license_parent' => null],
        ];

        // Insertion des données dans la table `license`
        $this->db->table('license')->insertBatch($data);
    }
}
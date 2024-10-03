<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Kotobukiya', 'slug' => 'kotobukiya', 'id_brand_parent' => null],
            ['name' => 'Hasbro', 'slug' => 'hasbro', 'id_brand_parent' => null],
            ['name' => 'Panini Comics', 'slug' => 'panini-comics', 'id_brand_parent' => null],
            ['name' => 'Galimard', 'slug' => 'galimard', 'id_brand_parent' => null],
            ['name' => 'Bandai', 'slug' => 'bandai', 'id_brand_parent' => null],
            ['name' => 'Hot Toys', 'slug' => 'hot-toys', 'id_brand_parent' => null],
            ['name' => 'Sideshow Collectibles', 'slug' => 'sideshow-collectibles', 'id_brand_parent' => null],
            ['name' => 'DC Collectibles', 'slug' => 'dc-collectibles', 'id_brand_parent' => null],
            ['name' => 'Funko', 'slug' => 'funko', 'id_brand_parent' => null],
            ['name' => 'McFarlane Toys', 'slug' => 'mcfarlane-toys', 'id_brand_parent' => null],
            ['name' => 'LEGO', 'slug' => 'lego', 'id_brand_parent' => null],
            ['name' => 'Square Enix', 'slug' => 'square-enix', 'id_brand_parent' => null],
            ['name' => 'NECA', 'slug' => 'neca', 'id_brand_parent' => null],
            ['name' => 'Mezco', 'slug' => 'mezco', 'id_brand_parent' => null],
            ['name' => 'Prime 1 Studio', 'slug' => 'prime-1-studio', 'id_brand_parent' => null],
        ];

        // Insertion des données dans la table `brand`
        $this->db->table('brand')->insertBatch($data);
    }
}
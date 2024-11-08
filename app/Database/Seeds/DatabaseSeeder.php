<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Appel de tous les seeders nécessaires pour les tests ou la base de données
        $this->call('UserSeeder');
        $this->call('BrandSeeder');
        $this->call('LicenseSeeder');
        $this->call('TypeSeeder');
        $this->call('GenreSeeder');
        $this->call('ItemSeeder');
    }
}
<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use DateTime;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Naruto Shippuden - Figurine Naruto Uzumaki',
                'slug' => 'naruto-uzumaki-figurine',
                'description' => 'Une superbe figurine de Naruto Uzumaki issue de la série Naruto Shippuden.',
                'price' => 39.99,
                'release_date' => '2023-07-15',
                'active' => 1,
                'id_license' => 1, // Naruto
                'id_brand' => 1, // Kotobukiya
                'id_type' => 6, // Figurines
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Spider-Man: No Way Home - Blu-ray',
                'slug' => 'spider-man-no-way-home-bluray',
                'description' => 'Blu-ray du film Spider-Man: No Way Home avec des bonus exclusifs.',
                'price' => 24.99,
                'release_date' => '2022-03-17',
                'active' => 1,
                'id_license' => 6, // Spider-Man (Marvel)
                'id_brand' => 2, // Hasbro
                'id_type' => 10, // Bluray
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Harry Potter - Livre 1: à l\'école des sorciers',
                'slug' => 'harry-potter-livre-1',
                'description' => 'Le premier livre de la célèbre saga Harry Potter.',
                'price' => 19.99,
                'release_date' => '1997-06-26',
                'active' => 1,
                'id_license' => 10, // Harry Potter
                'id_brand' => 4, // Galimard
                'id_type' => 1, // Livres
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Marvel - Figurine Iron Man',
                'slug' => 'iron-man-figurine',
                'description' => 'Figurine articulée de Iron Man, inspirée de l’univers Marvel.',
                'price' => 59.99,
                'release_date' => '2021-11-20',
                'active' => 1,
                'id_license' => 5, // Iron Man (Marvel)
                'id_brand' => 3, // Panini Comics
                'id_type' => 6, // Figurines
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Star Wars - DVD de la saga originale',
                'slug' => 'star-wars-dvd-saga-originale',
                'description' => 'La trilogie originale de Star Wars en DVD.',
                'price' => 49.99,
                'release_date' => '2004-09-21',
                'active' => 1,
                'id_license' => 12, // Star Wars
                'id_brand' => 5, // Bandai
                'id_type' => 8, // DVD
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'LEGO Star Wars - X-Wing Fighter',
                'slug' => 'lego-star-wars-x-wing-fighter',
                'description' => 'Le célèbre X-Wing Fighter en version LEGO, inspiré de l’univers Star Wars.',
                'price' => 89.99,
                'release_date' => '2023-05-04',
                'active' => 1,
                'id_license' => 12, // Star Wars
                'id_brand' => 11, // LEGO
                'id_type' => 6, // Figurines (ou jouets si plus adapté)
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Pokémon - Peluche Pikachu',
                'slug' => 'pokemon-peluche-pikachu',
                'description' => 'Peluche officielle de Pikachu, le célèbre Pokémon.',
                'price' => 19.99,
                'release_date' => '2022-12-01',
                'active' => 1,
                'id_license' => 12, // Pokémon
                'id_brand' => 2, // Hasbro
                'id_type' => 7, // Jouets
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'The Lord of the Rings - Coffret Bluray Édition Collector',
                'slug' => 'lord-of-the-rings-coffret-bluray',
                'description' => 'Coffret collector Bluray de la trilogie Le Seigneur des Anneaux.',
                'price' => 99.99,
                'release_date' => '2021-11-15',
                'active' => 1,
                'id_license' => 11, // Lord of the Rings
                'id_brand' => 4, // Galimard
                'id_type' => 10, // Bluray
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Dragon Ball Z - Figurine Goku',
                'slug' => 'figurine-goku-dragon-ball-z',
                'description' => 'Figurine articulée de Goku, héros emblématique de Dragon Ball Z.',
                'price' => 45.99,
                'release_date' => '2021-05-10',
                'active' => 1,
                'id_license' => 12, // Dragon Ball Z
                'id_brand' => 1, // Kotobukiya
                'id_type' => 6, // Figurines
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Assassin’s Creed - Livre: Renaissance',
                'slug' => 'assassins-creed-livre-renaissance',
                'description' => 'Roman basé sur le jeu vidéo Assassin’s Creed.',
                'price' => 22.99,
                'release_date' => '2010-10-20',
                'active' => 1,
                'id_license' => 13, // Assassin's Creed
                'id_brand' => 4, // Galimard
                'id_type' => 1, // Livres
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Transformers - Figurine Optimus Prime',
                'slug' => 'figurine-optimus-prime',
                'description' => 'Figurine d’Optimus Prime, le leader des Autobots.',
                'price' => 59.99,
                'release_date' => '2021-11-15',
                'active' => 1,
                'id_license' => 11, // Transformers
                'id_brand' => 2, // Hasbro
                'id_type' => 6, // Figurines
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Star Wars - Jeu Vidéo Jedi: Fallen Order',
                'slug' => 'jeu-video-jedi-fallen-order',
                'description' => 'Jeu vidéo Star Wars: Jedi: Fallen Order sur PS4.',
                'price' => 39.99,
                'release_date' => '2019-11-15',
                'active' => 1,
                'id_license' => 12, // Star Wars
                'id_brand' => 3, // Panini Comics
                'id_type' => 7, // Jeux Vidéo
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Lord of the Rings - DVD: La Communauté de l’Anneau',
                'slug' => 'lotr-dvd-la-communaute-de-lanneau',
                'description' => 'DVD de La Communauté de l’Anneau, premier film de la trilogie.',
                'price' => 29.99,
                'release_date' => '2002-08-06',
                'active' => 1,
                'id_license' => 11, // Lord of the Rings
                'id_brand' => 5, // Bandai
                'id_type' => 8, // DVD
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'The Witcher - Livre: Le Dernier Vœu',
                'slug' => 'witcher-livre-dernier-voeu',
                'description' => 'Premier livre de la saga The Witcher.',
                'price' => 24.99,
                'release_date' => '1993-05-01',
                'active' => 1,
                'id_license' => 14, // The Witcher
                'id_brand' => 4, // Galimard
                'id_type' => 1, // Livres
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Batman - Figurine Batman',
                'slug' => 'figurine-batman',
                'description' => 'Figurine de Batman, le célèbre super-héros de DC Comics.',
                'price' => 49.99,
                'release_date' => '2020-06-01',
                'active' => 1,
                'id_license' => 4, // Batman
                'id_brand' => 2, // Hasbro
                'id_type' => 6, // Figurines
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'One Piece - Manga: Volume 1',
                'slug' => 'one-piece-manga-volume-1',
                'description' => 'Le premier volume du célèbre manga One Piece.',
                'price' => 9.99,
                'release_date' => '1997-07-22',
                'active' => 1,
                'id_license' => 15, // One Piece
                'id_brand' => 1, // Kotobukiya
                'id_type' => 3, // Manga
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insertion des données dans la table `object`
        $this->db->table('item')->insertBatch($data);
    }
}
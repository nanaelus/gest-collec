<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableCollection extends Migration
{
    public function up()
    {
        // Création de la table pret
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        // Ajout de la clé primaire pour la table pret
        $this->forge->addKey('id', true); // true signifie clé primaire
        // Ajout de la clé étrangère pour id_user
        $this->forge->addForeignKey('id_user', 'TableUser', 'id', 'CASCADE', 'CASCADE');
        // Création de la table
        $this->forge->createTable('loan');

        // Création de la table collectionner
        $this->forge->addField([
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_item' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_loan' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ]
        ]);
        // Ajout de la clé primaire composite
        $this->forge->addKey(['id_user', 'id_item'], true); // true indique que c'est une clé primaire composite
        // Ajout des clés étrangères
        $this->forge->addForeignKey('id_user', 'TableUser', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_item', 'item', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_loan', 'loan', 'id', 'CASCADE', 'CASCADE');
        // Création de la table
        $this->forge->createTable('collection');
    }

    public function down()
    {
        $this->forge->dropTable('loan');
        $this->forge->dropTable('collection');
    }
}
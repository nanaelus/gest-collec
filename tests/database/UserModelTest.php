<?php

namespace database;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use App\Models\UserModel;
class UserModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $seed = 'App\Database\Seeds\DatabaseSeeder';
    protected function setUp(): void
    {
        parent::setUp();
        // Disable foreign key checks
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');

        // Truncate the table before each test
        $this->db->table('TableUser')->truncate();

        // Re-enable foreign key checks
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // Désactiver la vérification des clés étrangères
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');

        // Truncature des tables
        $this->db->table('TableUser')->truncate();
        $this->db->table('collection')->truncate();

        // Réactiver la vérification des clés étrangères
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }

    public function testCreateUser()
    {
        $model = new UserModel();
        $data = [
            'username' => 'testuser',
            'email'    => 'testuser@example.com',
            'password' => 'password123',
            'id_permission' => 1,
        ];

        $result = $model->createUser($data);
        $this->assertTrue($result > 0); // Vérifie que l'ID de l'utilisateur créé est supérieur à 0

        // Vérifie que l'utilisateur a bien été créé dans la base de données
        $this->seeInDatabase('TableUser', ['email' => 'testuser@example.com']);
    }

    public function testUpdateUser()
    {
        $model = new UserModel();
        $data = [
            'username' => 'testuser',
            'email'    => 'testuser@example.com',
            'password' => 'password123',
            'id_permission' => 1,
        ];
        $model->createUser($data); // Crée l'utilisateur pour le test

        $updatedData = [
            'username' => 'updateduser',
            'password' => 'newpassword123', // Mettre à jour le mot de passe
        ];

        $user = $model->getUserById(1); // Récupère l'utilisateur créé
        $model->updateUser($user['id'], $updatedData); // Met à jour l'utilisateur

        // Vérifie que le nom d'utilisateur a été mis à jour
        $this->seeInDatabase('TableUser', ['username' => 'updateduser']);
        // Vérifie que le mot de passe a été haché (donc différent de 'newpassword123')
        $this->assertNotEquals('newpassword123', $model->getUserById(1)['password']);
    }

    public function testDeleteUser()
    {
        $model = new UserModel();
        $data = [
            'username' => 'testuser',
            'email'    => 'testuser@example.com',
            'password' => 'password123',
            'id_permission' => 1,
        ];
        $model->createUser($data); // Crée l'utilisateur pour le test

        $user = $model->getUserById(1);
        $model->deleteUser($user['id']);

// Vérifiez si la colonne `deleted_at` est non-nulle après la suppression, si vous utilisez le soft delete
        $this->seeInDatabase('TableUser', ['id' => $user['id'], 'deleted_at !=' => null]);

    }

    public function testVerifyLogin()
    {
        $model = new UserModel();
        $data = [
            'username' => 'testuser',
            'email'    => 'testuser@example.com',
            'password' => 'password123',
            'id_permission' => 1,
        ];
        $model->createUser($data); // Crée l'utilisateur pour le test

        // Test de la connexion avec des informations valides
        $user = $model->verifyLogin('testuser@example.com', 'password123');
        $this->assertNotFalse($user); // Vérifie que l'utilisateur a été retourné

        // Test de la connexion avec des informations invalides
        $user = $model->verifyLogin('testuser@example.com', 'wrongpassword');
        $this->assertFalse($user); // Vérifie que false est retourné
    }

    public function testGetAllUsers()
    {
        $model = new UserModel();
        $data1 = [
            'username' => 'user1',
            'email'    => 'user1@example.com',
            'password' => 'password123',
            'id_permission' => 1,
        ];
        $data2 = [
            'username' => 'user2',
            'email'    => 'user2@example.com',
            'password' => 'password456',
            'id_permission' => 1,
        ];

        $model->createUser($data1);
        $model->createUser($data2);

        $users = $model->getAllUsers();
        $this->assertCount(2, $users); // Vérifie qu'il y a 2 utilisateurs dans la base de données
    }

    public function testGetUserById()
    {
        $model = new UserModel();
        $data = [
            'username' => 'testuser',
            'email'    => 'testuser@example.com',
            'password' => 'password123',
            'id_permission' => 1,
        ];
        $model->createUser($data); // Crée l'utilisateur

        $userId = $model->insertID(); // Récupère l'ID de l'utilisateur créé
        $user = $model->getUserById($userId); // Utilisez cet ID au lieu de supposer que c'est 1
        $this->assertEquals('testuser', $user['username']); // Vérification

    }

    public function testCountUserByPermission()
    {
        $model = new UserModel();
        $data1 = [
            'username' => 'user1',
            'email'    => 'user1@example.com',
            'password' => 'password123',
            'id_permission' => 1,
        ];
        $data2 = [
            'username' => 'user2',
            'email'    => 'user2@example.com',
            'password' => 'password456',
            'id_permission' => 2,
        ];

        $model->createUser($data1);
        $model->createUser($data2);

        $result = $model->countUserByPermission();
        $this->assertCount(2, $result); // Vérifie qu'il y a 2 permissions dans le résultat
    }

    public function testActivateUser()
    {
        $model = new UserModel();
        $data = [
            'username' => 'testuser',
            'email'    => 'testuser@example.com',
            'password' => 'password123',
            'id_permission' => 1,
        ];
        $model->createUser($data); // Crée l'utilisateur pour le test

        $userId = $model->insertID();
        $model->deleteUser($userId); // Supprime l'utilisateur

        // Vérifie que 'deleted_at' a bien été rempli (soft delete)
        $this->seeInDatabase('TableUser', ['id' => $userId, 'deleted_at !=' => null]);

        // Réactive l'utilisateur (annule le soft delete)
        $model->activateUser($userId);

        // Vérifie que l'utilisateur est à nouveau actif
        $this->seeInDatabase('TableUser', ['id' => $userId, 'deleted_at' => null]);
    }

}
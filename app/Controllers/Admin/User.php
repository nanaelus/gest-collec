<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class User extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];
    public function getindex($id = null) {
        $um = Model("UserModel");
        if ($id == null) {
            $users = $um->getPermissions();
            return $this->view("/admin/user/index.php",['users' => $users], true);
        } else {
            $permissions = Model("UserPermissionModel")->getAllPermissions();
            if ($id == "new") {
                return $this->view("/admin/user/user",["permissions" => $permissions], true);
            }
            $utilisateur = $um->getUserById($id);
            if ($utilisateur) {
                return $this->view("/admin/user/user", ["utilisateur" => $utilisateur, "permissions" => $permissions ], true);
            } else {
                $this->error("L'ID de l'utilisateur n'existe pas");
                $this->redirect("/admin/user");
            }
        }
    }

    public function postupdate() {
        $data = $this->request->getPost();
        $um = Model("UserModel");

        // Vérifier si des fichiers ont été soumis dans le formulaire
        $file = $this->request->getFile('profile_image'); // 'profile_image' est le nom du champ dans le formulaire
        if ($file && $file->isValid()) {
            // Préparer les données du média
            $mediaData = [
                'entity_type' => 'user',
                'entity_id'   => $data['id'],   // Utiliser le nouvel ID de l'utilisateur
            ];

            // Utiliser la fonction upload_file() pour gérer l'upload et les données du média
            $filePath = upload_file($file, 'avatar', $data['username'], $mediaData);

            if ($filePath === false) {
                $this->error("Une erreur est survenue lors de l'upload de l'image.");
                return $this->redirect("/admin/user");
            }
        }


        if ($um->updateUser($data['id'], $data)) {
            $this->success("Utilisateur à bien été modifié");
        } else {
            $this->error("Une erreur est survenue");
        }
        $this->redirect("/admin/user");
    }

    public function postcreate() {
        $data = $this->request->getPost();
        $um = Model("UserModel");

        // Créer l'utilisateur et obtenir son ID
        $newUserId = $um->createUser($data);

        // Vérifier si la création a réussi
        if ($newUserId) {
            // Vérifier si des fichiers ont été soumis dans le formulaire
            $file = $this->request->getFile('profile_image'); // 'profile_image' est le nom du champ dans le formulaire
            if ($file && $file->isValid()) {
                // Préparer les données du média
                $mediaData = [
                    'entity_type' => 'user',
                    'entity_id'   => $newUserId,   // Utiliser le nouvel ID de l'utilisateur
                ];

                // Utiliser la fonction upload_file() pour gérer l'upload et les données du média
                $filePath = upload_file($file, 'avatar', $data['username'], $mediaData);

                if ($filePath === false) {
                    $this->error("Une erreur est survenue lors de l'upload de l'image.");
                    return $this->redirect("/admin/user/new");
                }
            }
            $this->success("L'utilisateur à bien été ajouté.");
            $this->redirect("/admin/user");
        } else {
            $errors = $um->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
            $this->redirect("/admin/user/new");
        }
    }

    public function getdeactivate($id){
        $um = Model('UserModel');
        if ($um->deleteUser($id)) {
            $this->success("Utilisateur désactivé");
        } else {
            $this->error("Utilisateur non désactivé");
        }
        $this->redirect('/admin/user');
    }

    public function getactivate($id){
        $um = Model('UserModel');
        if ($um->activateUser($id)) {
            $this->success("Utilisateur activé");
        } else {
            $this->error("Utilisateur non activé");
        }
        $this->redirect('/admin/user');
    }

    /**
     * Renvoie pour la requete Ajax les stocks fournisseurs rechercher par SKU ( LIKE )
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function postSearchUser()
    {
        $UserModel = model('App\Models\UserModel');

        // Paramètres de pagination et de recherche envoyés par DataTables
        $draw        = $this->request->getPost('draw');
        $start       = $this->request->getPost('start');
        $length      = $this->request->getPost('length');
        $searchValue = $this->request->getPost('search')['value'];

        // Obtenez les informations sur le tri envoyées par DataTables
        $orderColumnIndex = $this->request->getPost('order')[0]['column'] ?? 0;
        $orderDirection = $this->request->getPost('order')[0]['dir'] ?? 'asc';
        $orderColumnName = $this->request->getPost('columns')[$orderColumnIndex]['data'] ?? 'id';


        // Obtenez les données triées et filtrées
        $data = $UserModel->getPaginatedUser($start, $length, $searchValue, $orderColumnName, $orderDirection);

        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $UserModel->getTotalUser();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $UserModel->getFilteredUser($searchValue);

        $result = [
            'draw'            => $draw,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data'            => $data,
        ];
        return $this->response->setJSON($result);
    }
}
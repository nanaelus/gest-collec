<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class User extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['collaborateur','utilisateur', 'administrateur'];
    public function getindex($id = null)
    {
        if($id == null) {
            return $this->knife('user/index');
        }
        if($id == $this->session->user->id) {
            $utilisateur = model('UserModel')->getUserById($id);
            return $this->view('user/user', ['utilisateur' => $utilisateur]);
        } else {
            $utilisateur = model('UserModel')->getUserById($id);
            $this->redirect('user/' . $this->session->user->id);
        }
    }

    public function postupdate()
    {
        $data = $this->request->getPost();
        $um = Model("UserModel");
        $utilisateur = model('UserModel')->getUserById($data['id']);

        // Vérifier si un fichier a été soumis dans le formulaire
        $file = $this->request->getFile('profile_image'); // 'profile_image' est le nom du champ dans le formulaire
        // Si un fichier a été soumis
        if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
            // Récupération du modèle MediaModel
            $mm = Model('MediaModel');
            // Récupérer l'ancien média avant l'upload
            $old_media = $mm->getMediaByEntityIdAndType($data['id'], 'user');

            // Préparer les données du média pour le nouvel upload
            $mediaData = [
                'entity_type' => 'user',
                'entity_id' => $data['id'],   // Utiliser l'ID de l'utilisateur
            ];

            // Utiliser la fonction upload_file() pour gérer l'upload et enregistrer les données du média
            $uploadResult = upload_file($file, 'avatar', $data['username'], $mediaData, true, ['image/jpeg', 'image/png', 'image/jpg']);

            // Vérifier le résultat de l'upload
            if (is_array($uploadResult) && $uploadResult['status'] === 'error') {
                // Afficher un message d'erreur détaillé et rediriger
                $this->error("Une erreur est survenue lors de l'upload de l'image : " . $uploadResult['message']);
                $this->redirect("/user/" . $data['id']);
            }

            // Si l'upload est un succès, suppression de l'ancien média
            if ($old_media) {
                $mm->getDeleteMedia($old_media[0]['id']);
            }
        }

        // Mise à jour des informations utilisateur dans la base de données
        if ($um->updateUser($data['id'], $data)) {
            // Si la mise à jour réussit
            $this->success("L'utilisateur a bien été modifié.");
        } else {
            // Si une erreur survient lors de la mise à jour
            $this->error("Une erreur est survenue lors de la modification de l'utilisateur.");
        }

        // Redirection vers la page des utilisateurs après le traitement
        $this->redirect("/item");
    }
}

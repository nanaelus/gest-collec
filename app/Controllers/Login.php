<?php

namespace App\Controllers;

class Login extends BaseController
{
    protected $require_auth = false;

    public function getindex(): string
    {
        return view('/login/login');
    }

    public function postindex()
    {
        // Traitement de la connexion
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        // Logique de vérification des informations d'identification
        $um = Model('UserModel');
        $user = $um->verifyLogin($email,$password);
        if ($user) {
            if ($user['deleted_at'] != NULL){
                return view('/login/login', ['error' => 'Compte désactivé. Veuillez contacter un administrateur']);
            }
            $this->session->set('user', $user);
            $redirectUrl = $this->session->get('redirect_url') ?? '/';
            $this->session->remove('redirect_url');
            return $this->redirect($redirectUrl);
        } else {
            // Gérer l'échec de l'authentification
            return view('/login/login', ['error' => 'Identifiants incorrects']);
        }
    }

    public function getregister() {
        $flashData = session()->getFlashdata('data');

        // Préparer les données à passer à la vue
        $data = [
            'errors' => $flashData['errors'] ?? null,
            // Autres données à passer à la vue
        ];
        return view('/login/register',$data);
    }

    public function postregister() {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $username = $this->request->getPost('username');
        $data = ['username' => $username, 'email' => $email, 'password' => $password, 'id_permission' => 3];
        $um = Model('UserModel');
        if (!$um->createUser($data)) {
            $errors = $um->errors();
            $data = ['errors' => $errors];
            return $this->redirect("/login/register", $data);
        }
        return $this->redirect("/login");
    }

    public function getlogout() {
        $this->logout();
        return $this->redirect("/login");
    }
}
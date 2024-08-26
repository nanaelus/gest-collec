<?php

namespace App\Controllers;

class Login extends BaseController
{
    protected $require_auth = false;

    public function getIndex(): string
    {
        return view('/login/login');
    }

    public function postIndex()
    {
        // Traitement de la connexion
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        // Logique de vérification des informations d'identification
        $um = Model('UserModel');
        $user = $um->verifyLogin($email, $password);

        if ($user) {
            $this->session->set('user', $user);
            $redirectUrl = $this->session->get('redirect_url') ?? '/';
            $this->session->remove('redirect_url');
            return $this->redirect($redirectUrl);
        } else {
            // Gérer l'échec de l'authentification
            return view('/login/login', ['error' => 'Identifiants incorrects']);
        }
    }

    public function getRegister() {
        return view('/login/register');
    }

    public function postRegister()
    {
        $email =$this->request->getPost('email');
        $username =$this->request->getPost('username');
        $password =$this->request->getPost('password');
        $um = Model('UserModel');
        $data = ['username' => $username, 'email' => $email, 'password' => $password, 'id_permission' => 3];
        if(!$um->createUser($data)) {
            $errors = $um->errors();
            return $this->view('Login/Register', ['errors' => $errors]);
        }
        return $this->redirect("/Login");

    }
    private function authenticate($email, $password)
    {
        // Implémentez la logique pour vérifier les informations d'identification contre la base de données
        // Retourner l'utilisateur s'il est authentifié, sinon null
    }
}

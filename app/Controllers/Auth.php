<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
    protected $format = 'json';

    public function postgeneratetoken() {
        $email = $this->request->getPost('mail');
        $password = $this->request->getPost('password');

        $um = model('UserModel');
        $user = $um->verifyLogin($email, $password);

        if(!$user) {
            return $this->failUnauthorized('Invalid credentials');
        }

        $token =generateToken($user['id']);
        return $this->respond(['token' => $token]);
    }

    public function getportecteddata() {
        $token = $this->request->getHeaderLine('Authorization');

        if($token && preg_match('/Bearer\s(\S+)/', $token, $matches)) {
            $userId = validateToken($matches[1]);

            if($userId) {
                return $this->respond(['message' => 'Access granted', 'data' => 'This is protected data']);
            }
        }
        return $this->failUnauthorized('Invalid or expired token');
    }
}
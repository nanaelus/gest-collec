<?php

namespace App\Controllers\Api;

use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Migration extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function getindex()
    {
        $token = $this->request->getHeaderLine('Authorization');// Récupère le token appellé authorization dans le header
        $staticToken = getenv('ENV_TOKEN'); // Token défini dans .env
        if($token !== $staticToken) {
            return $this->failUnauthorized('Token Invalide');
        }
        $migrations = Services::migrations();// $migration est un objet qui va contenir toutes les infos necessaires pour faire les migrations
        try {
            //Executer toutes les migrations
            $migrations->latest();

            //Retourner un message de succès avec le code 200
            return $this->respond(['message' => "Migrations exécutées avec succés !"], 200);
        } catch (\Exception $e) {
            //retourner le message d'erreur avec un code 500
            return $this->respond(['message' => "Erreur lors de l'éxecution des migrations : ".$e->getMessage()], 500);
        }
    }
}
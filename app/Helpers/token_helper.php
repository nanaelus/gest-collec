<?php

use App\Models\ApiTokenModel;
use CodeIgniter\I18n\Time;

function generateToken($userId) {
    $token = bin2hex(random_bytes(32)); // Crée un token sécurisé
    $expiresAt = Time::now()->addHours(24); // Expire dans 24heures

    // Sauvegarder le token en BDD
    $apiTokenModel= new ApiTokenModel();
    $apiTokenModel->insert([
        'user_id' => $userId,
        'token' => $token,
        'expires_at' => $expiresAt
    ]);

    return $token;
}

function validateToken($token) {
    $apiTokenModel= new ApiTokenModel();
    $tokenData = $apiTokenModel->where('token', $token)->first();

    if ($tokenData && $tokenData['expires_at'] > Time::now()) {
        return $tokenData['userId'];  //Retourne l'ID utilisateur si valide
    }

    return null; // Token invalide ou expiré
}
<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Chat extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['collaborateur','utilisateur', 'administrateur'];
    public function getindex()
    {
        $um = Model('UserModel');
        $users = $um->getAllUsers();
        return $this->view('message/chat',['users'=>$users]);
    }

    public function postajaxsendmessage() {
        $data = $this->request->getPost();
        if(Model('InstantMessageModel')->insertMessage($data)) {
            return $this->response->setJSON($data);
        }
        return false;
    }

    public function getajaxmessagehistory() {
        $data = $this->request->getGet();
        return $this->response->setJSON(Model('InstantMessageModel')->getMessageHistory($data['id_receiver'], $data['id_sender']));
    }

    public function getajaxlastmessagehistory() {
        $data = $this->request->getGet();
        return $this->response->setJSON(Model('InstantMessageModel')->getLastMessageHistory($data['id_receiver'], $data['id_sender'], $data['limit'], $data['offset'], $data['timestamp']));
    }
}
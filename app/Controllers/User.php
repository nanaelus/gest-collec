<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class User extends BaseController
{
    protected $require_auth = false;
    public function getindex()
    {
        if(isset($this->session->user)) {
            return $this->view('/login/user', []);
        } else {
            $this->redirect('/login');
        }
    }
}

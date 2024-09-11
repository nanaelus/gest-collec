<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;

class Home extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];
    public function getindex() {
        $this->redirect('/admin/dashboard');
    }
}
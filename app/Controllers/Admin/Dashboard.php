<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    protected $title      = 'Tableau de Bord';
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];

    public function getindex(): string
    {
        $um = Model("App\Models\UserModel");
        $infosUser = $um->countUserByPermission();
        return $this->view('/admin/dashboard/index.php', ['infosUser' => $infosUser], true);
    }

    public function gettest() {
        $this->error("Oh");
        $this->message("Oh");
        $this->success("Oh");
        $this->warning("Oh");
        $this->error("Oh");
        $this->redirect("/admin/dashboard");
    }

    public function gettest2() {
        $um = Model("App\Models\UserModel");
        print_r($um->countUserByPermission());
    }
}
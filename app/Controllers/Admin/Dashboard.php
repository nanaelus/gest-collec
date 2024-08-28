<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    protected $title      = 'Tableau de Bord';
    protected $require_auth = true;
    public function getindex(): string
    {
        return $this->view('/admin/dashboard/index.php', [], true);
    }

    public function gettest() {
        $this->error("Oh");
        $this->message("Oh");
        $this->success("Oh");
        $this->warning("Oh");
        $this->error("Oh");
        $this->redirect("/admin/dashboard");
    }
}
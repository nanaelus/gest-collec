<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    protected $title      = 'Réappro. fournisseurs';
    protected $breadcrumb = [['text' => 'Réapprovisionnements','url' => '/Supplierorders']];
    protected $require_auth = true;
    public function getIndex(): string
    {
        $this->addBreadcrumb('Réapprovisionnement','#');
        $this->addBreadcrumb('Réappro. fournisseurs',['Supplierorders']);
        return $this->view('/admin/dashboard/index.php', [], true);
    }

    public function getTest() {
        $this->error("Oh");
        $this->message("Oh");
        $this->success("Oh");
        $this->warning("Oh");
        $this->error("Oh");
        $this->redirect("/Admin/Dashboard");
    }
}
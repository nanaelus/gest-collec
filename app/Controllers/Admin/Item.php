<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Item extends BaseController
{
    protected $require_auth = true;
    protected $breadcrumb = [['text' =>'Tableau de Bord', 'url' => '/admin/dashboard']];
    public function getindex() {
        return $this->view('admin/item/index', [], true);
    }

    public function gettype() {
        $this->title="Gestion des Types";
        $this->addBreadcrumb('Objets', '/admin/item');
        $this->addBreadcrumb('Types', '');
        return $this->view('admin/item/type', [], true);
    }
}
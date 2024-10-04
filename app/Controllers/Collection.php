<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Collection extends BaseController
{
    protected $require_auth =true;

    protected $requiredPermissions =['administrateur', 'collaborateur', 'utilisateur'];

    public function getindex()
    {

    }

    public function getaddcollection($id_item) {
        if ($id_item && ($this->session->user->id)) {
            if(model('CollectionModel')->insertCollection($id_item, ($this->session->user->id))) {
                $this->success('Objet ajouté à votre collection!');
            } else {
                $this->error("L'ajout n'a pas fonctionné.");
            }
            $item =model('ItemModel')->getItem($id_item);
            $slug = $item['slug'];
        } else {
            $slug =null;
            $this->error("Il manque une information");
        }
        $this->redirect('/item/' . $slug);
    }

    public function getremovecollection($id_item) {
        if ($id_item && ($this->session->user->id)) {
            if(model('CollectionModel')->deleteCollection($id_item, ($this->session->user->id))) {
                $this->success('Objet supprimé de votre collection!');
            } else {
                $this->error("La suppression n'a pas fonctionné.");
            }
            $item =model('ItemModel')->getItem($id_item);
            $slug = $item['slug'];
        } else {
            $slug =null;
            $this->error("Il manque une information");
        }
        $this->redirect('/item/' . $slug);
    }
}
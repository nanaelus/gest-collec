<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Collection extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['collaborateur','utilisateur', 'administrateur'];
    protected $noAuthMethods = ['getindex'];
    public function getindex($username = null)
    {
        $this->title='Collection';
        $im = model('ItemModel');
        $data = $this->request->getGet();
        if (!$username && isset($this->session->user->username)) {
            $data['username'] = $this->session->user->username;
        } else {
            $data['username'] = $username;
        }
        if($data['username'] == "") {
            $this->redirect('/login');
        }
        // Définir le nombre d'éléments par page
        $perPage = 8;
        $genres = model('ItemGenreModel')->getAllGenres();
        $types = model('ItemTypeModel')->getAllTypes();
        $licenses = model('ItemLicenseModel')->getAllLicenses();
        $brands = model('ItemBrandModel')->getAllBrands();
        $allitems = $im->getAllItemsFiltered($data,1, $perPage);
        // Récupérer le pager pour générer les liens de pagination
        $pager = $im->pager;
        return $this->view('item/index', [
            'items' => $allitems,
            'genres' => $genres,
            'types' => $types,
            'licenses' => $licenses,
            'brands' => $brands,
            'data' => $data,
            'pager' => $pager
        ]);
    }

    public function getaddcollection($id_item = null) {
        if ($id_item && isset($this->session->user->id)) {
            if(model('CollectionModel')->insertCollection($this->session->user->id , $id_item)) {
                $this->success("Objet ajouté à votre collection");
            } else {
                $this->error("L'ajout n'a pas fonctionné.");
            }
            $item = model("ItemModel")->getItem($id_item);
            $slug = $item['slug'];
        }  else {
            $slug = null;
            $this->error("Il manque une information");
        }
        $this->redirect("/item/" . $slug);
    }

    public function getremovecollection($id_item = null) {
        if ($id_item && isset($this->session->user->id)) {
            if(model('CollectionModel')->deleteCollection($this->session->user->id , $id_item)) {
                $this->success("Objet retirer de votre collection");
            } else {
                $this->error("L'objet n'est pas retiré.");
            }
            $item = model("ItemModel")->getItem($id_item);
            $slug = $item['slug'];
        }  else {
            $slug = null;
            $this->error("Il manque une information");
        }
        $this->redirect("/item/" . $slug);
    }
    public function gettest() {
        return $this->view('welcome_message.php');
    }
}
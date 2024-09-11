<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ItemGenreModel;

class Item extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];
    protected $breadcrumb =  [['text' => 'Tableau de Bord','url' => '/admin/dashboard']];
    public function getindex(){
        return $this->view('admin/item/index', [], true);
    }


    // Fonctions concernant les types
    public function gettype(){
        $this->title="Gestion des Types";
        $this->addBreadcrumb('Objets','/admin/item');
        $this->addBreadcrumb('Types','');
        $itm = Model('ItemTypeModel');
        $all_types = $itm->getAllTypes();
        return $this->view('admin/item/type', ['all_types' => $all_types], true);
    }
    public function postcreatetype() {
        $data = $this->request->getPost();
        $itm = Model('ItemTypeModel');
        if($itm->insertType($data)){
            $this->success('Type créé!');
        } else {
            $this->error('Erreur lors de la création du typeuh!');
        }
        $this->redirect('/admin/item/type');
    }

    public function getdeletetype($id) {
        $itm = Model('ItemTypeModel');
        if($itm->deleteType($id)) {
            $this->success('Type supprimé avec succès!');
        } else {
            $this->error('Erreur lors de la suppression du typeuh!');
        }
        return $this->redirect('/admin/item/type');
    }

    //Fonctions concernant les marques
    public function getbrand() {
        $this->title="Gestion des Marques";
        $this->addBreadcrumb('Objets','/admin/item');
        $this->addBreadcrumb('Marques','');
        $ibm = Model('ItemBrandModel');
        $all_brands = $ibm->getAllBrands();
        return $this->view('admin/item/brand', ['all_brands'=>$all_brands], true);
    }

    public function postcreatebrand(){
        $data = $this->request->getPost();
        $ibm = Model('ItemBrandModel');
        if($ibm->insertBrand($data)){
            $this->success("La marque a été ajoutée avec succès!");
        } else {
            $this->error("Erreur lors de l'ajout du marque!");
        }
        $this->redirect('/admin/item/brand');
    }

    public function getdeletebrand($id)
    {
        $ibm = Model('ItemBrandModel');
        if($ibm->deleteBrand($id)) {
            $this->success("La marque a bien été supprimée!");
        } else {
            $this->error("Erreur lors de la suppression du marque!");
        }
        return $this->redirect('/admin/item/brand');
    }

    //Fonctions concernant les genres
    public function getgenre() {
        $this->title="Gestion des Genres";
        $this->addBreadcrumb('Objets','/admin/item');
        $this->addBreadcrumb('Genres','');
        $igm = Model('ItemGenreModel');
        $all_genres = $igm->getAllGenres();
        return $this->view('admin/item/genre', ['all_genres' => $all_genres], true);
    }

    public function postcreategenre(){
        $data = $this->request->getPost();
        $igm = Model('ItemGenreModel');
        if($igm->insertGenre($data)){
            $this->success('Le genre a été ajouté avec succès');
        } else {
            $this->error("Erreur lors de l'ajout du genre!");
        }
        return $this->redirect('/admin/item/genre');
    }

    public function getdeletegenre($id) {
        $itm = Model('ItemGenreModel');
        if($itm->deletegenre($id)) {
            $this->success('Genre supprimé avec succès!');
        } else {
            $this->error('Erreur lors de la suppression du genre!');
        }
        return $this->redirect('/admin/item/genre');
    }

    //Fonctions concernant les licences
    public function getlicense() {
        $this->title="Gestion des Licences";
        $this->addBreadcrumb('Objets','/admin/item');
        $this->addBreadcrumb('Licences','');
        $ilm = Model('ItemLicenseModel');
        $all_licenses = $ilm->getAllLicenses();
        return $this->view('admin/item/license', ['all_licenses'=>$all_licenses], true);
    }

    public function postcreatelicense(){
        $data = $this->request->getPost();
        $ilm = Model('ItemLicenseModel');
        if($ilm->insertLicense($data)){
            $this->success("La licence a été ajouté avec succès");
        } else {
            $this->error("Erreur lors de l'ajout du licence!");
        }
        return $this->redirect('/admin/item/license');
    }

    public function getdeletelicense($id) {
        $ilm = Model('ItemLicenseModel');
        if($ilm->deleteLicense($id)) {
            $this->success("La licence a été supprimée avec succès");
        } else {
            $this->error("Erreur lors de la suppression du licence!");
        }
        return $this->redirect('/admin/item/license');
    }

    //Fonction pour le Java Scritp


    public function gettotalitembygenre()
    {
        $data = $this->request->getGet("id");
        $tibg = Model('ItemGenreItemModel');
        return json_encode($tibg->totalItemByGenre($data));
    }

    public function gettotalitembybrand()
    {
        $data = $this->request->getGet("id");
        $ibm = Model('ItemModel');
        return json_encode($ibm->totalItemByBrand($data));
    }

    public function gettotalitembylicense()
    {
        $data = $this->request->getGet('id');
        $ilm = Model('ItemModel');
        return json_encode($ilm->totalItemByLicense($data));
    }

    public function gettotalitembytype()
    {
        $data =$this->request->getGet('id');
        $itm = Model('ItemModel');
        return json_encode($itm->totalItemByType($data));
    }

    public function postsearchdatatable()
    {
        $model_name = $this->request->getPost('model');
        $model = model($model_name);

        // Paramètres de pagination et de recherche envoyés par DataTables
        $draw        = $this->request->getPost('draw');
        $start       = $this->request->getPost('start');
        $length      = $this->request->getPost('length');
        $searchValue = $this->request->getPost('search')['value'];

        // Obtenez les informations sur le tri envoyées par DataTables
        $orderColumnIndex = $this->request->getPost('order')[0]['column'];
        $orderDirection = $this->request->getPost('order')[0]['dir'];
        $orderColumnName = $this->request->getPost('columns')[$orderColumnIndex]['data'];

        // Obtenez les données triées et filtrées
        $data = $model->getPaginated($start, $length, $searchValue, $orderColumnName, $orderDirection);

        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $model->getTotal();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $model->getFiltered($searchValue);

        $result = [
            'draw'            => $draw,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data'            => $data,
        ];
        return $this->response->setJSON($result);
    }
}
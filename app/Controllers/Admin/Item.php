<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Item extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];
    protected $breadcrumb =  [['text' => 'Tableau de Bord','url' => '/admin/dashboard']];
    public function getindex($id = null){
        //Si j'ai un ID je suis en édition
        if ($id) {
            $genres = model('ItemGenreModel')->getAllGenres();
            $types = model('ItemTypeModel')->getAllTypes();
            $licenses = model('ItemLicenseModel')->getAllLicenses();
            $brands = model('ItemBrandModel')->getAllBrands();
            //Si mon ID est égale à "new" je suis en création
            if ($id == "new") {
                return $this->view('admin/item/item.php', ['genres' => $genres, 'types' => $types, 'licenses' => $licenses, 'brands'=> $brands], true);
            }
            $item = model('ItemModel')->getItem($id);
            if ($item) {
            return $this->view('admin/item/item.php', ['genres' => $genres, 'types' => $types, 'licenses' => $licenses, 'brands'=> $brands, 'item' => $item], true);
            } else {
                $this->error("L'ID n'existe pas");
                $this->redirect('/admin/item');
            }
        }
        return $this->view('admin/item/index', [], true);
    }

    public function posttest() {
        $data = $this->request->getPost();
        $files = $this->request->getFiles();

        return $this->view('dev-test.php', ['data' => $data, 'files' => $files]);
    }
    public function gettype(){
        $this->title="Gestion des Types";
        $this->addBreadcrumb('Objets','/admin/item');
        $this->addBreadcrumb('Types','');
        $itm = model("ItemTypeModel");
        $all_types = $itm->getAllTypes();
        return $this->view('admin/item/type', ['all_types' => $all_types], true);
    }
    public function getdeletetype($id) {
        $itm = model("ItemTypeModel");
        if ($itm->deleteType($id)) {
            $this->success("Type supprimé");
        } else {
            $this->error("Type non supprimé");
        }
        return $this->redirect('/admin/item/type');
    }
    public function postcreatetype() {
        $data = $this->request->getPost();
        $itm = Model('ItemTypeModel');
        if ($itm->insertType($data)) {
            $this->success('Type ajouté');
        } else {
            $this->error('Type non ajouté');
        }
        $this->redirect('/admin/item/type');
    }
    public function getbrand(){
        $this->title="Gestion des Marques";
        $this->addBreadcrumb('Objets','/admin/item');
        $this->addBreadcrumb('Marques','');
        $ibm = model("ItemBrandModel");
        $all_brands = $ibm->getAllBrands();
        return $this->view('admin/item/brand', ['all_brands' => $all_brands], true);
    }
    public function getdeletebrand($id) {
        $ibm = model("ItemBrandModel");
        if ($ibm->deleteBrand($id)) {
            $this->success("Marques supprimé");
        } else {
            $this->error("Marques non supprimé");
        }
        return $this->redirect('/admin/item/brand');
    }
    public function postcreatebrand() {
        $data = $this->request->getPost();
        $ibm = Model('ItemBrandModel');
        if ($ibm->insertBrand($data)) {
            $this->success('Marque ajouté');
        } else {
            $this->error('Marque non ajouté');
        }
        $this->redirect('/admin/item/brand');
    }
    public function getgenre(){
        $this->title="Gestion des Genres";
        $this->addBreadcrumb('Objets','/admin/item');
        $this->addBreadcrumb('Genres','');
        $ibm = model("ItemGenreModel");
        $all_genres = $ibm->getAllGenres();
        return $this->view('admin/item/genre', ['all_genres' => $all_genres], true);
    }
    public function getdeletegenre($id) {
        $ibm = model("ItemGenreModel");
        if ($ibm->deleteGenre($id)) {
            $this->success("Genre supprimé");
        } else {
            $this->error("Genre non supprimé");
        }
        return $this->redirect('/admin/item/genre');
    }
    public function postcreategenre() {
        $data = $this->request->getPost();
        $ibm = Model('ItemGenreModel');
        if ($ibm->insertGenre($data)) {
            $this->success('Genre ajouté');
        } else {
            $this->error('Genre non ajouté');
        }
        $this->redirect('/admin/item/genre');
    }
    public function gettotalitembygenre() {
        $id = $this->request->getGet("id");
        $igim = model('ItemGenreItemModel');
        return json_encode($igim->getTotalItemByGenreId($id));
    }
    public function gettotalitembytype() {
        $id = $this->request->getGet("id");
        $im = model('ItemModel');
        return json_encode($im->getTotalItemByTypeId($id));
    }
    public function gettotalitembylicense() {
        $id = $this->request->getGet("id");
        $im = model('ItemModel');
        return json_encode($im->getTotalItemByLicenseId($id));
    }
    public function gettotalitembybrand() {
        $id = $this->request->getGet("id");
        $im = model('ItemModel');
        return json_encode($im->getTotalItemByBrandId($id));
    }
    public function getlicense(){
        $this->title="Gestion des Licences";
        $this->addBreadcrumb('Objets','/admin/item');
        $this->addBreadcrumb('Licences','');
        $ilm = model("ItemLicenseModel");
        $all_licences = $ilm->getAllLicenses();
        return $this->view('admin/item/license', ['all_licenses' => $all_licences], true);
    }
    public function getdeletelicense($id) {
        $ilm = model("ItemLicenseModel");
        if ($ilm->deleteLicense($id)) {
            $this->success("Licence supprimé");
        } else {
            $this->error("Licence non supprimé");
        }
        return $this->redirect('/admin/item/license');
    }
    public function postcreatelicense() {
        $data = $this->request->getPost();
        $ibm = Model('ItemLicenseModel');
        if ($ibm->insertLicense($data)) {
            $this->success('Licence ajouté');
        } else {
            $this->error('Licence non ajouté');
        }
        $this->redirect('/admin/item/license');
    }

    public function postcreateitem() {
        $data = $this->request->getPost();
        $im = Model('ItemModel');
        $id_item = $im->insertItem($data);
        if ($id_item) {
            // Gestion des Genres
            $data_genre = [];
            if(isset($data['genres'])){
                foreach ($data['genres'] as $g) {
                    $genre = [];
                    $genre['id_item'] = $id_item;
                    $genre['id_genre'] = $g;
                    $data_genre[] = $genre;
                }
            } else {
                $data_genre = [['id_item' => $id_item, 'id_genre' => 1]];
            }
            $igim = model('ItemGenreItemModel');
            $igim->insertMultipleGenre($data_genre);

            //Gestion des Images
            $files = $this->request->getFiles();
            foreach ($files['images'] as $file) {
                if ($file && $file->isValid()) {
                    // Préparer les données du média
                    $mediaData = [
                        'entity_type' => 'item',
                        'entity_id'   => $id_item,
                        'created_at' => date("Y-m-d H:i:s"),
                    ];

                    // Utiliser la fonction upload_file() pour gérer l'upload et les données du média
                    $filePath = upload_file($file, 'item', $file->getName(), $mediaData, true);

                    if ($filePath === false) {
                        $this->error("Une erreur est survenue lors de l'upload de l'image.");
                    }
                }
            }
            $this->success('Objet ajouté');
        } else {
            $this->error('Erreur lors de l\'ajout de l\'objet');
        }
        $this->redirect('/admin/item');
    }

    public function postupdateitem($id) {
        $data = $this->request->getPost();
        $im = Model('ItemModel');
        if ($im->updateItem($data, $id)) {
            $this->success('Objet modifié avec succès');
        } else {
            $this->error('Erreur lors de l\'ajout de l\'objet');
        }
        $this->redirect('/admin/item');
    }

    public function getdeleteitem($id = null) {
        $im = Model('ItemModel');
        if ($im->deleteItem($id)) {
            $this->success('Objet supprimé avec succès');
        } else {
            $this->error('Objet non supprimé');
        }
        $this->redirect('/admin/item');
    }

    public function getdesactivate($id = null) {
        if($id) {
            $im = model('ItemModel');
            if($im->updateItem($id, ['active' => 1])) {
                $this->success('Objet activé');
            } else {
                $this->error('Objet non activé');
            }
            $this->redirect('/admin/item');
        }
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
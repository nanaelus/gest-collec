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
                return $this->view('admin/item/item.php', ['genres' => $genres, 'types' => $types, 'licenses' => $licenses, 'brands'=> $brands, 'item' => $item, 'medias' => model('MediaModel')->getMediaByEntityIdAndType($id,'item'), 'genre_item' => model('ItemGenreItemModel')->getAllItemGenreByIdItem($id)], true);
            } else {
                $this->error('L\'ID n\'est pas valide');
                $this->redirect('/admin/item');
            }
        }
        return $this->view('admin/item/index', [], true);
    }
    public function postcreateitem() {
        $data = $this->request->getPost();
        $im = model('ItemModel');
        $id_item = $im->insertItem($data);
        if ($id_item) {
            //GENRE
            $data_genre = [];
            if (isset($data['genres'])) {
                foreach ($data['genres'] as $g) {
                    $genre = [];
                    $genre['id_item'] = $id_item;
                    $genre['id_genre'] = $g;
                    $data_genre[] = $genre;
                }
            } else {
                $data_genre = [ ['id_item' => $id_item, 'id_genre' => 1] ];
            }
            $igim = model('ItemGenreItemModel');
            $igim->insertMultipleGenre($data_genre);

            //IMAGES
            $files = $this->request->getFiles();
            foreach($files['images'] as $file) {
                if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
                    $mediaData = [
                        'entity_type' => 'item',
                        'entity_id' => $id_item,
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    // Utiliser la fonction upload_file() pour gérer l'upload et les données du média
                    $uploadResult = upload_file($file, 'item', $file->getName(), $mediaData,true);

                    // Vérifier le résultat de l'upload
                    if (is_array($uploadResult) && $uploadResult['status'] === 'error') {
                        // Afficher un message d'erreur détaillé et rediriger
                        $this->error("Une erreur est survenue lors de l'upload de l'image : " . $uploadResult['message']);
                    }
                }
            }
            $first_img = Model("MediaModel")->getFirstMediaByEntityIdAndType($id_item,'item');
            if($first_img) {

                Model("ItemModel")->updateItem($id_item, ['id_default_img' => $first_img['id']]);
            }

            $this->success("Objet ajouté");
        } else {
            $this->error('Objet non ajouté');
        }
        $this->redirect('/admin/item');
    }
    public function postupdateitem() {
        $data = $this->request->getPost();
        $im = model('ItemModel');
        $id_item = $data['id'];
        if ($id_item) {
            $im->updateItem($id_item,$data);
            //GENRE
            if (isset($data['genres'])) {
                $genre_final = $data['genres'];
            } else {
                $genre_final = [];
            }
            $genre_initial = model('ItemGenreItemModel')->getAllItemGenreByIdItem($id_item);
            $genre_initial = array_column($genre_initial, 'id_genre');
            $genre_a_supprimer = array_diff($genre_initial,$genre_final);
            $genre_a_ajouter = array_diff($genre_final,$genre_initial);
            $data_genre = [];
            if ($genre_a_ajouter) {
                foreach ($genre_a_ajouter as $g) {
                    $genre = [];
                    $genre['id_item'] = $id_item;
                    $genre['id_genre'] = $g;
                    $data_genre[] = $genre;
                }
            } else {
                if (count($genre_initial) == 0 || count($genre_final) == 0) {
                    $data_genre = [ ['id_item' => $id_item, 'id_genre' => 1] ];
                }
            }


            $igim = model('ItemGenreItemModel');
            if ( !(count($genre_initial) == 1 && $genre_initial[0] == 1) || count($genre_a_ajouter) != 0 ) {
                if (isset($genre_a_supprimer) && $genre_a_supprimer) {
                    $igim->deleteMultipleGenre($id_item,$genre_a_supprimer);
                }
                if (count($data_genre) != 0) {
                    $igim->insertMultipleGenre($data_genre);
                }
            }

            //IMAGES
            $files = $this->request->getFiles();
            foreach($files['images'] as $file) {
                if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
                    $mediaData = [
                        'entity_type' => 'item',
                        'entity_id' => $id_item,
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    // Utiliser la fonction upload_file() pour gérer l'upload et les données du média
                    $uploadResult = upload_file($file, 'item', $file->getName(), $mediaData,true);

                    // Vérifier le résultat de l'upload
                    if (is_array($uploadResult) && $uploadResult['status'] === 'error') {
                        // Afficher un message d'erreur détaillé et rediriger
                        $this->error("Une erreur est survenue lors de l'upload de l'image : " . $uploadResult['message']);
                    }
                }
            }
            $this->success("Objet modifié");
        } else {
            $this->error('Objet non modifié');
        }
        $this->redirect('/admin/item');
    }
    public function getdeleteitem($id = null){
        if ($id) {
            $im = model('ItemModel');
            if ($im->delete($id)) {
                $this->success("Objet supprimé");
            } else {
                $this->error("Objet non supprimé");
            }
            $this->redirect('/admin/item');
        }
    }
    public function getdeactivate($id= null){
        if ($id) {
            $im = model('ItemModel');
            if ($im->updateItem($id, ['active' => 0])) {
                $this->success("Objet désactivé");
            } else {
                $this->error('Objet non désactivé');
            }
            $this->redirect('/admin/item');
        }
    }
    public function getactivate($id = null){
        if ($id) {
            $im = model('ItemModel');
            if ($im->updateItem($id, ['active' => 1])) {
                $this->success("Objet activé");
            } else {
                $this->error('Objet non activé');
            }
            $this->redirect('/admin/item');
        }
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
    public function postupdatebrand() {
        $data = $this->request->getPost();
        if ($data['id_brand_parent'] == "") {
            unset($data['id_brand_parent']);
        }
        $ibm = Model('ItemBrandModel');
        $ibm->updateBrand($data['id'], $data);
        return json_encode($ibm->getBrandById($data['id']));
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
    public function postupdatelicense(){
        $data = $this->request->getPost();
        print_r($data);
        if ($data['id_license_parent'] == "") {
            unset($data['id_license_parent']);
        }
        $ilm = Model('ItemLicenseModel');
        $ilm->updateLicense($data['id'], $data);
        return json_encode($ilm->getLicenseById($data['id']));
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
        $orderColumnIndex = $this->request->getPost('order')[0]['column'] ?? 0;
        $orderDirection = $this->request->getPost('order')[0]['dir'] ?? 'asc';
        $orderColumnName = $this->request->getPost('columns')[$orderColumnIndex]['data'] ?? 'id';

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

    public function gettest(){
        return $this->view('dev-test');
    }
    public function postupdatetype() {
        $data = $this->request->getPost();
        if($data['id_type_parent'] == "") {
            unset($data['id_type_parent']);
        }
        $itm = Model('ItemTypeModel');
        $itm->updateType($data['id'], $data);
        return json_encode($itm->getTypeById($data['id']));
    }
}
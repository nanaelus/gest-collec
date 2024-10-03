<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Item extends BaseController
{
    protected $require_auth = false;
    public function getindex($slug = null)
    {
        $im = model('ItemModel');
        if ($slug == null) {
            $data = $this->request->getGet();
            $genres = model('ItemGenreModel')->getAllGenres();
            $types = model('ItemTypeModel')->getAllTypes();
            $licenses = model('ItemLicenseModel')->getAllLicenses();
            $brands = model('ItemBrandModel')->getAllBrands();
            $allitems = $im->getAllItemsFiltered(1, $data);
            return $this->view('item/index', ['items' => $allitems, 'genres' => $genres, 'types' => $types, 'licenses' => $licenses, 'brands'=> $brands]);
        } else {
            if ($im->getItemBySlug($slug)) {
                // L'objet existe, on le récupère en entier
                $item = $im->getFullItemBySlug($slug);

                // Vérification si l'utilisateur est connecté et s'il est admin
                $isAdmin = isset($this->session->user) && $this->session->user->isAdmin();

                // Si l'objet est inactif et que l'utilisateur n'est pas admin, on met $item à null
                if ($item['active'] == 0 && !$isAdmin) {
                    $item = null;
                }
            } else {
                // L'objet n'existe pas
                $item = null;
            }

            return $this->view('item/item',['item' => $item]);
        }
    }

}
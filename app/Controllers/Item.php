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
            // Définir le nombre d'éléments par page
            $perPage = 8;
            $genres = model('ItemGenreModel')->getAllGenres();
            $types = model('ItemTypeModel')->getAllTypes();
            $licenses = model('ItemLicenseModel')->getAllLicenses();
            $brands = model('ItemBrandModel')->getAllBrands();
            $allitems = $im->getAllItemsFiltered($data,1, $perPage);
            $collectionUser = model('CollectionModel')->getAllCollectionByUsername($this->session->user->username);
            // Récupérer le pager pour générer les liens de pagination
            $pager = $im->pager;
            return $this->view('item/index', [
                'items' => $allitems,
                'genres' => $genres,
                'types' => $types,
                'licenses' => $licenses,
                'brands' => $brands,
                'data' => $data,
                'pager' => $pager,
                'collectionUser' => $collectionUser
            ]);
        } else {
            if ($im->getItemBySlug($slug)) {
                $cm = model('CommentModel');
                // L'objet existe, on le récupère en entier
                $item = $im->getFullItemBySlug($slug);
                $comments_number = $cm->getTotalByIdAndActive($item['id']);
                $all_comments = $cm->getAllCommentsByItem($item['id']);
                // Vérification si l'utilisateur est connecté et s'il est admin
                $isAdmin = isset($this->session->user) && $this->session->user->isAdmin();
                // Si l'objet est inactif et que l'utilisateur n'est pas admin, on met $item à null
                if ($item['active'] == 0 && !$isAdmin) {
                    $item = null;
                }
                if (isset($this->session->user) && $item != null) {
                    $possede = model('CollectionModel')->haveInCollection($this->session->user->id, $item['id']);
                } else {
                    $possede = false;
                }
            } else {
                // L'objet n'existe pas
                $item = null;
                $possede = false;
                $all_comments= null;
            }
            return $this->view('item/item',['item' => $item, 'possede' => $possede, 'comments' => $all_comments, 'comments_number' => $comments_number]);
        }
    }
    public function getautocompleteItems() {
        $searchValue = $this->request->getGet('q'); // Récupère le terme de recherche envoyé par Select2
        $itemModel = Model("ItemModel");
        // Appelle la méthode de recherche dans le modèle
        $items = $itemModel->searchItemsByName($searchValue);
        // Formatage des résultats pour Select2
        $results = [];
        foreach ($items as $item) {
            $results[] = [
                'id' => $item['slug'],  // Utilise le slug comme ID pour redirection ultérieure
                'text' => $item['name'] // Ce texte sera affiché dans le dropdown de Select2
            ];
        }
        // Retourne les résultats sous forme JSON pour Select2
        return $this->response->setJSON($results);
    }
    public function postcreatecomment() {
        $data = $this->request->getPost();
        $cm = model('CommentModel');
        if($cm->createItemComment($data)) {
            $this->success('Commentaire ajouté');
        } else {
            $this->error('Erreur lors de l\'ajout du commentaire');
        }
        $data = $this->request->getGet();
        // Définir le nombre d'éléments par page
        $perPage = 8;
        $redirectUrl = $this->session->get('redirect_url') ?? '/';
        $genres = model('ItemGenreModel')->getAllGenres();
        $types = model('ItemTypeModel')->getAllTypes();
        $licenses = model('ItemLicenseModel')->getAllLicenses();
        $brands = model('ItemBrandModel')->getAllBrands();
        $allitems = model('ItemModel')->getAllItemsFiltered($data,1, $perPage);
        // Récupérer le pager pour générer les liens de pagination
        $pager = model('ItemModel')->pager;
        return $this->redirect($redirectUrl, [
            'items' => $allitems,
            'genres' => $genres,
            'types' => $types,
            'licenses' => $licenses,
            'brands' => $brands,
            'data' => $data,
            'pager' => $pager
        ]);
    }
}
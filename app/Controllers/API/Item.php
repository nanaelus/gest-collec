<?php

namespace App\Controllers\API;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Item extends ResourceController
{
    public function posttest() {
        $data = $this->request->getGet();
        $data_post = $this->request->getPost();
        return $this->response->setJSON([
            'response' => 'coucou',
            'data' => $data,
            'data_post' => $data_post,
        ]);
    }

    public function getindex() {
        $data = $this->request->getGet();
        if(isset($data['id'])) {
            $im = model('ItemModel');
            $item = $im->getItem($data['id']);
            if($item) {
                return $this->response->setJSON([
                    'response' => 'success',
                    'item' => $item,
                ]);
            } else {
                return $this->response->setJSON([
                    'message' => 'Erreur, id non existant'
                ]);
            }
        }
        return $this->response->setJSON([
            'response' => 'Erreur : Pas d\'information.',
        ]);
    }

    public function postindex() {
        $data = $this->request->getPost();
        if(isset($data['name']) && $data['name']) {
            $im = model('ItemModel');
            $id_item = $im->insertItem($data);
            if($id_item) {
                return $this->response->setJSON([
                    'response' => 'L\'objet a été ajouté!',
                    'id_item' => $id_item,
                    'data' =>$data,
                ]);
            } else {
                return $this->response->setJSON([
                    'message' => 'Erreur, Objet non ajouté',
                ]);
            }
        } else {
            return $this->response->setJSON([
                'message' => 'Erreur, le nom est obligatoire'
            ]);
        }
    }
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Comment extends BaseController
{
    protected $require_auth = false;
    public function index()
    {
        //
    }
    public function postcreateitemcomment() {
        $data = $this->request->getPost();
        $data['id_user'] = $this->session->user->id;
        $slug =  model("ItemModel")->getSlugById($data['entity_id']);
        if (model('CommentModel')->insertItemComment($data)) {
            $this->success("Votre commentaire est bien ajouté");
        } else {
            $this->error("Votre commentaire n'a pas été ajouté");
        }
        $this->redirect('/item/' . $slug . "#comments");
    }
}

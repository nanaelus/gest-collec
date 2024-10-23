<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Comment extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];
    public function getindex($id = null)
    {
        if($id == null) {
            return $this->view('/admin/item/comment/index.php',[], true);
        } else {
            $all_comments = model('CommentModel')->getAllComments();
            if($id) {
                $comment = model('CommentModel')->getFullCommentById($id);
                if($comment) {
                    return $this->view('/admin/item/comment/comment.php', ['comments'=> $all_comments, 'comment'=>$comment], true);
                    } else {
                        $this->error('L\'id ne correspond à aucun commentaire.');
                        return $this->view('/admin/item/comment/index.php',[], true);
                    }
                }
            }
        }

    public function postupdatecomment() {
        $data = $this->request->getPost();
        $cm = model('CommentModel');
        if($cm->updateComment($data['id'], $data)) {
            $this->success('Commentaire modifié');
        } else {
            $this->error('Erreur lors de la modification du commentaire');
        }
        $this->redirect('/admin/comment/', [], true);
    }

    public function getdesactivate($id){
        $cm = Model('CommentModel');
        if ($cm->deleteComment($id)) {
            $this->success("Commentaire désactivé");
        } else {
            $this->error("Commentaire non désactivé");
        }
        $this->redirect('/admin/comment/');
    }

    public function getactivate($id){
        $cm = Model('CommentModel');
        if ($cm->activateComment($id)) {
            $this->success("Commentaire activé");
        } else {
            $this->error("Commentaire non activé");
        }
        $this->redirect('/admin/comment/');
    }

    public function gettest() {
        return $this->view('/dev-test.php');
    }
}

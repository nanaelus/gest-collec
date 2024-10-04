<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Media extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];

    public function getindex()
    {
        return $this->view('admin/media', ['medias' => model('MediaModel')->getAllMedias(12)], true);
    }

    public function getdelete($id = null)
    {
        $mm = model('MediaModel');
        return json_encode($mm->getDeleteMedia($id));
    }

    public function getajaxentitytype() {
        $entity_type = $this->request->getGet('entity_type');
        if($entity_type =='none') {
            return json_encode(model('MediaModel')->getAllMedias(12));
        } else {
            return json_encode(model('MediaModel')->getAllMediasByEntityType($entity_type,12));
        }
    }

    public function getajaxloadmore() {
        $entity_type = $this->request->getGet('entity_type');
        $limit = $this->request->getGet('limit');
        $offset = $this->request->getGet('offset');
        if($entity_type =='none') {
            return json_encode(model('MediaModel')->getAllMedias($limit,$offset));
        } else {
            return json_encode(model('MediaModel')->getAllMediasByEntityType($entity_type,$limit, $offset));
        }
    }
}

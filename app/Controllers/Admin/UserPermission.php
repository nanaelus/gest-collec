<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class UserPermission extends BaseController
{
    public function getindex($id = null)
    {
        $upm = Model('UserPermissionModel');
        $permissions = $upm->getAllPermissions();
        if ($id == null) {
            return $this->view("/admin/user/index-permission", ['permissions' => $permissions], true);
        } else {
            $role = $upm->getrole($id);
            if ($id == "new") {
                return $this->view("admin/user/user-permission", ['role' => $role], true);
            }
            if ($role) {
                return $this->view('/admin/user/user-permission', ['permissions' => $permissions, 'role' => $role], true);
            } else {
                $this->error("Le rôle n'existe pas");
                $this->redirect("/admin/userpermission/index-permission");
            }
        }
    }

    public function postupdate()
    {
        $data = $this->request->getPost();
        $upm = Model("UserPermissionModel");
        if ($upm->updatePermission($data['id'], $data)) {
            $this->success("Le rôle a bien été modifié");
        } else {
            $this->error("Une erreur est survenue");
        }
    $this->redirect("/admin/userpermission");
    }

    public function postcreate()
    {
        $data = $this->request->getPost();
        $upm = Model("UserPermissionModel");
        if ($upm->createPermission($data)) {
            $this->success("Le rôle a bien été crée");
            $this->redirect("/admin/userpermission");
        } else {
            $errors = $upm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
        $this->redirect("/admin/userpermission/new");
        }
    }
    public function getdelete($id) {
        $upm = Model("UserPermissionModel");
        if ($upm->deletePermission($id)) {
            return $this->success("Rôle supprimé!");
        } else {
            $this->error("Une erreur est survenue");
        }
        $this->redirect("/admin/userpermission");
    }
}


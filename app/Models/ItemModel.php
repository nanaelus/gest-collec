<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table            = 'item';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['name','slug', 'description','price', 'release_date','active','id_license','id_brand','id_type','id_default_img','created_at','updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $beforeInsert = ['convertPrice'];
    protected $beforeUpdate = ['convertPrice'];

    protected function convertPrice(array $data)
    {
        if (!isset($data['data']['price'])) {
            return $data;
        }
        $data['data']['price'] = (float) str_replace([',', ';',':'],'.',$data['data']['price']);
        return $data;
    }
    public function getItem($id) {
        return $this->find($id);
    }

    public function getItemBySlug($slug) {
        return $this->where('slug', $slug)->first();
    }

    /**
     * Récupère un item complet en utilisant son slug.
     *
     * Cette fonction interroge la base de données pour obtenir toutes les informations
     * liées à un item spécifique identifié par son slug. Les informations récupérées incluent
     * des détails sur l'item lui-même, sa licence associée, sa marque, son type, ainsi que ses médias et genres.
     *
     * @param string $slug Le slug de l'item à récupérer.
     * @return array|null Un tableau contenant toutes les informations sur l'item,
     *                    y compris les médias et les genres, ou null si aucun item n'est trouvé.
     */
    public function getFullItemBySlug($slug)
    {
        // Crée un builder pour la table 'item' avec un alias 'i'
        $builder = $this->db->table('item i');

        // Sélectionne les colonnes nécessaires pour l'item et ses relations (licence, marque, type)
        $builder->select("i.id, i.name as item_name, i.description, i.price, i.release_date, i.active, i.id_default_img, l.name as license_name, l.slug as license_slug, b.name as brand_name, b.slug as brand_slug, t.name as type_name, t.slug as type_slug");

        // Jointure avec la table 'license' pour récupérer le nom et le slug de la licence associée
        $builder->join("license l", "i.id_license = l.id");

        // Jointure avec la table 'brand' pour récupérer le nom et le slug de la marque associée
        $builder->join("brand b", "i.id_brand = b.id");

        // Jointure avec la table 'type' pour récupérer le nom et le slug du type associé
        $builder->join("type t", "i.id_type = t.id");

        // Condition pour filtrer l'item par son slug
        $builder->where("i.slug", $slug);
        // Exécute la requête et récupère le premier résultat sous forme de tableau associatif
        $item = $builder->get()->getRowArray();

        // Récupère l'image par défaut de l'item en utilisant l'ID de l'image par défaut
        $item['default_img'] = model('MediaModel')->getMediaById($item['id_default_img']);

        // Récupère tous les médias associés à l'item
        $item['medias'] = model('MediaModel')->getMediaByEntityIdAndType($item['id'], 'item');

        // Récupère tous les genres associés à l'item
        $item['genres'] = model('ItemGenreItemModel')->getAllFullItemGenreByIdItem($item['id']);

        // Retourne toutes les informations collectées sur l'item
        return $item;
    }


    public function getAllItems($active = 1) {
        return $this->where('active', $active)->findAll();
    }

    public function getAllItemsFiltered($data, $active = 1, $perPage = 8)
    {
        $this->select("item.id, item.name, item.slug, media.file_path as default_img_file_path");
        $this->join('media', 'item.id_default_img = media.id', 'left');

        foreach ($data as $filter => $slug) {
            switch ($filter) {
                case 'license':
                    $this->join('license', 'item.id_license = license.id');
                    $this->where('license.slug', $slug['slug']);
                    break;
                case 'brand':
                    $this->join('brand', 'item.id_brand = brand.id');
                    $this->where('brand.slug', $slug['slug']);
                    break;
                case 'type':
                    $this->join('type', 'item.id_type = type.id');
                    $this->where('type.slug', $slug['slug']);
                    break;
                case 'username' :
                    $this->join('collection c', 'item.id = c.id_item');
                    $this->join('TableUser u', 'c.id_user = u.id');
                    $this->where('u.username', $slug);
                    break;
                case 'search':
                    $this->like('item.name', $slug);
                    break;
            }
        }

        // Filtrer les items actifs
        $this->where('item.active', $active);

        // Utilisation de la méthode paginate pour gérer les résultats paginés
        return $this->paginate($perPage);
    }

    public function searchItemsByName($searchValue, $limit = 10)
    {
        return $this->select('id, name, slug')
            ->like('name', $searchValue)
            ->limit($limit)
            ->findAll();
    }

    public function getSlugById($id_item) {
        return $this->select('slug')->where('id', $id_item)->get()->getRow()->slug;
    }

    public function insertItem($data) {
        $data['slug'] = $this->generateUniqueSlug($data['name']);
        return $this->insert($data);
    }

    public function deleteItem($id) {
        return $this->delete($id);
    }

    public function updateItem($id,$data) {
        return $this->update($id,$data);
    }

    public function getTotalItemByLicenseId($id_license) {
        return $this->select('COUNT(*) as total')->where('id_license', $id_license)->first();
    }
    public function getTotalItemByBrandId($id_brand) {
        return $this->select('COUNT(*) as total')->where('id_brand', $id_brand)->first();
    }
    public function getTotalItemByTypeId($id_type) {
        return $this->select('COUNT(*) as total')->where('id_type', $id_type)->first();
    }
    public function getPaginated($start, $length, $searchValue, $orderColumnName, $orderDirection)
    {
        $builder = $this->builder();
        // Recherche
        if ($searchValue != null) {
            $builder->like('name', $searchValue);
        }

        // Tri
        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }

        $builder->limit($length, $start);

        return $builder->get()->getResultArray();
    }

    public function getTotal()
    {
        $builder = $this->builder();
        return $builder->countAllResults();
    }

    public function getFiltered($searchValue)
    {
        $builder = $this->builder();
        if (!empty($searchValue)) {
            $builder->like('name', $searchValue);
        }

        return $builder->countAllResults();
    }
    private function generateUniqueSlug($name)
    {
        $slug = generateSlug($name);
        $builder = $this->builder();
        $count = $builder->where('slug', $slug)->countAllResults();
        if ($count === 0) {
            return $slug;
        }
        $i = 1;
        while ($count > 0) {
            $newSlug = $slug . '-' . $i;
            $count = $builder->where('slug', $newSlug)->countAllResults();
            $i++;
        }
        return $newSlug;
    }
}
<?php defined('BASEPATH') or exit('No direct script access allowed');

class Package_m extends CI_Model
{

    public function getPCategory($id = null)
    {
        $this->db->select('*');
        $this->db->from('package_category');
        if ($id != null) {
            $this->db->where('package_category_id', $id);
        }
        $query = $this->db->get();
        return $query;
    }
    public function cekCategory($id = null)
    {
        $this->db->select('*');
        $this->db->from('package_item');
        if ($id != null) {
            $this->db->where('category_id', $id);
        }
        $query = $this->db->get();
        return $query;
    }
    public function addPCategory($post)
    {
        $params = [
            'name' => htmlspecialchars($post['name']),
            'description' => htmlspecialchars($post['description']),
            'date_created' => time(),
        ];
        $this->db->insert('package_category', $params);
    }

    public function editPCategory($post)
    {
        $params = [
            'name' => htmlspecialchars($post['name']),
            'description' => htmlspecialchars($post['description']),
            'date_updated' => time(),
        ];
        $this->db->where('p_category_id', $post['p_category_id']);
        $this->db->update('package_category', $params);
    }

    public function deletePCategory($id)
    {
        $this->db->where('p_category_id', $id);
        $this->db->delete('package_category');
    }

    public function getPitem($p_item_id = null)
    {
        $this->db->select('*, package_category.name as category_name, package_item.description as descriptionItem, package_item.name as nameItem');
        $this->db->from('package_item');
        $this->db->join('package_category', 'package_category.p_category_id = package_item.category_id');
        if ($p_item_id != null) {
            $this->db->where('p_item_id', $p_item_id);
        }
        $this->db->where('is_active', 1);
        $query = $this->db->get();
        return $query;
    }
    public function getPitemnonactive($p_item_id = null)
    {
        $this->db->select('*, package_category.name as category_name, package_item.description as descriptionItem, package_item.name as nameItem');
        $this->db->from('package_item');
        $this->db->join('package_category', 'package_category.p_category_id = package_item.category_id');
        if ($p_item_id != null) {
            $this->db->where('p_item_id', $p_item_id);
        }
        $this->db->where('is_active', 0);
        $query = $this->db->get();
        return $query;
    }

    public function addPItem($post)
    {
        $params = [
            'name' => htmlspecialchars($post['name']),
            'price' => $post['price'],
            'picture' => !empty($post['picture']) ? $post['picture'] : '',
            'description' => htmlspecialchars($post['description'] ?? ''),
            'category_id' => $post['category'],
            'date_created' => time(),
            'date_update' => 0,
            'public' => $post['public'],
            'is_active' => $post['is_active'],
            'create_by' => !empty($this->session->userdata('id')) ? $this->session->userdata('id') : 0,
            'role_id' => !empty($this->session->userdata('role_id')) ? $this->session->userdata('role_id') : 0,
            'package_mitra' => 0
        ];
        $this->db->insert('package_item', $params);
    }
    public function editPItem($post)
    {
        $params = [
            'name' => htmlspecialchars($post['name']),
            'price' => $post['price'],
            'public' => $post['public'],
            'is_active' => $post['is_active'],
            'category_id' => $post['category'],
            'description' => htmlspecialchars($post['description'] ?? ''),
            'date_update' => time()
        ];
        if (!empty($post['picture'])) {
            $params['picture'] = $post['picture'];
        }
        $this->db->where('p_item_id', $post['p_item_id']);
        $this->db->update('package_item', $params);
    }
    public function deletePItem($p_item_id)
    {
        $this->db->where('p_item_id', $p_item_id);
        $this->db->delete('package_item');
    }
}

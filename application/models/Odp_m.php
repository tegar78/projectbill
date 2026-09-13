<?php defined('BASEPATH') or exit('No direct script access allowed');

class Odp_m extends CI_Model
{
    public function get($id_odp = null)
    {
        $this->db->select('*');
        $this->db->from('m_odp');
        if ($id_odp != null) {
            $this->db->where('id_odp', $id_odp);
        }
        $query = $this->db->get();
        return $query;
    }

    public function add($post)
    {
        $params = [
            'code_odc' => $post['code_odc'],
            'code_odp' => $post['code_odp'],
            'coverage_odp' => $post['coverage_odp'],
            'no_port_odc' => $post['no_port_odc'],
            'color_tube_fo' => $post['color_tube_fo'],
            'no_pole' => $post['no_pole'],
            'latitude' => $post['lat'],
            'longitude' => $post['long'],
            'total_port' => $post['total_port'],
            'remark' => $post['remark'],
            'created' => time(),
        ];
        if (!empty($_FILES['picture']['name'])) {
            $params['document'] = $post['picture'];
        }
        $this->db->insert('m_odp', $params);
        $this->clear_cache();
    }
    public function edit($post)
    {
        $params = [
            'code_odc' => $post['code_odc'],
            'code_odp' => $post['code_odp'],
            'coverage_odp' => $post['coverage_odp'],
            'no_port_odc' => $post['no_port_odc'],
            'color_tube_fo' => $post['color_tube_fo'],
            'no_pole' => $post['no_pole'],
            'latitude' => $post['lat'],
            'longitude' => $post['long'],
            'total_port' => $post['total_port'],
            'remark' => $post['remark'],

        ];
        if (!empty($_FILES['picture']['name'])) {
            $params['document'] = $post['picture'];
        }
        $this->db->where('id_odp', $post['id_odp']);
        $this->db->update('m_odp', $params);
        $this->clear_cache();
    }
    public function del($id_odp)
    {
        $this->db->where('id_odp', $id_odp);
        $this->db->delete('m_odp');
        $this->clear_cache();
    }

    public function getmaps()
    {
        $this->db->select('*');
        $this->db->from('m_odp');
        $this->db->where('latitude !=', '');
        $this->db->where('longitude !=', '');
        $query = $this->db->get();
        return $query;
    }
    public function getunmaps()
    {
        $this->db->select('*');
        $this->db->from('m_odp');
        $this->db->where('latitude', '');
        $this->db->or_where('longitude', '');
        $query = $this->db->get();
        return $query;
    }

    // Document
    public function adddoc($post)
    {
        $params = [
            'odp_id' => $post['odp_id'],
            'remark' => $post['remark'],
            'created' => time(),
            'createby' => $this->session->userdata('id'),
        ];
        if (!empty($_FILES['picture']['name'])) {
            $params['document'] = $post['picture'];
        }
        $this->db->insert('odp_doc', $params);
    }
    public function editdoc($post)
    {
        $params = [
            'remark' => $post['remark'],
            'updated' => time(),
            'updateby' => $this->session->userdata('id'),
        ];
        if (!empty($_FILES['picture']['name'])) {
            $params['document'] = $post['picture'];
        }
        $this->db->where('id', $post['id']);
        $this->db->update('odp_doc', $params);
    }
    public function deletedoc($post)
    {
        $this->db->where('id', $post['id']);
        $this->db->delete('odp_doc');
    }
    public function getportactive($odp)
    {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('id_odp', $odp);
        $this->db->where('c_status !=', 'Menunggu');
        $this->db->where('c_status !=', 'Non-Aktif');
        $query = $this->db->get();
        return $query;
    }
    public function getallcustomer($odp)
    {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('id_odp', $odp);
        $this->db->order_by('no_port_odp', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function get_with_relations($id_odp = null, $use_cache = true)
    {
        $cache_file = APPPATH . 'cache/odp_list.json';
        if ($use_cache && $id_odp === null && file_exists($cache_file)) {
            $cache_time = @filemtime($cache_file);
            if ((time() - $cache_time) < 300) {
                $cached_content = @file_get_contents($cache_file);
                if (!empty($cached_content)) {
                    $cached = json_decode($cached_content);
                    if ($cached !== null) {
                        return $cached;
                    }
                }
            }
        }

        $this->db->select("
            o.*,
            odc.code_odc AS odc_code,
            cov.c_name AS coverage_name,
            COALESCE(cust.total_customer, 0) AS total_customer,
            COALESCE(cust.active_customer, 0) AS active_customer
        ", FALSE);
        $this->db->from('m_odp o');
        $this->db->join('m_odc odc', 'odc.id_odc = o.code_odc', 'left');
        $this->db->join('coverage cov', 'cov.coverage_id = o.coverage_odp', 'left');
        $this->db->join("(
            SELECT 
                id_odp,
                COUNT(*) AS total_customer,
                SUM(CASE WHEN c_status != 'Menunggu' AND c_status != 'Non-Aktif' THEN 1 ELSE 0 END) AS active_customer
            FROM customer
            GROUP BY id_odp
        ) cust", 'cust.id_odp = o.id_odp', 'left');

        if ($id_odp != null) {
            $this->db->where('o.id_odp', $id_odp);
            return $this->db->get();
        }

        $result = $this->db->get()->result();
        if ($use_cache) {
            @file_put_contents($cache_file, json_encode($result));
        }
        return $result;
    }

    public function clear_cache()
    {
        $cache_file = APPPATH . 'cache/odp_list.json';
        if (file_exists($cache_file)) {
            @unlink($cache_file);
        }
    }
}

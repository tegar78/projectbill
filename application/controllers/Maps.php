<?php defined('BASEPATH') or exit('No direct script access allowed');

class Maps extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model(['customer_m', 'services_m', 'bill_m', 'coverage_m', 'logs_m']);
    }

    public function index()
    {
        $data['title'] = 'Maps';
        $data['company'] = $this->db->get('company')->row_array();
        $data['customer'] = $this->customer_m->unmaps()->result();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array();
        $data['coverage'] = $this->db->get('coverage')->result();

        // Calculate statistics for filter badges
        $stats = [
            'total' => 0,
            'aktif' => 0,
            'isolir' => 0,
            'non_aktif' => 0,
            'menunggu' => 0,
            'free' => 0,
            'unmapped' => count($data['customer'])
        ];

        // Optimized SQL aggregation for mapped customer counts (drastically reduces WAN query latency & memory)
        $mapped_counts = $this->db->select('c_status, connection, COUNT(*) as cnt')
            ->from('customer')
            ->where("latitude IS NOT NULL AND latitude != '' AND latitude != '0'", NULL, FALSE)
            ->where("longitude IS NOT NULL AND longitude != '' AND longitude != '0'", NULL, FALSE)
            ->group_by(['c_status', 'connection'])
            ->get()->result();

        foreach ($mapped_counts as $row) {
            $count = (int)$row->cnt;
            $stats['total'] += $count;
            $st = strtolower(trim($row->c_status ?? ''));
            $is_isolir = ((int)($row->connection ?? 0) === 1 || $st === 'isolir');

            if ($is_isolir) {
                $stats['isolir'] += $count;
            } elseif ($st === 'aktif' || $st === 'active') {
                $stats['aktif'] += $count;
            } elseif ($st === 'non-aktif' || $st === 'non-active') {
                $stats['non_aktif'] += $count;
            } elseif ($st === 'menunggu' || $st === 'waiting') {
                $stats['menunggu'] += $count;
            } elseif ($st === 'free') {
                $stats['free'] += $count;
            }
        }
        $data['stats'] = $stats;

        // Calculate statistics for unmapped customers table
        $unmapped_stats = [
            'total' => count($data['customer']),
            'aktif' => 0,
            'isolir' => 0,
            'non_aktif' => 0,
            'menunggu' => 0,
            'free' => 0
        ];
        foreach ($data['customer'] as $cust) {
            $st = strtolower(trim($cust->c_status ?? ''));
            $is_isolir = ((int)($cust->connection ?? 0) === 1 || $st === 'isolir');

            if ($is_isolir) {
                $unmapped_stats['isolir']++;
            } elseif ($st === 'aktif' || $st === 'active') {
                $unmapped_stats['aktif']++;
            } elseif ($st === 'non-aktif' || $st === 'non-active') {
                $unmapped_stats['non_aktif']++;
            } elseif ($st === 'menunggu' || $st === 'waiting') {
                $unmapped_stats['menunggu']++;
            } elseif ($st === 'free') {
                $unmapped_stats['free']++;
            }
        }
        $data['unmapped_stats'] = $unmapped_stats;

        $this->template->load('backend', 'backend/maps/maps', $data);
    }

    public function set()
    {
        $post = $this->input->post(null, TRUE);

        $this->db->set('token', $post['token']);
        $this->db->set('vendor', $post['vendor']);
        $this->db->update('maps');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data Maps berhasil diperbaharui');
        }
        redirect('maps/setting');
    }

    public function setting()
    {
        $table = $this->db->get('maps')->row_array();
        if ($table == 0) {
            $params = [
                'token' => 'your token / api key',
            ];
            $this->db->insert('maps', $params);
            redirect('maps/setting');
        } else {
            $this->session->set_userdata('integration', 'maps');

            $data = [
                'title' => 'Maps',
                'maps' => $this->db->get('maps')->row_array(),
                'user' =>  $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
                'company' =>  $this->db->get('company')->row_array(),
            ];
            $this->template->load('backend', 'backend/maps/setmaps', $data);
        }
    }

    public function getmaps()
    {
        $customers = $this->customer_m->getmaps_detail()->result();
        $dataa = [];

        foreach ($customers as $data) {
            $raw_status = $data->c_status ?? 'Aktif';
            $is_isolir = ((int)($data->connection ?? 0) === 1 || strtolower(trim($raw_status)) === 'isolir');
            $effective_status = $is_isolir ? 'Isolir' : $raw_status;

            $dataa[] = [
                'customer_id' => $data->customer_id,
                'name' => htmlspecialchars($data->name ?? '', ENT_QUOTES, 'UTF-8'),
                'no_services' => $data->no_services ?? '',
                'no_wa' => $data->no_wa ?? '',
                'address' => htmlspecialchars($data->address ?? '', ENT_QUOTES, 'UTF-8'),
                'latitude' => (float)$data->latitude,
                'longitude' => (float)$data->longitude,
                'mode_user' => $data->mode_user ?? '-',
                'user_mikrotik' => $data->user_mikrotik ?? '-',
                'c_status' => $effective_status,
                'connection' => (int)($data->connection ?? 0),
                'coverage' => $data->coverage_name ?? 'Tanpa Coverage',
                'odc' => $data->code_odc ?? '-',
                'odp' => (!empty($data->code_odp) ? ($data->code_odp . (!empty($data->no_port_odp) ? ' | Port ' . $data->no_port_odp : '')) : '-'),
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($dataa, JSON_INVALID_UTF8_SUBSTITUTE));
    }

    public function get_coverage()
    {
        $coverage = $this->db->get('coverage')->result();
        $res = [];
        foreach ($coverage as $c) {
            if (!empty($c->latitude) && !empty($c->longitude) && (float)$c->latitude != 0) {
                $res[] = [
                    'coverage_id' => $c->coverage_id,
                    'c_name' => htmlspecialchars($c->c_name ?? '', ENT_QUOTES, 'UTF-8'),
                    'address' => htmlspecialchars($c->address ?? '', ENT_QUOTES, 'UTF-8'),
                    'latitude' => (float)$c->latitude,
                    'longitude' => (float)$c->longitude,
                    'radius' => (int)($c->radius ?: 500),
                    'comment' => htmlspecialchars($c->comment ?? '', ENT_QUOTES, 'UTF-8'),
                ];
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($res, JSON_INVALID_UTF8_SUBSTITUTE));
    }

    public function save_coordinate()
    {
        if ($this->input->method() !== 'post') {
            show_404();
            return;
        }

        $customer_id = $this->input->post('customer_id', TRUE);
        $latitude = trim($this->input->post('latitude', TRUE));
        $longitude = trim($this->input->post('longitude', TRUE));

        if (empty($customer_id) || $latitude === '' || $longitude === '') {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Customer ID, Latitude, dan Longitude wajib diisi.']));
            return;
        }

        $cust = $this->db->get_where('customer', ['customer_id' => $customer_id])->row_array();
        if (!$cust) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Data pelanggan tidak ditemukan.']));
            return;
        }

        $this->db->where('customer_id', $customer_id);
        $this->db->update('customer', [
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        if ($this->logs_m) {
            $logmessage = 'Update Titik Maps Pelanggan ' . $cust['name'] . ' (' . $cust['no_services'] . ') Lat: ' . $latitude . ', Lng: ' . $longitude;
            $this->logs_m->activitylogs('Activity', $logmessage);
        }

        // Fetch refreshed detail with joins for immediate addition to the map
        $coverage = $this->db->get_where('coverage', ['coverage_id' => $cust['coverage']])->row_array();
        $odc = $this->db->get_where('m_odc', ['id_odc' => $cust['id_odc']])->row_array();
        $odp = $this->db->get_where('m_odp', ['id_odp' => $cust['id_odp']])->row_array();

        $refreshed_data = [
            'customer_id' => $cust['customer_id'],
            'name' => htmlspecialchars($cust['name'] ?? '', ENT_QUOTES, 'UTF-8'),
            'no_services' => $cust['no_services'] ?? '',
            'no_wa' => $cust['no_wa'] ?? '',
            'address' => htmlspecialchars($cust['address'] ?? '', ENT_QUOTES, 'UTF-8'),
            'latitude' => (float)$latitude,
            'longitude' => (float)$longitude,
            'mode_user' => $cust['mode_user'] ?? '-',
            'user_mikrotik' => $cust['user_mikrotik'] ?? '-',
            'c_status' => $cust['c_status'] ?? 'Aktif',
            'coverage' => $coverage['c_name'] ?? 'Tanpa Coverage',
            'odc' => $odc['code_odc'] ?? '-',
            'odp' => (!empty($odp['code_odp']) ? ($odp['code_odp'] . (!empty($cust['no_port_odp']) ? ' | Port ' . $cust['no_port_odp'] : '')) : '-'),
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'message' => 'Titik lokasi pelanggan ' . $cust['name'] . ' berhasil disimpan!',
                'customer' => $refreshed_data
            ], JSON_INVALID_UTF8_SUBSTITUTE));
    }
}

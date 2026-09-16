<?php
/**
 * @param float|int|string $nominal
 * @return string
 */
function indo_currency($nominal)
{
    $result = number_format($nominal, 0, ',', '.');
    return $result;
}

/**
 * @param string|int|null $nohp
 * @return string
 */
function indo_tlp($nohp)
{
    static $company = null;
    if ($company === null) {
        $ci = get_instance();
        $company = $ci->db->get('company')->row_array();
    }
    if ($nohp === null) {
        return '';
    }
    
    $phonecode = isset($company['phonecode']) ? $company['phonecode'] : '62';
    $nohp = str_replace([" ", "(", ")", ".", "-"], "", (string)$nohp);

    if (!preg_match('/[^+0-9]/', trim($nohp))) {
        if (substr(trim($nohp), 0, 3) == '+' . $phonecode) {
            $nohp = trim($nohp);
        } elseif (substr(trim($nohp), 0, 1) == '0') {
            $nohp = '+' . $phonecode . substr(trim($nohp), 1);
        } else {
            if (substr(trim($nohp), 0, strlen($phonecode)) == $phonecode) {
                $nohp = '+' . trim($nohp);
            } else {
                $nohp = '+' . $phonecode . trim($nohp);
            }
        }
        return $nohp;
    }
    return (string)$nohp;
}

/**
 * @param string|int $number
 * @return string
 */
function format_whatsapp_number($number)
{
    $number = preg_replace('/[^0-9]/', '', (string)$number);
    if (empty($number)) {
        return '';
    }
    if (substr($number, 0, 1) === '0') {
        return '62' . substr($number, 1);
    }
    if (substr($number, 0, 2) === '62') {
        return $number;
    }
    return '62' . $number;
}

/**
 * @param float|string|null $lat_raw
 * @param float|string|null $lng_raw
 * @param string $address
 * @return array
 */
function get_google_maps_route($lat_raw, $lng_raw, $address = '')
{
    $combined = (string)$lat_raw . ' ' . (string)$lng_raw;
    preg_match_all('/-?\d+\.\d+/', $combined, $matches);
    $numbers = !empty($matches[0]) ? $matches[0] : [];

    $lat = null;
    $lng = null;

    foreach ($numbers as $num) {
        $val = (float)$num;
        if ($val >= -15 && $val <= 10 && $lat === null) {
            $lat = $val;
        } elseif ($val >= 90 && $val <= 145 && $lng === null) {
            $lng = $val;
        }
    }

    if ($lat !== null && $lng !== null) {
        return [
            'has_coords' => true,
            'lat' => $lat,
            'lng' => $lng,
            'route_url' => "https://www.google.com/maps/dir/?api=1&destination={$lat},{$lng}",
            'place_url' => "https://www.google.com/maps/place/{$lat},{$lng}"
        ];
    }

    if (!empty($address) && preg_match('/https?:\/\/[^\s\'"]+/', (string)$address, $url_matches)) {
        return [
            'has_coords' => false,
            'lat' => null,
            'lng' => null,
            'route_url' => $url_matches[0],
            'place_url' => $url_matches[0]
        ];
    }

    $clean_addr = trim(strip_tags((string)$address));
    if (!empty($clean_addr)) {
        return [
            'has_coords' => false,
            'lat' => null,
            'lng' => null,
            'route_url' => "https://www.google.com/maps/dir/?api=1&destination=" . urlencode($clean_addr),
            'place_url' => "https://www.google.com/maps/search/?api=1&query=" . urlencode($clean_addr)
        ];
    }

    return [
        'has_coords' => false,
        'lat' => null,
        'lng' => null,
        'route_url' => '',
        'place_url' => ''
    ];
}

/**
 * @param string $date
 * @return string
 */
function indo_date($date)
{
    $d = substr($date, 8, 2);
    $m = substr($date, 5, 2);
    $y = substr($date, 0, 4);
    $bulan = Date($m);
    switch ($bulan) {
        case 01:
            $bulan = 'Januari';
            break;
        case 2:
            $bulan = 'Februari';
            break;
        case 3:
            $bulan = 'Maret';
            break;
        case 4:
            $bulan = 'April';
            break;
        case 5:
            $bulan = 'Mei';
            break;
        case 6:
            $bulan = 'Juni';
            break;
        case 7:
            $bulan = 'Juli';
            break;
        case 8:
            $bulan = 'Agustus';
            break;
        case 9:
            $bulan = 'September';
            break;
        case 10:
            $bulan = 'Oktober';
            break;
        case 11:
            $bulan = 'November';
            break;
        case 12:
            $bulan = 'Desember';
            break;
    }
    return $d . ' ' . $bulan . ' ' . $y;
}
/**
 * @param int|string $month
 * @return string
 */
function indo_month($month)
{
    $bulan = Date($month);
    switch ($bulan) {
        case 01:
            $bulan = 'Januari';
            break;
        case 02:
            $bulan = 'Februari';
            break;
        case 03:
            $bulan = 'Maret';
            break;
        case 04:
            $bulan = 'April';
            break;
        case 05:
            $bulan = 'Mei';
            break;
        case 06:
            $bulan = 'Juni';
            break;
        case 07:
            $bulan = 'Juli';
            break;
        case 8:
            $bulan = 'Agustus';
            break;
        case 9:
            $bulan = 'September';
            break;
        case 10:
            $bulan = 'Oktober';
            break;
        case 11:
            $bulan = 'November';
            break;
        case 12:
            $bulan = 'Desember';
            break;
    }
    return  $bulan;
}
function maps()
{
    $ci = get_instance();
    $table = $ci->db->get('maps')->row_array();
    if ($table == 0) {
        $params = [
            'token' => 'your token / api key',
        ];
        $ci->db->insert('maps', $params);
    } else {
        $ci->db->select('*');
        $ci->db->from('maps');
        $query = $ci->db->get();
        return $query->row_array();
    }
}
/**
 * @param string|int $target
 * @param string $message
 * @return mixed
 */
function sendmsg($target, $message)
{
    $ci = get_instance();
    $whatsapp = $ci->db->get('whatsapp')->row_array();

    if ($whatsapp['vendor'] == 'WAblas') {
        if ($whatsapp['version'] == 0) {
            $curl = curl_init();
            $token = $whatsapp['token'];

            $data = [
                'phone' => indo_tlp($target),
                'message' => $message,
                'secret' => false, // or true
                'priority' => true, // or true
            ];

            curl_setopt(
                $curl,
                CURLOPT_HTTPHEADER,
                array(
                    "Authorization: $token",
                )
            );
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/send-message");
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($curl);
            $result = json_decode($result, true);
            curl_close($curl);
        } else {
            $token = $whatsapp['token'];
            $curl = curl_init();

            $data = [
                'phone' => indo_tlp($target),
                'message' => $message,
                'secret' => false,
                'retry' => false,
                'isGroup' => false
            ];

            $payload[] = [
                'phone' => indo_tlp($target),
                'message' => $message,
                'secret' => false,
                'retry' => false,
                'isGroup' => false
            ];
            curl_setopt_array($curl, array(
                CURLOPT_URL => "$whatsapp[domain_api]/api/v2/send-message",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode(['data' => $payload]),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . $token,
                    'Content-Type: application/json'
                ),
            ));
            $response = curl_exec($curl);
            // echo $response;
        }

        // if ($result['status'] == 1) {
        //     $ci->session->set_flashdata('success-sweet', $result['message'] . '<br> Sisa Kuota : ' . $result['data']['quota']);
        // }
    }
    if ($whatsapp['vendor'] == 'Starsender') {
        $apikey = $whatsapp['api_key'];
        $tujuan = indo_tlp($target);
        $pesan = $message;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://starsender.online/api/sendText?message=' . rawurlencode($pesan) . '&tujuan=' . rawurlencode($tujuan . '@s.whatsapp.net'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'apikey: ' . $apikey
            ),
        ));


        $result = curl_exec($curl);
        $result = json_decode($result, true);
        curl_close($curl);
        // if ($result['status'] == 1) {
        //     $ci->session->set_flashdata('success-sweet', $result['message']);
        // } else {
        //     $ci->session->set_flashdata('error-sweet', $result['message']);
        // }
    }
    if ($whatsapp['vendor'] == 'Other') {
        $apikey = $whatsapp['token'];
        $sender = $whatsapp['username'];
        $data = [
            'api_key' => $apikey,
            'sender' => $sender,
            'number' => $target,
            'message' => $message
        ];



        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL =>  "$whatsapp[domain_api]/send-message",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;

        // if ($result['status'] == 'true') {
        //     $ci->session->set_flashdata('success', $result['msg']);
        // } else {
        //     $ci->session->set_flashdata('error', $result['msg']);
        // }
    }
    if ($whatsapp['vendor'] == 'Ruangwa') {
        $apikey = $whatsapp['api_key'];
        $phone = indo_tlp($target); //atau bisa menggunakan 62812xxxxxxx
        $message = $message;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.ruangwa.id/api/send_message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'token=' . $apikey . '&number=' . $phone . '&message=' . $message,
        ));
        $response = curl_exec($curl);
        $result = json_decode($response, true);
        curl_close($curl);
        // echo $response;
        // if ($result['status'] == 'sent') {
        //     $ci->session->set_flashdata('success', $result['message']);
        // } else {
        //     $ci->session->set_flashdata('error', $result['message']);
        // }
    }
}
/**
 * @param string|int $target
 * @param string $message
 * @param string|int $invoice
 * @return mixed
 */
function sendmsgbill($target, $message, $invoice)
{
    $ci = get_instance();
    $whatsapp = $ci->db->get('whatsapp')->row_array();

    if ($whatsapp['vendor'] == 'WAblas') {
        if ($whatsapp['version'] == 0) {
            $curl = curl_init();
            $token = $whatsapp['token'];

            $data = [
                'phone' => indo_tlp($target),
                'message' => $message,
                'secret' => false, // or true
                'priority' => true, // or true
            ];

            curl_setopt(
                $curl,
                CURLOPT_HTTPHEADER,
                array(
                    "Authorization: $token",
                )
            );
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/send-message");
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($curl);
            $result = json_decode($result, true);
            curl_close($curl);
        } else {
            $token = $whatsapp['token'];
            $curl = curl_init();

            $data = [
                'phone' => indo_tlp($target),
                'message' => $message,
                'secret' => false,
                'retry' => false,
                'isGroup' => false
            ];

            $payload[] = [
                'phone' => indo_tlp($target),
                'message' => $message,
                'secret' => false,
                'retry' => false,
                'isGroup' => false
            ];
            curl_setopt_array($curl, array(
                CURLOPT_URL => "$whatsapp[domain_api]/api/v2/send-message",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode(['data' => $payload]),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . $token,
                    'Content-Type: application/json'
                ),
            ));
            $result = curl_exec($curl);
            $result = json_decode($result, true);
            curl_close($curl);
            if ($result['status'] == 1) {
                $ci->db->set('send_bill',  date('Y-m-d H:i:s'));
                $ci->db->where('invoice', $invoice);
                $ci->db->update('invoice');
            } else {
            }
        }
    }
    if ($whatsapp['vendor'] == 'Starsender') {
        $apikey = $whatsapp['api_key'];
        $tujuan = indo_tlp($target);
        $pesan = $message;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://starsender.online/api/sendText?message=' . rawurlencode($pesan) . '&tujuan=' . rawurlencode($tujuan . '@s.whatsapp.net'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'apikey: ' . $apikey
            ),
        ));


        $result = curl_exec($curl);
        $result = json_decode($result, true);
        curl_close($curl);
        if ($result['status'] == 1) {
            $ci->db->set('send_bill', date('Y-m-d H:i:s'));
            $ci->db->where('invoice', $invoice);
            $ci->db->update('invoice');
        }
    }
    if ($whatsapp['vendor'] == 'Other') {
        $apikey = $whatsapp['token'];
        $sender = $whatsapp['username'];
        $data = [
            'api_key' => $apikey,
            'sender' => $sender,
            'number' => $target,
            'message' => $message
        ];



        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL =>  "$whatsapp[domain_api]/send-message",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $result = json_decode($response, true);
        if ($result['status'] == 'sent') {
            $ci->db->set('send_bill', date('Y-m-d H:i:s'));
            $ci->db->where('invoice', $invoice);
            $ci->db->update('invoice');
        }
    }
    if ($whatsapp['vendor'] == 'Ruangwa') {
        $apikey = $whatsapp['api_key'];
        $phone = indo_tlp($target); //atau bisa menggunakan 62812xxxxxxx
        $message = $message;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.ruangwa.id/api/send_message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'token=' . $apikey . '&number=' . $phone . '&message=' . $message,
        ));
        $response = curl_exec($curl);
        $result = json_decode($response, true);
        curl_close($curl);
        // echo $response;
        if ($result['status'] == 'sent') {
            $ci->db->set('send_bill', date('Y-m-d H:i:s'));
            $ci->db->where('invoice', $invoice);
            $ci->db->update('invoice');
        }
    }
}
/**
 * @param string|int $target
 * @param string $message
 * @param string|int $invoice
 * @return mixed
 */
function sendmsgpaid($target, $message, $invoice)
{
    $ci = get_instance();
    $whatsapp = $ci->db->get('whatsapp')->row_array();

    if ($whatsapp['vendor'] == 'WAblas') {
        if ($whatsapp['version'] == 0) {
            $curl = curl_init();
            $token = $whatsapp['token'];

            $data = [
                'phone' => indo_tlp($target),
                'message' => $message,
                'secret' => false, // or true
                'priority' => true, // or true
            ];

            curl_setopt(
                $curl,
                CURLOPT_HTTPHEADER,
                array(
                    "Authorization: $token",
                )
            );
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/send-message");
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($curl);
            $result = json_decode($result, true);
            curl_close($curl);
        } else {
            $token = $whatsapp['token'];
            $curl = curl_init();

            $data = [
                'phone' => indo_tlp($target),
                'message' => $message,
                'secret' => false,
                'retry' => false,
                'isGroup' => false
            ];

            $payload[] = [
                'phone' => indo_tlp($target),
                'message' => $message,
                'secret' => false,
                'retry' => false,
                'isGroup' => false
            ];
            curl_setopt_array($curl, array(
                CURLOPT_URL => "$whatsapp[domain_api]/api/v2/send-message",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode(['data' => $payload]),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . $token,
                    'Content-Type: application/json'
                ),
            ));
            $result = curl_exec($curl);
            $result = json_decode($result, true);
            curl_close($curl);
        }

        if ($result['status'] == 1) {
            $ci->db->set('send_paid', date('Y-m-d H:i:s'));
            $ci->db->where('invoice', $invoice);
            $ci->db->update('invoice');
        }
    }
    if ($whatsapp['vendor'] == 'Starsender') {
        $apikey = $whatsapp['api_key'];
        $tujuan = indo_tlp($target);
        $pesan = $message;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://starsender.online/api/sendText?message=' . rawurlencode($pesan) . '&tujuan=' . rawurlencode($tujuan . '@s.whatsapp.net'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'apikey: ' . $apikey
            ),
        ));


        $result = curl_exec($curl);
        $result = json_decode($result, true);
        curl_close($curl);
        if ($result['status'] == 1) {
            $ci->db->set('send_paid', date('Y-m-d H:i:s'));
            $ci->db->where('invoice', $invoice);
            $ci->db->update('invoice');
        }
    }
    if ($whatsapp['vendor'] == 'Other') {
        $apikey = $whatsapp['token'];
        $sender = $whatsapp['username'];
        $data = [
            'api_key' => $apikey,
            'sender' => $sender,
            'number' => $target,
            'message' => $message
        ];



        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL =>  "$whatsapp[domain_api]/send-message",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;
        $result = json_decode($response, true);
        if ($result['status'] == 'sent') {
            $ci->db->set('send_paid', date('Y-m-d H:i:s'));
            $ci->db->where('invoice', $invoice);
            $ci->db->update('invoice');
        }
    }
    if ($whatsapp['vendor'] == 'Ruangwa') {
        $apikey = $whatsapp['api_key'];
        $phone = indo_tlp($target); //atau bisa menggunakan 62812xxxxxxx
        $message = $message;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.ruangwa.id/api/send_message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'token=' . $apikey . '&number=' . $phone . '&message=' . $message,
        ));
        $response = curl_exec($curl);
        $result = json_decode($response, true);
        curl_close($curl);
        // echo $response;
        if ($result['status'] == 'sent') {
            $ci->db->set('send_paid', date('Y-m-d H:i:s'));
            $ci->db->where('invoice', $invoice);
            $ci->db->update('invoice');
        }
    }
}
/**
 * @param string|int $target
 * @param string $message
 * @param int|string $time
 * @param string|int $invoice
 * @return mixed
 */
function sendmsgschbill($target, $message, $time, $invoice)
{
    $ci = get_instance();
    // $bill = $ci->db->get_where('invoice', ['invoice' => $invoice])->row_array();
    $whatsapp = $ci->db->get('whatsapp')->row_array();
    $APIkey = $whatsapp['api_key'];
    if ($whatsapp['vendor'] == 'WAblas') {
        if ($whatsapp['version'] == 0) {
            if ($whatsapp['period'] == 0) {
                $curl = curl_init();
                $token = $whatsapp['token'];
                $dateex = date('Y-m-d', $time);
                $timeex = date('H:i', $time);
                $data = [
                    'phone' => $target,
                    'message' => $message,
                    'date' => $dateex,
                    'time' => $timeex,
                ];

                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/schedule");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_TIMEOUT, 0);
                $result = curl_exec($curl);
                $result = json_decode($result, true);
                curl_close($curl);
                if ($result['status'] == 1) {
                    $ci->db->set('send_bill', $time);
                    $ci->db->where('invoice', $invoice);
                    $ci->db->update('invoice');
                } else {
                }
            } else {
                $curl = curl_init();
                $token = $whatsapp['token'];

                $data = [
                    'phone' => indo_tlp($target),
                    'message' => $message,
                    'secret' => false, // or true
                    'priority' => true, // or true
                ];

                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/send-message");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                $result = curl_exec($curl);
                $result = json_decode($result, true);
                curl_close($curl);

                if ($result['status'] == 1) {
                    $ci->db->set('send_bill', date('Y-m-d H:i:s'));
                    $ci->db->where('invoice', $invoice);
                    $ci->db->update('invoice');
                } else {
                }
            }
        } else {
            if ($whatsapp['period'] == 0) {
                $curl = curl_init();
                $token =  $whatsapp['token'];
                $payload = [
                    "data" => [
                        [
                            'category' => 'text',
                            'phone' => $target,
                            'scheduled_at' => $time,
                            'text' => $message,
                        ],
                    ]
                ];
                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                        "Content-Type: application/json"
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
                curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/v2/schedule");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

                $result = curl_exec($curl);
                $result = json_decode($result, true);
                // var_dump($result);
                // die;
                curl_close($curl);
                if ($result['status'] == 1) {
                    $ci->db->set('send_bill',  $time);
                    $ci->db->where('invoice', $invoice);
                    $ci->db->update('invoice');
                } else {
                    $ci->session->set_flashdata('error-sweet', $result['message']);
                }
            } else {
                $token = $whatsapp['token'];
                $curl = curl_init();

                $data = [
                    'phone' => indo_tlp($target),
                    'message' => $message,
                    'secret' => false,
                    'retry' => false,
                    'isGroup' => false
                ];

                $payload[] = [
                    'phone' => indo_tlp($target),
                    'message' => $message,
                    'secret' => false,
                    'retry' => false,
                    'isGroup' => false
                ];
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "$whatsapp[domain_api]/api/v2/send-message",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 5,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode(['data' => $payload]),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: ' . $token,
                        'Content-Type: application/json'
                    ),
                ));
                $result = curl_exec($curl);
                $result = json_decode($result, true);
                curl_close($curl);
                if ($result['status'] == 1) {
                    $ci->db->set('send_bill',  date('Y-m-d H:i:s'));
                    $ci->db->where('invoice', $invoice);
                    $ci->db->update('invoice');
                } else {
                    $ci->session->set_flashdata('error-sweet', $result['message']);
                }
            }
        }
    }
    if ($whatsapp['vendor'] == 'Starsender') {
        if ($whatsapp['period'] == 0) {
            $apikey = $APIkey;
            $tujuan = $target;
            $pesan = $message;
            $jadwal = $time;
            // echo $jadwal;
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://starsender.online/api/v2/sendText?message=' . rawurlencode($pesan) . '&tujuan=' . rawurlencode($tujuan . '@s.whatsapp.net') . '&jadwal=' . rawurlencode($jadwal),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'apikey: ' . $apikey
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $result = json_decode($response, true);
            if ($result['status'] == 1) {
                $ci->db->set('send_bill', $time);
                $ci->db->where('invoice', $invoice);
                $ci->db->update('invoice');
            } else {
                $ci->session->set_flashdata('error-sweet', $result['message']);
            }
        } else {
            $apikey = $whatsapp['api_key'];
            $tujuan = indo_tlp($target);
            $pesan = $message;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://starsender.online/api/sendText?message=' . rawurlencode($pesan) . '&tujuan=' . rawurlencode($tujuan . '@s.whatsapp.net'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'apikey: ' . $apikey
                ),
            ));


            $result = curl_exec($curl);
            $result = json_decode($result, true);
            curl_close($curl);

            if ($result['status'] == 1) {
                $ci->db->set('send_bill', date('Y-m-d H:i:s'));
                $ci->db->where('invoice', $invoice);
                $ci->db->update('invoice');
            }
        }
    }
    if ($whatsapp['vendor'] == 'Other') {
        $apikey = $whatsapp['token'];
        $sender = $whatsapp['username'];
        $data = [
            'api_key' => $apikey,
            'sender' => $sender,
            'number' => $target,
            'message' => $message
        ];



        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL =>  "$whatsapp[domain_api]/send-message",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;

        $result = json_decode($response, true);
        if ($result['status'] == 'sent') {
            $ci->db->set('send_bill', date('Y-m-d H:i:s'));
            $ci->db->where('invoice', $invoice);
            $ci->db->update('invoice');
        }
    }
    if ($whatsapp['vendor'] == 'Ruangwa') {
        $apikey = $whatsapp['api_key'];
        $phone = indo_tlp($target); //atau bisa menggunakan 62812xxxxxxx
        $message = $message;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.ruangwa.id/api/send_message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'token=' . $apikey . '&number=' . $phone . '&message=' . $message,
        ));
        $response = curl_exec($curl);
        $result = json_decode($response, true);
        curl_close($curl);
        // echo $response;
        if ($result['status'] == 'sent') {
            $ci->db->set('send_bill', date('Y-m-d H:i:s'));
            $ci->db->where('invoice', $invoice);
            $ci->db->update('invoice');
        } else {
            $ci->session->set_flashdata('error-sweet', $result['message']);
        }
    }
}
/**
 * @param string|int $target
 * @param string $message
 * @param int|string $time
 * @param string|int $invoice
 * @return mixed
 */
function sendmsgschbillpaid($target, $message, $time, $invoice)
{
    $ci = get_instance();
    // $bill = $ci->db->get_where('invoice', ['invoice' => $invoice])->row_array();
    $whatsapp = $ci->db->get('whatsapp')->row_array();
    $APIkey = $whatsapp['api_key'];
    if ($whatsapp['vendor'] == 'WAblas') {
        if ($whatsapp['version'] == 0) {
            if ($whatsapp['period'] == 0) {
                $curl = curl_init();
                $token = $whatsapp['token'];
                $dateex = date('Y-m-d', $time);
                $timeex = date('H:i', $time);
                $data = [
                    'phone' => $target,
                    'message' => $message,
                    'date' => $dateex,
                    'time' => $timeex,
                ];

                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/schedule");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_TIMEOUT, 0);
                $result = curl_exec($curl);
                $result = json_decode($result, true);
                curl_close($curl);
                if ($result['status'] == 1) {
                    $ci->db->set('send_paid', $time);
                    $ci->db->where('invoice', $invoice);
                    $ci->db->update('invoice');
                } else {
                    $ci->session->set_flashdata('error-sweet', $result['message']);
                }
            } else {
                $curl = curl_init();
                $token = $whatsapp['token'];

                $data = [
                    'phone' => indo_tlp($target),
                    'message' => $message,
                    'secret' => false, // or true
                    'priority' => true, // or true
                ];

                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/send-message");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                $result = curl_exec($curl);
                $result = json_decode($result, true);
                curl_close($curl);

                if ($result['status'] == 1) {
                    $ci->db->set('send_paid', date('Y-m-d H:i:s'));
                    $ci->db->where('invoice', $invoice);
                    $ci->db->update('invoice');
                } else {
                    $ci->session->set_flashdata('error-sweet', $result['message']);
                }
            }
        } else {
            if ($whatsapp['period'] == 0) {
                $curl = curl_init();
                $token =  $whatsapp['token'];
                $payload = [
                    "data" => [
                        [
                            'category' => 'text',
                            'phone' => $target,
                            'scheduled_at' => $time,
                            'text' => $message,
                        ],
                    ]
                ];
                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                        "Content-Type: application/json"
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
                curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/v2/schedule");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

                $result = curl_exec($curl);
                $result = json_decode($result, true);
                curl_close($curl);
                if ($result['status'] == 1) {
                    $ci->db->set('send_paid',  $time);
                    $ci->db->where('invoice', $invoice);
                    $ci->db->update('invoice');
                } else {
                    $ci->session->set_flashdata('error-sweet', $result['message']);
                }
            } else {
                $token = $whatsapp['token'];
                $curl = curl_init();

                $data = [
                    'phone' => indo_tlp($target),
                    'message' => $message,
                    'secret' => false,
                    'retry' => false,
                    'isGroup' => false
                ];

                $payload[] = [
                    'phone' => indo_tlp($target),
                    'message' => $message,
                    'secret' => false,
                    'retry' => false,
                    'isGroup' => false
                ];
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "$whatsapp[domain_api]/api/v2/send-message",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 5,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode(['data' => $payload]),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: ' . $token,
                        'Content-Type: application/json'
                    ),
                ));
                $result = curl_exec($curl);
                $result = json_decode($result, true);
                curl_close($curl);
                if ($result['status'] == 1) {
                    $ci->db->set('send_paid',  date('Y-m-d H:i:s'));
                    $ci->db->where('invoice', $invoice);
                    $ci->db->update('invoice');
                } else {
                    $ci->session->set_flashdata('error-sweet', $result['message']);
                }
            }
        }
    }
    if ($whatsapp['vendor'] == 'Starsender') {
        if ($whatsapp['period'] == 0) {
            $apikey = $APIkey;
            $tujuan = $target;
            $pesan = $message;
            $jadwal = $time;
            // echo $jadwal;
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://starsender.online/api/v2/sendText?message=' . rawurlencode($pesan) . '&tujuan=' . rawurlencode($tujuan . '@s.whatsapp.net') . '&jadwal=' . rawurlencode($jadwal),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'apikey: ' . $apikey
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $result = json_decode($response, true);
            if ($result['status'] == 1) {
                $ci->db->set('send_paid', $time);
                $ci->db->where('invoice', $invoice);
                $ci->db->update('invoice');
            } else {
                $ci->session->set_flashdata('error-sweet', $result['message']);
            }
        } else {
            $apikey = $whatsapp['api_key'];
            $tujuan = indo_tlp($target);
            $pesan = $message;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://starsender.online/api/sendText?message=' . rawurlencode($pesan) . '&tujuan=' . rawurlencode($tujuan . '@s.whatsapp.net'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'apikey: ' . $apikey
                ),
            ));


            $result = curl_exec($curl);
            $result = json_decode($result, true);
            curl_close($curl);

            if ($result['status'] == 1) {
                $ci->db->set('send_paid', date('Y-m-d H:i:s'));
                $ci->db->where('invoice', $invoice);
                $ci->db->update('invoice');
            }
        }
    }
    if ($whatsapp['vendor'] == 'Other') {
        $apikey = $whatsapp['token'];
        $sender = $whatsapp['username'];
        $data = [
            'api_key' => $apikey,
            'sender' => $sender,
            'number' => $target,
            'message' => $message
        ];



        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL =>  "$whatsapp[domain_api]/send-message",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;

        $result = json_decode($response, true);
        if ($result['status'] == 'sent') {
            $ci->db->set('send_paid', date('Y-m-d H:i:s'));
            $ci->db->where('invoice', $invoice);
            $ci->db->update('invoice');
        }
    }
    if ($whatsapp['vendor'] == 'Ruangwa') {
        $apikey = $whatsapp['api_key'];
        $phone = indo_tlp($target); //atau bisa menggunakan 62812xxxxxxx
        $message = $message;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.ruangwa.id/api/send_message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'token=' . $apikey . '&number=' . $phone . '&message=' . $message,
        ));
        $response = curl_exec($curl);
        $result = json_decode($response, true);
        curl_close($curl);
        // echo $response;
        if ($result['status'] == 'sent') {
            $ci->db->set('send_paid', date('Y-m-d H:i:s'));
            $ci->db->where('invoice', $invoice);
            $ci->db->update('invoice');
        } else {
            $ci->session->set_flashdata('error-sweet', $result['message']);
        }
    }
}
/**
 * @param string|int $target
 * @param string $message
 * @param int|string $time
 * @return mixed
 */
function sendmsgsch($target, $message, $time)
{
    $ci = get_instance();
    $whatsapp = $ci->db->get('whatsapp')->row_array();
    $APIkey = $whatsapp['api_key'];

    if ($whatsapp['vendor'] == 'WAblas') {
        if ($whatsapp['version'] == 0) {
            if ($whatsapp['period'] == 0) {
                $curl = curl_init();
                $token = $whatsapp['token'];
                $dateex = date('Y-m-d', $time);
                $timeex = date('H:i', $time);
                $data = [
                    'phone' => $target,
                    'message' => $message,
                    'date' => $dateex,
                    'time' => $timeex,
                ];

                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/schedule");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_TIMEOUT, 0);
                $result = curl_exec($curl);
                curl_close($curl);
            } else {
                $curl = curl_init();
                $token = $whatsapp['token'];

                $data = [
                    'phone' => indo_tlp($target),
                    'message' => $message,
                    'secret' => false, // or true
                    'priority' => true, // or true
                ];

                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/send-message");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                $result = curl_exec($curl);
                $result = json_decode($result, true);
                curl_close($curl);
            }
        } else {
            if ($whatsapp['period'] == 0) {
                $curl = curl_init();
                $token =  $whatsapp['token'];
                $payload = [
                    "data" => [
                        [
                            'category' => 'text',
                            'phone' => $target,
                            'scheduled_at' => $time,
                            'text' => $message,
                        ],
                    ]
                ];
                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                        "Content-Type: application/json"
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
                curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/v2/schedule");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

                $result = curl_exec($curl);
                $result = json_decode($result, true);
                curl_close($curl);
            } else {
                $token = $whatsapp['token'];
                $curl = curl_init();

                $data = [
                    'phone' => indo_tlp($target),
                    'message' => $message,
                    'secret' => false,
                    'retry' => false,
                    'isGroup' => false
                ];

                $payload[] = [
                    'phone' => indo_tlp($target),
                    'message' => $message,
                    'secret' => false,
                    'retry' => false,
                    'isGroup' => false
                ];
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "$whatsapp[domain_api]/api/v2/send-message",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 5,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode(['data' => $payload]),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: ' . $token,
                        'Content-Type: application/json'
                    ),
                ));
                $response = curl_exec($curl);
            }
        }
    }
    if ($whatsapp['vendor'] == 'Starsender') {
        if ($whatsapp['period'] == 0) {
            $apikey = $APIkey;
            $tujuan = $target;
            $pesan = $message;
            $jadwal = $time;
            // echo $jadwal;
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://starsender.online/api/v2/sendText?message=' . rawurlencode($pesan) . '&tujuan=' . rawurlencode($tujuan . '@s.whatsapp.net') . '&jadwal=' . rawurlencode($jadwal),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'apikey: ' . $apikey
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
        } else {
            $apikey = $whatsapp['api_key'];
            $tujuan = indo_tlp($target);
            $pesan = $message;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://starsender.online/api/sendText?message=' . rawurlencode($pesan) . '&tujuan=' . rawurlencode($tujuan . '@s.whatsapp.net'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'apikey: ' . $apikey
                ),
            ));


            $result = curl_exec($curl);
            $result = json_decode($result, true);
            curl_close($curl);
            // if ($result['status'] == 1) {
            //     $ci->session->set_flashdata('success-sweet', $result['message']);
            // } else {
            //     $ci->session->set_flashdata('error-sweet', $result['message']);
            // }
        }
    }
    if ($whatsapp['vendor'] == 'Ruangwa') {
        $apikey = $whatsapp['api_key'];
        $phone = indo_tlp($target); //atau bisa menggunakan 62812xxxxxxx
        $message = $message;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.ruangwa.id/api/send_message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'token=' . $apikey . '&number=' . $phone . '&message=' . $message,
        ));
        $response = curl_exec($curl);
        $result = json_decode($response, true);
        curl_close($curl);
        // echo $response;
        // if ($result['status'] == 'sent') {
        //     $ci->session->set_flashdata('success', $result['message']);
        // } else {
        //     $ci->session->set_flashdata('error', $result['message']);
        // }
    }
    if ($whatsapp['vendor'] == 'Other') {
        $apikey = $whatsapp['token'];
        $sender = $whatsapp['username'];
        $data = [
            'api_key' => $apikey,
            'sender' => $sender,
            'number' => $target,
            'message' => $message
        ];



        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL =>  "$whatsapp[domain_api]/send-message",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;

        // if ($result['status'] == 'true') {
        //     $ci->session->set_flashdata('success', $result['msg']);
        // } else {
        //     $ci->session->set_flashdata('error', $result['msg']);
        // }
    }
}

/**
 * @param string|int $target
 * @param string $message
 * @param int|string $time
 * @param string|int $invoice
 * @return mixed
 */
function sendmsgschduedate($target, $message, $time, $invoice)
{
    $ci = get_instance();
    // $bill = $ci->db->get_where('invoice', ['invoice' => $invoice])->row_array();
    $whatsapp = $ci->db->get('whatsapp')->row_array();
    $APIkey = $whatsapp['api_key'];
    if ($whatsapp['vendor'] == 'WAblas') {
        if ($whatsapp['version'] == 0) {
            if ($whatsapp['period'] == 0) {
                $curl = curl_init();
                $token = $whatsapp['token'];
                $dateex = date('Y-m-d', $time);
                $timeex = date('H:i', $time);
                $data = [
                    'phone' => $target,
                    'message' => $message,
                    'date' => $dateex,
                    'time' => $timeex,
                ];

                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/schedule");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_TIMEOUT, 0);
                $result = curl_exec($curl);
                $result = json_decode($result, true);
                curl_close($curl);
                if ($result['status'] == 1) {
                    $ci->db->set('send_due', date('Y-m-d H:i:s'));
                    $ci->db->where('invoice', $invoice);
                    $ci->db->update('invoice');
                } else {
                }
            } else {
                $curl = curl_init();
                $token = $whatsapp['token'];

                $data = [
                    'phone' => indo_tlp($target),
                    'message' => $message,
                    'secret' => false, // or true
                    'priority' => true, // or true
                ];

                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/send-message");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                $result = curl_exec($curl);
                $result = json_decode($result, true);
                curl_close($curl);

                if ($result['status'] == 1) {
                    $ci->db->set('send_due', date('Y-m-d H:i:s'));
                    $ci->db->where('invoice', $invoice);
                    $ci->db->update('invoice');
                } else {
                }
            }
        } else {
            if ($whatsapp['period'] == 0) {
                $curl = curl_init();
                $token =  $whatsapp['token'];
                $payload = [
                    "data" => [
                        [
                            'category' => 'text',
                            'phone' => $target,
                            'scheduled_at' => $time,
                            'text' => $message,
                        ],
                    ]
                ];
                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                        "Content-Type: application/json"
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
                curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/v2/schedule");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

                $result = curl_exec($curl);
                $result = json_decode($result, true);
                curl_close($curl);
                if ($result['status'] == 1) {
                    $ci->db->set('send_due', $time);
                    $ci->db->where('invoice', $invoice);
                    $ci->db->update('invoice');
                } else {
                }
            } else {
                $token = $whatsapp['token'];
                $curl = curl_init();

                $data = [
                    'phone' => indo_tlp($target),
                    'message' => $message,
                    'secret' => false,
                    'retry' => false,
                    'isGroup' => false
                ];

                $payload[] = [
                    'phone' => indo_tlp($target),
                    'message' => $message,
                    'secret' => false,
                    'retry' => false,
                    'isGroup' => false
                ];
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "$whatsapp[domain_api]/api/v2/send-message",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 5,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode(['data' => $payload]),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: ' . $token,
                        'Content-Type: application/json'
                    ),
                ));
                $result = curl_exec($curl);
                $result = json_decode($result, true);
                curl_close($curl);
                if ($result['status'] == 1) {
                    $ci->db->set('send_due', date('Y-m-d H:i:s'));
                    $ci->db->where('invoice', $invoice);
                    $ci->db->update('invoice');
                } else {
                }
            }
        }
    }
    if ($whatsapp['vendor'] == 'Starsender') {
        if ($whatsapp['period'] == 0) {
            $apikey = $APIkey;
            $tujuan = $target;
            $pesan = $message;
            $jadwal = $time;
            // echo $jadwal;
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://starsender.online/api/v2/sendText?message=' . rawurlencode($pesan) . '&tujuan=' . rawurlencode($tujuan . '@s.whatsapp.net') . '&jadwal=' . rawurlencode($jadwal),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'apikey: ' . $apikey
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $result = json_decode($response, true);
            if ($result['status'] == 1) {
                $ci->db->set('send_due', date('Y-m-d H:i:s'));
                $ci->db->where('invoice', $invoice);
                $ci->db->update('invoice');
            } else {
            }
        } else {
            $apikey = $whatsapp['api_key'];
            $tujuan = indo_tlp($target);
            $pesan = $message;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://starsender.online/api/sendText?message=' . rawurlencode($pesan) . '&tujuan=' . rawurlencode($tujuan . '@s.whatsapp.net'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'apikey: ' . $apikey
                ),
            ));


            $result = curl_exec($curl);
            $result = json_decode($result, true);
            curl_close($curl);

            if ($result['status'] == 1) {
                $ci->db->set('send_due', date('Y-m-d H:i:s'));
                $ci->db->where('invoice', $invoice);
                $ci->db->update('invoice');
            }
        }
    }
    if ($whatsapp['vendor'] == 'Other') {
        $apikey = $whatsapp['token'];
        $sender = $whatsapp['username'];
        $data = [
            'api_key' => $apikey,
            'sender' => $sender,
            'number' => $target,
            'message' => $message
        ];



        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL =>  "$whatsapp[domain_api]/send-message",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;
        $result = json_decode($response, true);
        if ($result['status'] == 'sent') {
            $ci->db->set('send_due', date('Y-m-d H:i:s'));
            $ci->db->where('invoice', $invoice);
            $ci->db->update('invoice');
        }
    }
    if ($whatsapp['vendor'] == 'Ruangwa') {
        $apikey = $whatsapp['api_key'];
        $phone = indo_tlp($target); //atau bisa menggunakan 62812xxxxxxx
        $message = $message;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.ruangwa.id/api/send_message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'token=' . $apikey . '&number=' . $phone . '&message=' . $message,
        ));
        $response = curl_exec($curl);
        $result = json_decode($response, true);
        curl_close($curl);
        // echo $response;
        if ($result['status'] == 'sent') {
            $ci->db->set('send_due', date('Y-m-d H:i:s'));
            $ci->db->where('invoice', $invoice);
            $ci->db->update('invoice');
        }
    }
}
/**
 * @param string|int $target
 * @param string $message
 * @param int|string $time
 * @param string|int $invoice
 * @return mixed
 */
function sendmsgschbeforedue($target, $message, $time, $invoice)
{
    $ci = get_instance();
    // $bill = $ci->db->get_where('invoice', ['invoice' => $invoice])->row_array();
    $whatsapp = $ci->db->get('whatsapp')->row_array();
    $APIkey = $whatsapp['api_key'];
    if ($whatsapp['vendor'] == 'WAblas') {
        if ($whatsapp['version'] == 0) {
            if ($whatsapp['period'] == 0) {
                $curl = curl_init();
                $token = $whatsapp['token'];
                $dateex = date('Y-m-d', $time);
                $timeex = date('H:i', $time);
                $data = [
                    'phone' => $target,
                    'message' => $message,
                    'date' => $dateex,
                    'time' => $timeex,
                ];

                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/schedule");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_TIMEOUT, 0);
                $result = curl_exec($curl);
                $result = json_decode($result, true);
                curl_close($curl);
                if ($result['status'] == 1) {
                    $ci->db->set('send_before_due', $time);
                    $ci->db->where('invoice', $invoice);
                    $ci->db->update('invoice');
                } else {
                }
            } else {
                $curl = curl_init();
                $token = $whatsapp['token'];

                $data = [
                    'phone' => indo_tlp($target),
                    'message' => $message,
                    'secret' => false, // or true
                    'priority' => true, // or true
                ];

                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/send-message");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                $result = curl_exec($curl);
                $result = json_decode($result, true);
                curl_close($curl);

                if ($result['status'] == 1) {
                    $ci->db->set('send_before_due',  date('Y-m-d H:i:s'));
                    $ci->db->where('invoice', $invoice);
                    $ci->db->update('invoice');
                } else {
                }
            }
        } else {
            if ($whatsapp['period'] == 0) {
                $curl = curl_init();
                $token =  $whatsapp['token'];
                $payload = [
                    "data" => [
                        [
                            'category' => 'text',
                            'phone' => $target,
                            'scheduled_at' => $time,
                            'text' => $message,
                        ],
                    ]
                ];
                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                        "Content-Type: application/json"
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
                curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/v2/schedule");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

                $result = curl_exec($curl);
                $result = json_decode($result, true);
                curl_close($curl);
                if ($result['status'] == 1) {
                    $ci->db->set('send_before_due', $time);
                    $ci->db->where('invoice', $invoice);
                    $ci->db->update('invoice');
                } else {
                }
            } else {
                $token = $whatsapp['token'];
                $curl = curl_init();

                $data = [
                    'phone' => indo_tlp($target),
                    'message' => $message,
                    'secret' => false,
                    'retry' => false,
                    'isGroup' => false
                ];

                $payload[] = [
                    'phone' => indo_tlp($target),
                    'message' => $message,
                    'secret' => false,
                    'retry' => false,
                    'isGroup' => false
                ];
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "$whatsapp[domain_api]/api/v2/send-message",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 5,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode(['data' => $payload]),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: ' . $token,
                        'Content-Type: application/json'
                    ),
                ));
                $result = curl_exec($curl);
                $result = json_decode($result, true);
                curl_close($curl);
                if ($result['status'] == 1) {
                    $ci->db->set('send_before_due',  date('Y-m-d H:i:s'));
                    $ci->db->where('invoice', $invoice);
                    $ci->db->update('invoice');
                } else {
                }
            }
        }
    }
    if ($whatsapp['vendor'] == 'Starsender') {
        if ($whatsapp['period'] == 0) {
            $apikey = $APIkey;
            $tujuan = $target;
            $pesan = $message;
            $jadwal = $time;
            // echo $jadwal;
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://starsender.online/api/v2/sendText?message=' . rawurlencode($pesan) . '&tujuan=' . rawurlencode($tujuan . '@s.whatsapp.net') . '&jadwal=' . rawurlencode($jadwal),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'apikey: ' . $apikey
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $result = json_decode($response, true);
            if ($result['status'] == 1) {
                $ci->db->set('send_before_due', $time);
                $ci->db->where('invoice', $invoice);
                $ci->db->update('invoice');
            } else {
            }
        } else {
            $apikey = $whatsapp['api_key'];
            $tujuan = indo_tlp($target);
            $pesan = $message;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://starsender.online/api/sendText?message=' . rawurlencode($pesan) . '&tujuan=' . rawurlencode($tujuan . '@s.whatsapp.net'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'apikey: ' . $apikey
                ),
            ));


            $result = curl_exec($curl);
            $result = json_decode($result, true);
            curl_close($curl);

            if ($result['status'] == 1) {
                $ci->db->set('send_before_due', date('Y-m-d H:i:s'));
                $ci->db->where('invoice', $invoice);
                $ci->db->update('invoice');
            }
        }
    }
    if ($whatsapp['vendor'] == 'Other') {
        $apikey = $whatsapp['token'];
        $sender = $whatsapp['username'];
        $data = [
            'api_key' => $apikey,
            'sender' => $sender,
            'number' => $target,
            'message' => $message
        ];



        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL =>  "$whatsapp[domain_api]/send-message",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;



        $result = json_decode($response, true);
        if ($result['status'] == 'sent') {
            $ci->db->set('send_before_due', date('Y-m-d H:i:s'));
            $ci->db->where('invoice', $invoice);
            $ci->db->update('invoice');
        }
    }
    if ($whatsapp['vendor'] == 'Ruangwa') {
        $apikey = $whatsapp['api_key'];
        $phone = indo_tlp($target); //atau bisa menggunakan 62812xxxxxxx
        $message = $message;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.ruangwa.id/api/send_message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'token=' . $apikey . '&number=' . $phone . '&message=' . $message,
        ));
        $response = curl_exec($curl);
        $result = json_decode($response, true);
        curl_close($curl);
        // echo $response;
        if ($result['status'] == 'sent') {
            $ci->db->set('send_before_due',  date('Y-m-d H:i:s'));
            $ci->db->where('invoice', $invoice);
            $ci->db->update('invoice');
        } else {
        }
    }
}

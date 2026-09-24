<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Telegram Helper untuk Billing System (CodeIgniter 3)
 * Menangani pengiriman pesan dan notifikasi tiket via Bot Telegram secara aman & non-blocking.
 */

if (!function_exists('send_telegram_bot_message')) {
    /**
     * Kirim pesan teks format HTML ke chat / grup Telegram menggunakan cURL.
     *
     * @param string $message
     * @param string|null $target_chat_id Jika null, akan mengambil id_group_teknisi dari tabel bot_telegram
     * @param array|null $reply_markup
     * @return bool
     */
    function send_telegram_bot_message($message, $target_chat_id = null, $reply_markup = null)
    {
        $ci = &get_instance();

        // Ambil konfigurasi bot dari database
        $bot = $ci->db->get('bot_telegram')->row_array();
        if (empty($bot) || empty($bot['token'])) {
            return false;
        }

        $token   = trim($bot['token']);
        $chat_id = !empty($target_chat_id) ? trim($target_chat_id) : (!empty($bot['id_group_teknisi']) ? trim($bot['id_group_teknisi']) : null);

        if (empty($chat_id)) {
            return false;
        }

        $payload = [
            'chat_id'                  => $chat_id,
            'text'                     => $message,
            'parse_mode'               => 'html',
            'disable_web_page_preview' => false,
        ];

        if (!empty($reply_markup) && is_array($reply_markup)) {
            $payload['reply_markup'] = json_encode($reply_markup);
        }

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        // Eksekusi cURL dengan batasan timeout agar tidak menghambat response time web
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL            => $url,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => http_build_query($payload),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 4,
                CURLOPT_CONNECTTIMEOUT => 3,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ]);

            $result = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            return ($http_code === 200);
        } else {
            // Fallback via file_get_contents dengan stream context timeout
            $context = stream_context_create([
                'http' => [
                    'method'  => 'POST',
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'content' => http_build_query($payload),
                    'timeout' => 4,
                ],
                'ssl' => [
                    'verify_peer'      => false,
                    'verify_peer_name' => false,
                ]
            ]);

            $res = @file_get_contents($url, false, $context);
            return ($res !== false);
        }
    }
}

if (!function_exists('notify_telegram_ticket')) {
    /**
     * Memformat dan mengirim notifikasi tiket ke grup Telegram teknisi.
     *
     * @param array $ticket_data Data tiket (help/customer/central)
     * @param string $action_type 'created' | 'assigned' | 'status_updated' | 'closed'
     * @return bool
     */
    function notify_telegram_ticket(array $ticket_data, $action_type = 'status_updated')
    {
        $ci = &get_instance();

        $status = strtolower($ticket_data['status'] ?? 'pending');

        // Tentukan header
        switch ($action_type) {
            case 'created':
                $header = "🆕 <b>TIKET GANGGUAN BARU</b>";
                break;
            case 'assigned':
                $header = "👷 <b>PENUGASAN TEKNISI TIKET</b>";
                break;
            case 'closed':
                $header = "✅ <b>TIKET SELESAI (CLOSED)</b>";
                break;
            case 'status_updated':
            default:
                if ($status === 'close' || $status === 'done') {
                    $header = "✅ <b>TIKET SELESAI (CLOSED)</b>";
                } elseif ($status === 'process') {
                    $header = "⚙️ <b>TIKET SEDANG DIPROSES</b>";
                } else {
                    $header = "🛠️ <b>UPDATE STATUS TIKET</b>";
                }
                break;
        }

        // Status badge
        if ($status === 'process') {
            $badge = "🔵 <b>SEDANG DIPROSES</b>";
        } elseif ($status === 'close' || $status === 'done') {
            $badge = "🟢 <b>SELESAI (CLOSE)</b>";
        } else {
            $badge = "🟡 <b>PENDING (MENUNGGU)</b>";
        }

        $no_ticket   = htmlspecialchars($ticket_data['no_ticket'] ?? ($ticket_data['ticket_number'] ?? '-'), ENT_QUOTES, 'UTF-8');
        $name        = htmlspecialchars($ticket_data['name'] ?? ($ticket_data['customer_name'] ?? '-'), ENT_QUOTES, 'UTF-8');
        $no_services = htmlspecialchars($ticket_data['no_services'] ?? '-', ENT_QUOTES, 'UTF-8');
        $phone       = htmlspecialchars($ticket_data['phone'] ?? ($ticket_data['no_wa'] ?? ($ticket_data['customer_phone'] ?? '-')), ENT_QUOTES, 'UTF-8');
        $address     = htmlspecialchars($ticket_data['address'] ?? ($ticket_data['customer_address'] ?? '-'), ENT_QUOTES, 'UTF-8');
        $topic       = htmlspecialchars($ticket_data['topic'] ?? ($ticket_data['category_name'] ?? ($ticket_data['type_name'] ?? 'Gangguan Umum')), ENT_QUOTES, 'UTF-8');
        $laporan     = htmlspecialchars($ticket_data['laporan'] ?? ($ticket_data['hs_name'] ?? ($ticket_data['problem_description'] ?? ($ticket_data['description'] ?? '-'))), ENT_QUOTES, 'UTF-8');
        $remark      = htmlspecialchars($ticket_data['remark'] ?? '', ENT_QUOTES, 'UTF-8');
        $technician  = htmlspecialchars($ticket_data['technician_name'] ?? ($ticket_data['teknisi_name'] ?? 'Belum Ditugaskan'), ENT_QUOTES, 'UTF-8');
        $actor       = htmlspecialchars($ticket_data['actor'] ?? ($ticket_data['updated_by_name'] ?? ($ticket_data['create_by_name'] ?? 'Petugas')), ENT_QUOTES, 'UTF-8');

        try {
            $dt = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
            $time_now = $dt->format('d-m-Y H:i:s') . ' WIB';
        } catch (\Throwable $e) {
            $time_now = date('d-m-Y H:i:s') . ' WIB';
        }

        $lines = [
            $header,
            "━━━━━━━━━━━━━━━━━━━━",
            "📌 <b>No Tiket:</b> <code>#{$no_ticket}</code>",
            "👤 <b>Pelanggan:</b> {$name} ({$no_services})",
            "📞 <b>No Telp / WA:</b> {$phone}",
            "📍 <b>Alamat:</b> {$address}",
            "⚠️ <b>Topik Gangguan:</b> {$topic}",
            "📋 <b>Keluhan / Laporan:</b> {$laporan}",
            "",
            "📊 <b>Status:</b> {$badge}",
            "👷 <b>Teknisi:</b> {$technician}",
        ];

        if (!empty($remark)) {
            $lines[] = "📝 <b>Catatan Tindakan:</b>\n<i>{$remark}</i>";
        }

        $lines[] = "";
        $lines[] = "👤 <b>Oleh:</b> {$actor}";
        $lines[] = "🕒 <b>Waktu:</b> {$time_now}";

        // Tautan peta Google Maps jika tersedia
        $lat = !empty($ticket_data['latitude']) ? trim($ticket_data['latitude']) : null;
        $lng = !empty($ticket_data['longitude']) ? trim($ticket_data['longitude']) : null;

        if (!empty($lat) && !empty($lng)) {
            $maps_url = "https://www.google.com/maps/dir/?api=1&destination={$lat},{$lng}";
            $lines[] = "━━━━━━━━━━━━━━━━━━━━";
            $lines[] = "🗺️ <a href=\"{$maps_url}\">Buka Rute Google Maps Pelanggan</a>";
        }

        $full_message = implode("\n", $lines);

        return send_telegram_bot_message($full_message);
    }
}

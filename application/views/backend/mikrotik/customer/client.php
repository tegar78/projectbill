    <?php $this->view('messages') ?>
    <?php $cekbillisolir = $this->customer_m->getrecheckisolir($customer['router'], $customer['no_services'])->row_array();
    if ($cekbillisolir > 0) {
        isolir($customer['no_services'], $customer['router']);
    } else {
    }
    ?>
    <?php
    $router = $this->db->get_where('router', ['id' => $customer['router']])->row_array();
    $ip = $router['ip_address'];
    $user = $router['username'];
    $pass = $router['password'];
    $port = $router['port'];
    $API = new Mikweb();
    $usermikrotik = $customer['user_mikrotik'];
    $API->connect($ip, $user, $pass, $port);
    if ($customer['user_mikrotik'] != '') {
        // countusage($customer['no_services'], $customer['router']);
    }
    // Mode Hotspot
    if ($customer['mode_user'] == 'Hotspot') {
        # code...
        $hotspotactive = $API->comm("/ip/hotspot/active/print", array("?user" => $usermikrotik));
        $userhotspot = $API->comm("/ip/hotspot/user/print", array("?name" => $usermikrotik));
        $simplequeuehotspot = $API->comm("/queue/simple/print", array('?name' => '<hotspot-' . $usermikrotik . '>',));
        $userprofilehotspot = $API->comm("/ip/hotspot/user/profile/print", array("?name" => $customer['user_profile']));
        $countuserprofilehotspot = count($userprofilehotspot);
    }

    // Mode PPPOE
    if ($customer['mode_user'] == 'PPPOE') {
        $pppoeactive = $API->comm("/ppp/active/print", array('?service' => 'pppoe', '?name' => $usermikrotik,));
        $userpppoe = $API->comm("/ppp/secret/print", array('?service' => 'pppoe', '?name' => $usermikrotik,));
        $getaddresslist = $API->comm("/ip/firewall/address-list/print", array("?comment" => 'ISOLIR|' . $customer['no_services'] . ''));
        $userprofilepppoe = $API->comm("/ppp/profile/print", array('?name' => $customer['user_profile'],));
        $countuserprofilepppoe = count($userprofilepppoe);
    }


    // Mode Static
    if ($customer['mode_user'] == 'Static') {
        $simplequeue = $API->comm("/queue/simple/print", array('?name' => $usermikrotik,));
        $ipqueue = isset($simplequeue['0']['target']) ? substr($simplequeue['0']['target'], 0, -3) : '';
        $getarp = $API->comm("/ip/arp/print", array("?address" =>  $ipqueue));
        $getfirewall = $API->comm("/ip/firewall/filter/print", array("?comment" => 'ISOLIR|' . $customer['no_services'] . ''));
        $getaddresslist = $API->comm("/ip/firewall/address-list/print", array("?comment" => 'ISOLIR|' . $customer['no_services'] . ''));
    }


    ?>
    <?php if ($customer['mode_user'] == 'Standalone') { ?>
        <?php

        $resource = $API->comm("/system/resource/print");

        ?>

    <?php } ?>
    <?php if ($customer['mode_user'] == 'Hotspot') { ?>
        <?php
        $byte = isset($simplequeuehotspot['0']['bytes']) ? $simplequeuehotspot['0']['bytes'] : '0/0';
        $updl = explode("/", $byte);
        $up = isset($updl['0']) ? $updl['0'] : '0';
        $dl = isset($updl['1']) ? $updl['1'] : '0';
        ?>

        <?php $userprofile = isset($countuserprofilehotspot) ? $countuserprofilehotspot : 0 ?>
    <?php } ?>

    <?php if ($customer['mode_user'] == 'PPPOE') { ?>

        <?php $userprofile = isset($countuserprofilepppoe) ? $countuserprofilepppoe : 0 ?>
    <?php } ?>
    <?php if ($customer['mode_user'] == 'Standalone') { ?>

    <?php } ?>

    <?php if ($customer['mode_user'] == 'Static') { ?>
        <?php
        $byte = isset($simplequeue['0']['bytes']) ? $simplequeue['0']['bytes'] : '0/0';
        $updl = explode("/", $byte);
        $up = isset($updl['0']) ? $updl['0'] : '0';
        $dl = isset($updl['1']) ? $updl['1'] : '0';
        ?>

    <?php } ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="card nm-card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-network-wired mr-2 text-primary"></i>Data Pelanggan (Koneksi)</h6>
                    <span class="badge badge-primary"><?= $customer['mode_user']; ?></span>
                </div>
                <div class="card-body">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="row py-2" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                <div class="col-4 col-sm-4 font-weight-bold" style="color: var(--nm-text-muted);">Nama</div>
                                <div class="col-8 col-sm-8 font-weight-bold" style="color: var(--nm-text-main);">: <?= $customer['name']; ?></div>
                            </div>
                            <div class="row py-2" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                <div class="col-4 col-sm-4 font-weight-bold" style="color: var(--nm-text-muted);">No Layanan</div>
                                <div class="col-8 col-sm-8 font-weight-bold" style="color: var(--nm-text-main);">: <?= $customer['no_services']; ?></div>
                            </div>
                            <div class="row py-2" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                <div class="col-4 col-sm-4 font-weight-bold" style="color: var(--nm-text-muted);">Router</div>
                                <?php $router = $this->db->get_where('router', ['id' => $customer['router']])->row_array() ?>
                                <div class="col-8 col-sm-8 font-weight-bold" style="color: var(--nm-text-main);">: <?= isset($router['alias']) ? $router['alias'] : '-'; ?></div>
                            </div>
                            <div class="row py-2" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                <div class="col-4 col-sm-4 font-weight-bold" style="color: var(--nm-text-muted);">Mode</div>
                                <div class="col-8 col-sm-8 font-weight-bold" style="color: var(--nm-text-main);">: <?= $customer['mode_user']; ?></div>
                            </div>
                            <div class="row py-2" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                <div class="col-4 col-sm-4 font-weight-bold" style="color: var(--nm-text-muted);">User</div>
                                <div class="col-8 col-sm-8 font-weight-bold" style="color: var(--nm-text-main);">: <?= $customer['user_mikrotik']; ?></div>
                            </div>
                            <?php if ($customer['mode_user'] == 'PPPOE') { ?>
                                <div class="row py-2" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                    <div class="col-4 col-sm-4 font-weight-bold" style="color: var(--nm-text-muted);">Uptime</div>
                                    <div class="col-8 col-sm-8 font-weight-bold" style="color: var(--nm-text-main);">: <?= isset($pppoeactive['0']['uptime']) ? formattimemikro($pppoeactive['0']['uptime']) : '-'; ?></div>
                                </div>
                                <div class="row py-2" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                    <div class="col-4 col-sm-4 font-weight-bold" style="color: var(--nm-text-muted);">IP Address</div>
                                    <div class="col-8 col-sm-8 font-weight-bold" style="color: var(--nm-text-main);">: <?= isset($pppoeactive['0']['address']) ? $pppoeactive['0']['address'] : '-'; ?></div>
                                </div>
                            <?php } ?>
                            <?php if ($customer['mode_user'] == 'Static') { ?>
                                <div class="row py-2" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                    <div class="col-4 col-sm-4 font-weight-bold" style="color: var(--nm-text-muted);">IP Address</div>
                                    <div class="col-8 col-sm-8 font-weight-bold" style="color: var(--nm-text-main);">: <?= isset($ipqueue) ? $ipqueue : '-'; ?></div>
                                </div>
                            <?php } ?>
                            <?php if ($customer['mode_user'] == 'Standalone') { ?>
                                <div class="row py-2" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                    <div class="col-4 col-sm-4 font-weight-bold" style="color: var(--nm-text-muted);">Uptime</div>
                                    <div class="col-8 col-sm-8 font-weight-bold" style="color: var(--nm-text-main);">: <?= isset($resource['0']['uptime']) ? formattimemikro($resource['0']['uptime']) : '-'; ?></div>
                                </div>
                            <?php } ?>
                            <?php if ($customer['mode_user'] == 'Hotspot') { ?>
                                <div class="row py-2" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                    <div class="col-4 col-sm-4 font-weight-bold" style="color: var(--nm-text-muted);">Uptime</div>
                                    <div class="col-8 col-sm-8 font-weight-bold" style="color: var(--nm-text-main);">: <?= isset($hotspotactive['0']['uptime']) ? formattimemikro($hotspotactive['0']['uptime']) : '-'; ?></div>
                                </div>
                                <div class="row py-2" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                    <div class="col-4 col-sm-4 font-weight-bold" style="color: var(--nm-text-muted);">IP Address</div>
                                    <div class="col-8 col-sm-8 font-weight-bold" style="color: var(--nm-text-main);">: <?= isset($hotspotactive['0']['address']) ? $hotspotactive['0']['address'] : '-'; ?></div>
                                </div>
                            <?php } ?>
                            <div class="row py-2" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                <div class="col-4 col-sm-4 font-weight-bold" style="color: var(--nm-text-muted);">Pemakaian</div>
                                <?php $usage = $this->mikrotik_m->usagethismonth($customer['no_services'])->result();

                                $totalusage = 0;
                                foreach ($usage as $c => $u) {
                                    if (isset($u->count_usage)) {
                                        $totalusage += $u->count_usage;
                                    }
                                }
                                ?>
                                <?php $last = $this->mikrotik_m->lastusage($customer['no_services'])->row_array() ?>

                                <div class="col-8 col-sm-8 font-weight-bold" style="color: var(--nm-text-main);">: <?= formatBites($totalusage, 2); ?>
                                    <small class="text-muted d-block mt-1">Last Update : <?= !empty($last['last_update']) ? date('d-m-Y  H:i:s', $last['last_update']) : '-'; ?>
                                    <?php $rolepelanggan = $this->db->get_where('role_management', ['role_id' => 2])->row_array() ?>
                                    <?php if (isset($rolepelanggan['is_active']) && $rolepelanggan['is_active'] == 1) { ?>
                                        <?php if ($customer['mode_user'] == 'PPPOE') { ?>
                                            <a href="<?= site_url('mikrotik/refreshpppoe/' . $customer['no_services']) ?>" title="Refresh Pemakaian" class="ml-1"><i class="fas fa-sync text-primary"></i></a>
                                        <?php } ?>
                                        <?php if ($customer['mode_user'] == 'Standalone') { ?>
                                            <a href="<?= site_url('mikrotik/refreshstandalone/' . $customer['no_services']) ?>" title="Refresh Pemakaian" class="ml-1"><i class="fas fa-sync text-primary"></i></a>
                                        <?php } ?>
                                    <?php } ?>
                                    </small>
                                </div>
                            </div>
                            <div class="row py-2" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                <div class="col-4 col-sm-4 font-weight-bold" style="color: var(--nm-text-muted);">Status</div>
                                <div class="col-8 col-sm-8 font-weight-bold" style="color: var(--nm-text-main);">:
                                    <?php if ($customer['mode_user'] == 'Hotspot') { ?>
                                        <?php if ($customer['action'] == 0) { ?>
                                            <?php if (isset($userhotspot['0']['disabled']) && $userhotspot['0']['disabled'] == 'true') {
                                                echo '<div class="badge badge-warning">Isolir</div>';
                                            } elseif (isset($hotspotactive) && count($hotspotactive) > 0) {
                                                echo '<div class="badge badge-success">Active</div>';
                                            } else {
                                                echo '<div class="badge badge-danger">Non-Active</div>';
                                            }
                                            ?>
                                        <?php } ?>
                                        <?php if ($customer['action'] == 1) { ?>
                                            <?php if (isset($userhotspot['0']['profile']) && $userhotspot['0']['profile'] == 'EXPIRED') {
                                                echo '<div class="badge badge-warning">Isolir</div>';
                                            } elseif (isset($hotspotactive) && count($hotspotactive) > 0) {
                                                echo '<div class="badge badge-success">Active</div>';
                                            } else {
                                                echo '<div class="badge badge-danger">Non-Active</div>';
                                            }
                                            ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($customer['mode_user'] == 'PPPOE') { ?>
                                        <?php if ($customer['action'] == 0) { ?>
                                            <?php if (isset($userpppoe['0']['disabled']) && $userpppoe['0']['disabled'] == 'true') {
                                                echo '<div class="badge badge-warning">Isolir</div>';
                                            } elseif (isset($pppoeactive) && count($pppoeactive) > 0) {
                                                echo '<div class="badge badge-success">Active</div>';
                                            } else {
                                                echo '<div class="badge badge-danger">Non-Active</div>';
                                            }
                                            ?>
                                        <?php } ?>
                                        <?php if ($customer['action'] == 1) { ?>
                                            <?php if ((isset($userpppoe['0']['profile']) && $userpppoe['0']['profile'] == 'EXPIRED') or (isset($getaddresslist) && count($getaddresslist) > 0)) {
                                                echo '<div class="badge badge-warning">Isolir</div>';
                                            } elseif (isset($pppoeactive) && count($pppoeactive) > 0) {
                                                echo '<div class="badge badge-success">Active</div>';
                                            } else {
                                                echo '<div class="badge badge-danger">Non-Active</div>';
                                            }
                                            ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($customer['mode_user'] == 'Static') { ?>
                                        <?php if ($customer['action'] == 0) { ?>
                                            <?php if (isset($getfirewall) && count($getfirewall) > 0) {
                                                echo '<div class="badge badge-warning">Isolir</div>';
                                            } elseif (isset($getarp) && count($getarp) > 0) {
                                                echo '<div class="badge badge-success">Active</div>';
                                            } else {
                                                echo '<div class="badge badge-danger">Non-Active</div>';
                                            }
                                            ?>
                                        <?php } ?>
                                        <?php if ($customer['action'] > 0) { ?>
                                            <?php if (isset($getaddresslist) && count($getaddresslist) > 0) {
                                                echo '<div class="badge badge-warning">Isolir</div>';
                                            } elseif (isset($getarp) && count($getarp) > 0) {
                                                echo '<div class="badge badge-success">Active</div>';
                                            } else {
                                                echo '<div class="badge badge-danger">Non-Active</div>';
                                            }
                                            ?>
                                        <?php } ?>

                                    <?php } ?>
                                    <?php if ($customer['mode_user'] == 'Standalone') { ?>
                                        <?php if (isset($resource['0']['uptime']) && $resource['0']['uptime'] > 0) {
                                            echo '<div class="badge badge-success">Active</div>';
                                        } else {
                                            echo '<div class="badge badge-danger">Non-Active</div>';
                                        }
                                        ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if ($customer['auto_isolir'] == 1) { ?>
                                <div class="row py-2" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                    <div class="col-4 col-sm-4 font-weight-bold" style="color: var(--nm-text-muted);">Auto Isolir</div>
                                    <div class="col-8 col-sm-8 font-weight-bold" style="color: var(--nm-text-main);">: <?= $customer['auto_isolir'] == 1 ? 'Yes' : 'No' ?></div>
                                </div>
                                <div class="row py-2" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                    <div class="col-4 col-sm-4 font-weight-bold" style="color: var(--nm-text-muted);">Action Isolir</div>
                                    <div class="col-8 col-sm-8 font-weight-bold" style="color: var(--nm-text-main);">: <?= $customer['action'] == 1 ? 'Pindah Profile' : 'Disable User' ?>
                                        <?php if ($customer['mode_user'] == 'PPPOE' && $customer['type_ip'] == 1) { ?>
                                            <small class="text-muted d-block">- IP PPPOE Static / Remote Address masuk ke address-list IP -> Firewall -> Address List</small>
                                        <?php } ?>

                                    </div>
                                </div>
                                <?php if ($customer['mode_user'] == 'PPPOE' or $customer['mode_user'] == 'Hotspot') { ?>
                                    <?php if ($customer['action'] == '1') { ?>
                                        <div class="row py-2" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                            <div class="col-4 col-sm-4 font-weight-bold" style="color: var(--nm-text-muted);">User Profile Paket</div>
                                            <div class="col-8 col-sm-8 font-weight-bold" style="color: var(--nm-text-main);">:
                                                <?= $customer['user_profile']; ?>
                                                <span class="ml-1">
                                                    <?php if (isset($userprofile) && $userprofile > 0) { ?>
                                                        <div class="badge badge-success">matching</div>
                                                    <?php } else { ?>
                                                        <div class="badge badge-danger">mismatch</div>
                                                    <?php } ?>
                                                </span>
                                            </div>

                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                            <div class="d-flex flex-wrap align-items-center mt-3" style="gap: 8px;">
                                <a href="" class="btn btn-sm btn-primary nm-btn nm-btn-primary"><i class="fas fa-redo-alt mr-1"></i> Refresh</a>
                                <a href="<?= site_url('customer/edit/' . $customer['customer_id']) ?>" class="btn btn-sm btn-info nm-btn"><i class="fas fa-edit mr-1"></i> Edit</a>
                                <?php if ($customer['mode_user'] == "Hotspot") { ?>
                                    <?php if ($customer['action'] == 0) { ?>
                                        <?php if (isset($userhotspot['0']['disabled']) && $userhotspot['0']['disabled'] == 'true') { ?>
                                            <a class="btn btn-sm btn-success nm-btn" href="<?= site_url('router/openisolir/' . $customer['no_services']) ?>" title="Open Isolir" onclick="return confirm('Apakah anda yakin akan open isolir user <?= $customer['user_mikrotik'] ?> ?')"><i class="fas fa-lock-open mr-1"></i> Open Isolir</a>
                                        <?php } else { ?>
                                            <a class="btn btn-sm btn-danger nm-btn" href="<?= site_url('router/isolir/' . $customer['no_services']) ?>" title="Isolir Pelanggan" onclick="return confirm('Apakah anda yakin akan isolir user <?= $customer['user_mikrotik'] ?> ?')"><i class="fas fa-user-slash mr-1"></i> Isolir</a>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($customer['action'] == 1) { ?>
                                        <?php if (isset($userhotspot['0']['profile']) && $userhotspot['0']['profile'] == 'EXPIRED') { ?>
                                            <a class="btn btn-sm btn-success nm-btn" href="<?= site_url('router/openisolir/' . $customer['no_services']) ?>" title="Open Isolir" onclick="return confirm('Apakah anda yakin akan open isolir user <?= $customer['user_mikrotik'] ?> ?')"><i class="fas fa-lock-open mr-1"></i> Open Isolir</a>
                                        <?php } else { ?>
                                            <a class="btn btn-sm btn-danger nm-btn" href="<?= site_url('router/isolir/' . $customer['no_services']) ?>" title="Isolir Pelanggan" onclick="return confirm('Apakah anda yakin akan isolir user <?= $customer['user_mikrotik'] ?> ?')"><i class="fas fa-user-slash mr-1"></i> Isolir</a>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php if ($customer['mode_user'] == "PPPOE") { ?>
                                    <a class="btn btn-sm btn-warning nm-btn" href="<?= site_url('router/kick/' . $customer['no_services']) ?>" title="Kick User Aktif" onclick="return confirm('Apakah anda yakin akan kick user <?= $customer['user_mikrotik'] ?> dari sesi aktif ?')"><i class="fas fa-sign-out-alt mr-1"></i> Kick</a>
                                    <?php if ($customer['action'] == 0) { ?>
                                        <?php if (isset($userpppoe['0']['disabled']) && $userpppoe['0']['disabled'] == 'true') { ?>
                                            <a class="btn btn-sm btn-success nm-btn" href="<?= site_url('router/openisolir/' . $customer['no_services']) ?>" title="Open Isolir" onclick="return confirm('Apakah anda yakin akan open isolir user <?= $customer['user_mikrotik'] ?> ?')"><i class="fas fa-lock-open mr-1"></i> Open Isolir</a>
                                        <?php } else { ?>
                                            <a class="btn btn-sm btn-danger nm-btn" href="<?= site_url('router/isolir/' . $customer['no_services']) ?>" title="Isolir Pelanggan" onclick="return confirm('Apakah anda yakin akan isolir user <?= $customer['user_mikrotik'] ?> ?')"><i class="fas fa-user-slash mr-1"></i> Isolir</a>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($customer['action'] == 1) { ?>
                                        <?php if ((isset($userpppoe['0']['profile']) && $userpppoe['0']['profile'] == 'EXPIRED') or (isset($getaddresslist) && count($getaddresslist) > 0)) { ?>
                                            <a class="btn btn-sm btn-success nm-btn" href="<?= site_url('router/openisolir/' . $customer['no_services']) ?>" title="Open Isolir" onclick="return confirm('Apakah anda yakin akan open isolir user <?= $customer['user_mikrotik'] ?> ?')"><i class="fas fa-lock-open mr-1"></i> Open Isolir</a>
                                        <?php } else { ?>
                                            <a class="btn btn-sm btn-danger nm-btn" href="<?= site_url('router/isolir/' . $customer['no_services']) ?>" title="Isolir Pelanggan" onclick="return confirm('Apakah anda yakin akan isolir user <?= $customer['user_mikrotik'] ?> ?')"><i class="fas fa-user-slash mr-1"></i> Isolir</a>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php if ($customer['mode_user'] == "Static") { ?>
                                    <?php if ($customer['action'] == 0) { ?>
                                        <?php if (isset($getfirewall) && count($getfirewall) > 0) { ?>
                                            <a class="btn btn-sm btn-success nm-btn" href="<?= site_url('router/openisolir/' . $customer['no_services']) ?>" title="Open Isolir" onclick="return confirm('Apakah anda yakin akan open isolir user Static <?= $customer['user_mikrotik'] ?> ?')"><i class="fas fa-lock-open mr-1"></i> Open Isolir</a>
                                        <?php } else { ?>
                                            <a class="btn btn-sm btn-danger nm-btn" href="<?= site_url('router/isolir/' . $customer['no_services']) ?>" title="Isolir Pelanggan" onclick="return confirm('Apakah anda yakin akan isolir user Static <?= $customer['user_mikrotik'] ?> ?')"><i class="fas fa-user-slash mr-1"></i> Isolir</a>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($customer['action'] == 1) { ?>
                                        <?php if (isset($getaddresslist) && count($getaddresslist) > 0) { ?>
                                            <a class="btn btn-sm btn-success nm-btn" href="<?= site_url('router/openisolir/' . $customer['no_services']) ?>" title="Open Isolir" onclick="return confirm('Apakah anda yakin akan open isolir user Static <?= $customer['user_mikrotik'] ?> ?')"><i class="fas fa-lock-open mr-1"></i> Open Isolir</a>
                                        <?php } else { ?>
                                            <a class="btn btn-sm btn-danger nm-btn" href="<?= site_url('router/isolir/' . $customer['no_services']) ?>" title="Isolir Pelanggan" onclick="return confirm('Apakah anda yakin akan isolir user Static <?= $customer['user_mikrotik'] ?> ?')"><i class="fas fa-user-slash mr-1"></i> Isolir</a>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($customer['mode_user'] == 'PPPOE' or $customer['mode_user'] == 'Hotspot') { ?>
                    <?php if ($customer['action'] == '1') { ?>
                        <div class="nm-card-inner m-3 p-3">
                            <h6 class="font-weight-bold text-primary mb-2"><i class="fas fa-info-circle mr-1"></i> Catatan Profil:</h6>
                            <p class="mb-1"><span class="badge badge-success">matching</span> : User profile terdaftar di data profile PPPOE / Hotspot.</p>
                            <p class="mb-0"><span class="badge badge-danger">mismatch</span> : User profile tidak terdaftar di data profile PPPOE / Hotspot, segera edit profile agar fitur Auto Isolir (action: Ganti Profile) berjalan.</p>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>

        <?php 
        $livetrafic = 0;
        if ($customer['mode_user'] == 'Hotspot') {
            if ($customer['action'] == 0) {
                if (isset($userhotspot['0']['disabled']) && $userhotspot['0']['disabled'] == 'true') {
                    $livetrafic = 0;
                } elseif (isset($hotspotactive) && count($hotspotactive) > 0) {
                    $livetrafic = 1;
                } else {
                    $livetrafic = 0;
                }
            } elseif ($customer['action'] == 1) {
                if (isset($userhotspot['0']['profile']) && $userhotspot['0']['profile'] == 'EXPIRED') {
                    $livetrafic = 0;
                } elseif (isset($hotspotactive) && count($hotspotactive) > 0) {
                    $livetrafic = 1;
                } else {
                    $livetrafic = 0;
                }
            }
        } elseif ($customer['mode_user'] == 'PPPOE') {
            if ($customer['action'] == 0) {
                if (isset($userpppoe['0']['disabled']) && $userpppoe['0']['disabled'] == 'true') {
                    $livetrafic = 0;
                } elseif (isset($pppoeactive) && count($pppoeactive) > 0) {
                    $livetrafic = 1;
                } else {
                    $livetrafic = 0;
                }
            } elseif ($customer['action'] == 1) {
                if (isset($userpppoe['0']['profile']) && $userpppoe['0']['profile'] == 'EXPIRED') {
                    $livetrafic = 0;
                } elseif (isset($pppoeactive) && count($pppoeactive) > 0) {
                    $livetrafic = 1;
                } else {
                    $livetrafic = 0;
                }
            }
        } elseif ($customer['mode_user'] == 'Static') {
            if ($customer['action'] == 0) {
                if (isset($getfirewall) && count($getfirewall) > 0) {
                    $livetrafic = 0;
                } elseif (isset($getarp) && count($getarp) > 0) {
                    $livetrafic = 1;
                } else {
                    $livetrafic = 0;
                }
            } elseif ($customer['action'] > 0) {
                if (isset($getaddresslist) && count($getaddresslist) > 0) {
                    $livetrafic = 0;
                } elseif (isset($getarp) && count($getarp) > 0) {
                    $livetrafic = 1;
                } else {
                    $livetrafic = 0;
                }
            }
        } elseif ($customer['mode_user'] == 'Standalone') {
            if (isset($resource['0']['uptime']) && $resource['0']['uptime'] > 0) {
                $livetrafic = 1;
            } else {
                $livetrafic = 0;
            }
            ?>
        <?php } ?>

        <?php if ($livetrafic == 1) { ?>
            <div class="col-lg-6">
                <div class="card nm-card shadow mb-4">
                    <div class="card-header py-3 d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-chart-line mr-2 text-primary"></i>Live Traffic</h6>
                        <span class="badge badge-success"><i class="fas fa-circle mr-1" style="font-size: 0.55rem; vertical-align: middle;"></i>Monitoring</span>
                    </div>
                    <div class="card-body">
                        <div class="nm-card-inner p-2 mb-3">
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless mb-0" style="text-align: center;">
                                    <thead>
                                        <tr>
                                            <th class="py-1 text-muted text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">Total Realtime Bandwidth (TX + RX)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <input type="hidden" id="interface" value="<?= $customer['no_services'] ?>">
                                            <td class="py-2 font-weight-bold" style="font-size: 1.25rem; color: var(--nm-brand);">
                                                <div id="tabletxrx">0 bps</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="graph" style="min-height: 280px;"></div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <script type="text/javascript" src="<?= base_url('assets/backend/') ?>highchart/js/highcharts.js"></script>
    <?php if ($livetrafic == 1) { ?>
        <script>
            $('#select').on('change', function(e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                console.clear();
                $("#interface").val(valueSelected);
            });
            var chart;

            function requestDatta(interface) {
                var interface = $('#interface').val()
                var newStr = interface.replace(/%20/g, " ");
                $.ajax({
                    url: '<?= site_url('mikrotik/trafficclient/') ?>' + newStr,
                    datatype: "json",
                    success: function(data) {
                        var midata = JSON.parse(data);
                        // console.log(midata);
                        if (midata.length > 0) {
                            var TX = parseInt(midata[0].data);
                            var RX = parseInt(midata[1].data);
                            var TXRX = (TX + RX);
                            var x = (new Date()).getTime();
                            shift = chart.series[0].data.length > 19;
                            chart.series[0].addPoint([x, TX], true, shift);
                            chart.series[1].addPoint([x, RX], true, shift);
                            // document.getElementById("tabletx").innerHTML = convert(TX);
                            // document.getElementById("tablerx").innerHTML = convert(RX);
                            document.getElementById("tabletxrx").innerHTML = convert(TXRX);
                        } else {
                            // document.getElementById("tabletx").innerHTML = "0";
                            // document.getElementById("tablerx").innerHTML = "0";
                            document.getElementById("tabletxrx").innerHTML = "0";
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.error("Status: " + textStatus + " request: " + XMLHttpRequest);
                        console.error("Error: " + errorThrown);
                    }
                });
            }

            $(document).ready(function() {
                if (window.updateHighchartsTheme) {
                    window.updateHighchartsTheme($('body').hasClass('dark-mode'));
                }
                Highcharts.setOptions({
                    global: {
                        useUTC: false
                    }
                });
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'graph',
                        animation: Highcharts.svg,
                        type: 'spline',
                        events: {
                            load: function() {
                                setInterval(function() {
                                    requestDatta(document.getElementById("interface").value);
                                }, 1000);
                            }
                        }
                    },
                    title: {
                        text: 'Monitoring'
                    },
                    xAxis: {
                        type: 'datetime',
                        tickPixelInterval: 150,
                        maxZoom: 20 * 1000
                    },

                    yAxis: {
                        minPadding: 0.2,
                        maxPadding: 0.2,
                        title: {
                            text: 'Traffic'
                        },
                        labels: {
                            formatter: function() {
                                var bytes = this.value;
                                var sizes = ['bps', 'kbps', 'Mbps', 'Gbps', 'Tbps'];
                                if (bytes == 0) return '0 bps';
                                var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                                return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
                            },
                        },
                    },
                    series: [{
                        name: 'TX',
                        data: []
                    }, {
                        name: 'RX',
                        data: []
                    }],
                    tooltip: {
                        headerFormat: '<b>{series.name}</b><br/>',
                        pointFormat: '{point.x:%Y-%m-%d %H:%M:%S}<br/>{point.y}'
                    },


                });
            });

            function convert(bytes) {

                var sizes = ['bps', 'kbps', 'Mbps', 'Gbps', 'Tbps'];
                if (bytes == 0) return '0 bps';
                var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
            }
        </script>
    <?php } ?>
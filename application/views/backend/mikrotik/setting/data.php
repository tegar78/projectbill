<style>
    .switch {
        display: inline-block;
        height: 34px;
        position: relative;
        width: 60px;

    }

    .switch input {
        display: none;
    }

    .slider {
        background-color: gray;
        bottom: 0;
        cursor: pointer;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        transition: .4s;
    }

    .slider:before {
        background-color: #fff;
        bottom: 4px;
        content: "";
        height: 26px;
        left: 4px;
        position: absolute;
        transition: .4s;
        width: 26px;
    }

    input:checked+.slider {
        background-color: blue;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<?php $this->view('messages') ?>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Pengaturan <?= $title; ?></h6>
            </div>
            <form action="<?= site_url('mikrotik/editsetting') ?>" method="POST">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body">

                            <?php
                            $ip = isset($router['ip_address']) ? $router['ip_address'] : '';
                            $user = isset($router['username']) ? $router['username'] : '';
                            $pass = isset($router['password']) ? $router['password'] : '';
                            $port = isset($router['port']) ? $router['port'] : '';
                            $API = new Mikweb();
                            $connected = false;
                            try {
                                $connected = @$API->connect($ip, $user, $pass, $port);
                            } catch (Exception $e) {
                                $connected = false;
                            }

                            $getisolir = ($connected && is_array($API->comm("/system/schedule/print", array('?name' => 'ISOLIR-MY-WIFI')))) ? $API->comm("/system/schedule/print", array('?name' => 'ISOLIR-MY-WIFI')) : [];
                            $timeisolir = (isset($getisolir[0]['start-time'])) ? explode(":", $getisolir[0]['start-time']) : ['00', '00', '00'];
                            $isolirstatus = isset($getisolir[0]['disabled']) ? $getisolir[0]['disabled'] : 'true';

                            $getresetpppoe = ($connected && is_array($API->comm("/system/schedule/print", array('?name' => 'RESET-PPPOE')))) ? $API->comm("/system/schedule/print", array('?name' => 'RESET-PPPOE')) : [];
                            $timeresetpppoe = (isset($getresetpppoe[0]['start-time'])) ? explode(":", $getresetpppoe[0]['start-time']) : ['00', '00', '00'];
                            $resetpppoe = isset($getresetpppoe[0]['disabled']) ? $getresetpppoe[0]['disabled'] : 'true';

                            $getresethotspot = ($connected && is_array($API->comm("/system/schedule/print", array('?name' => 'RESET-HOTSPOT')))) ? $API->comm("/system/schedule/print", array('?name' => 'RESET-HOTSPOT')) : [];
                            $resethotspot = isset($getresethotspot[0]['disabled']) ? $getresethotspot[0]['disabled'] : 'true';
                            $timeresethotspot = (isset($getresethotspot[0]['start-time'])) ? explode(":", $getresethotspot[0]['start-time']) : ['00', '00', '00'];

                            $getresetstatic = ($connected && is_array($API->comm("/system/schedule/print", array('?name' => 'RESET-STATIC')))) ? $API->comm("/system/schedule/print", array('?name' => 'RESET-STATIC')) : [];
                            $resetstatic = isset($getresetstatic[0]['disabled']) ? $getresetstatic[0]['disabled'] : 'true';
                            $timeresetstatic = (isset($getresetstatic[0]['start-time'])) ? explode(":", $getresetstatic[0]['start-time']) : ['00', '00', '00'];

                            $getcountpppoe = ($connected && is_array($API->comm("/system/schedule/print", array('?name' => 'COUNT-PPPOE')))) ? $API->comm("/system/schedule/print", array('?name' => 'COUNT-PPPOE')) : [];
                            $countpppoe = isset($getcountpppoe[0]['disabled']) ? $getcountpppoe[0]['disabled'] : 'true';
                            $timecountpppoe = (isset($getcountpppoe[0]['start-time'])) ? explode(":", $getcountpppoe[0]['start-time']) : ['00', '00', '00'];

                            $getcountstandalone = ($connected && is_array($API->comm("/system/schedule/print", array('?name' => 'COUNT-STANDALONE')))) ? $API->comm("/system/schedule/print", array('?name' => 'COUNT-STANDALONE')) : [];
                            $countstandalone = isset($getcountstandalone[0]['disabled']) ? $getcountstandalone[0]['disabled'] : 'true';

                            $getcekconnection = ($connected && is_array($API->comm("/system/schedule/print", array('?name' => 'CEK-CONNECTION')))) ? $API->comm("/system/schedule/print", array('?name' => 'CEK-CONNECTION')) : [];
                            $cekconnection = isset($getcekconnection[0]['disabled']) ? $getcekconnection[0]['disabled'] : 'true';
                            $timecountstandalone = (isset($getcountstandalone[0]['start-time'])) ? explode(":", $getcountstandalone[0]['start-time']) : ['00', '00', '00'];

                            $getcreatebill = ($connected && is_array($API->comm("/system/schedule/print", array('?name' => 'GENERATE-BILL')))) ? $API->comm("/system/schedule/print", array('?name' => 'GENERATE-BILL')) : [];
                            $createbill = isset($getcreatebill[0]['disabled']) ? $getcreatebill[0]['disabled'] : 'true';
                            $timecreatebill = (isset($getcreatebill[0]['start-time'])) ? explode(":", $getcreatebill[0]['start-time']) : ['00', '00', '00'];

                            $getreminderduedate = ($connected && is_array($API->comm("/system/schedule/print", array('?name' => 'REMINDER-BILL')))) ? $API->comm("/system/schedule/print", array('?name' => 'REMINDER-BILL')) : [];
                            $reminderduedate = isset($getreminderduedate[0]['disabled']) ? $getreminderduedate[0]['disabled'] : 'true';
                            $timereminderduedate = (isset($getreminderduedate[0]['start-time'])) ? explode(":", $getreminderduedate[0]['start-time']) : ['00', '00', '00'];

                            $getreminderduedatetelegram = ($connected && is_array($API->comm("/system/schedule/print", array('?name' => 'REMINDER-BILL-TELEGRAM')))) ? $API->comm("/system/schedule/print", array('?name' => 'REMINDER-BILL-TELEGRAM')) : [];
                            $reminderduedatetelegram = isset($getreminderduedatetelegram[0]['disabled']) ? $getreminderduedatetelegram[0]['disabled'] : 'true';
                            $timereminderduedatetelegram = (isset($getreminderduedatetelegram[0]['start-time'])) ? explode(":", $getreminderduedatetelegram[0]['start-time']) : ['00', '00', '00'];

                            $getbackupdb = ($connected && is_array($API->comm("/system/schedule/print", array('?name' => 'BACKUP-DB')))) ? $API->comm("/system/schedule/print", array('?name' => 'BACKUP-DB')) : [];
                            $backupdb = isset($getbackupdb[0]['disabled']) ? $getbackupdb[0]['disabled'] : 'true';
                            $timebackupdb = (isset($getbackupdb[0]['start-time'])) ? explode(":", $getbackupdb[0]['start-time']) : ['00', '00', '00'];
                            ?>
                            <div class="row">
                                <div class="col">Auto Isolir / Disable </div>
                                <div class="col"> <label for="chisolir" class="switch ml-3">
                                        <input type="checkbox" <?= $isolirstatus == 'false' ? 'checked' : ''; ?> id="chisolir" />
                                        <div class="slider round"></div>
                                    </label></div>
                                <input type="hidden" name="isolir" id="isolir" value="<?= $isolirstatus ?>">
                                <div class="col-md-0 mt-2">
                                    <label class="col-sm-12 col-form-label">Interval </label>
                                </div>
                                <div class="col-sm-2 mt-2">
                                    <?php $interval = isset($getisolir[0]['interval']) ? $getisolir[0]['interval'] : '10m'; ?>
                                    <input type="number" name="intervalisolir" min="10" max="59" class="form-control" autocomplete="off" value="<?= preg_replace("/[^0-9\.]/", "", $interval); ?>">
                                </div>
                                <div class="col-sm-3 mt-2">
                                    <label class="col-sm-12 col-form-label">Setiap Menit</label>
                                </div>

                            </div>
                            Url : <a href="<?= base_url('front/isolir/' . (isset($other['key_apps']) ? $other['key_apps'] : '')); ?>" target="blank"><?= base_url('front/isolir/' . (isset($other['key_apps']) ? $other['key_apps'] : '')); ?></a>
                            <hr>





                            <div class="row">
                                <div class="col">Hitung Pemakaian Internet </div>
                                <div class="col"> <label for="chcountpppoe" class="switch ml-3">
                                        <input type="checkbox" <?= $countpppoe == 'false' ? 'checked' : ''; ?> id="chcountpppoe" />
                                        <div class="slider round"></div>
                                    </label></div>
                                <!-- <span style="color:red">Terhitung setiap pergantian hari</span> -->
                                <input type="hidden" name="countpppoe" id="countpppoe" value="<?= $countpppoe ?>">
                                <div class="col-md-0 mt-2">
                                    <label class="col-sm-12 col-form-label">Interval </label>
                                </div>
                                <div class="col-sm-2 mt-2">
                                    <?php $interval = isset($getcountpppoe[0]['interval']) ? $getcountpppoe[0]['interval'] : '15m'; ?>
                                    <input type="number" name="intervalcountpppoe" min="15" max="59" class="form-control" autocomplete="off" value="<?= preg_replace("/[^0-9\.]/", "", $interval); ?>">
                                </div>
                                <div class="col-sm-3 mt-2">
                                    <label class="col-sm-12 col-form-label">Setiap Menit</label>
                                </div>
                            </div>
                            Url : <a href="<?= base_url('front/countpppoe/' . (isset($other['key_apps']) ? $other['key_apps'] : '')); ?>" target="blank"><?= base_url('front/countpppoe/' . (isset($other['key_apps']) ? $other['key_apps'] : '')); ?></a>

                            <hr>








                        </div>


                    </div>
                </div>

        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Pengaturan <?= $title; ?></h6>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">

                        <div class="row">
                            <div class="col">Auto Generate Tagihan</div>
                            <div class="col"> <label for="chcreatebill" class="switch ml-3">
                                    <input type="checkbox" <?= $createbill == 'false' ? 'checked' : ''; ?> id="chcreatebill" />
                                    <div class="slider round"></div>
                                </label></div>
                            <input type="hidden" name="createbill" id="createbill" value="<?= $createbill ?>">
                            <div class="col-md-0 mt-2">
                                <label class="col-sm-12 col-form-label">Setiap Tanggal </label>
                            </div>
                            <div class="col-sm-2 mt-2">
                                <input type="number" name="date_create" min="1" max="28" class="form-control" autocomplete="off" value="<?= isset($other['date_create']) ? $other['date_create'] : '1' ?>">
                            </div>
                            <div class="col-sm-3 mt-2">
                                <label class="col-sm-12 col-form-label">Setiap Bulan</label>
                            </div>

                        </div>
                        Url : <a href="<?= base_url('front/createbill/' . (isset($other['key_apps']) ? $other['key_apps'] : '')); ?>" target="blank"><?= base_url('front/createbill/' . (isset($other['key_apps']) ? $other['key_apps'] : '')); ?></a>
                        <hr>
                        <div class="row">
                            <div class="col">Auto Backup Database</div>
                            <div class="col"> <label for="chbackupdb" class="switch ml-3">
                                    <input type="checkbox" <?= $backupdb == 'false' ? 'checked' : ''; ?> id="chbackupdb" />
                                    <div class="slider round"></div>
                                </label></div>
                            <input type="hidden" name="backupdb" id="backupdb" value="<?= $backupdb ?>">
                            <div class="col-sm-3">Jam
                                <input type="number" name="jambackupdb" min="0" max="23" class="form-control" autocomplete="off" value="<?= isset($timebackupdb[0]) ? $timebackupdb[0] : '00' ?>" required>

                            </div>
                            <div class="col-sm-3">Menit
                                <input type="number" name="menitbackupdb" min="0" max="59" class="form-control" autocomplete="off" value="<?= isset($timebackupdb[1]) ? $timebackupdb[1] : '00' ?>" required>

                            </div>
                        </div>
                        Url : <a href="<?= base_url('front/backup/' . (isset($other['key_apps']) ? $other['key_apps'] : '')); ?>" target="blank"><?= base_url('front/backup/' . (isset($other['key_apps']) ? $other['key_apps'] : '')); ?></a>

                        <hr>
                        <div class="row container mb-3">Auto Reminder Ketika Pelanggan Jatuh Tempo</div>
                        <div class="row">
                            <div class="col">Kirim Whatsapp Ke Pelanggan</div>
                            <div class="col"> <label for="chreminderduedate" class="switch ml-3">
                                    <input type="checkbox" <?= $reminderduedate == 'false' ? 'checked' : ''; ?> id="chreminderduedate" />
                                    <div class="slider round"></div>
                                </label></div>
                            <input type="hidden" name="reminderduedate" id="reminderduedate" value="<?= $reminderduedate ?>">

                        </div>
                        Url Sebelum Jatuh Tempo : <a href="<?= base_url('front/reminder/' . (isset($other['key_apps']) ? $other['key_apps'] : '')); ?>" target="blank"><?= base_url('front/reminder/' . (isset($other['key_apps']) ? $other['key_apps'] : '')); ?></a>
                        <br>
                        Url Jatuh Tempo : <a href="<?= base_url('front/reminderduedate/' . (isset($other['key_apps']) ? $other['key_apps'] : '')); ?>" target="blank"><?= base_url('front/reminderduedate/' . (isset($other['key_apps']) ? $other['key_apps'] : '')); ?></a>

                        <hr>
                        <div class="row">
                            <div class="col">Kirim Ke Telegram</div>
                            <div class="col"> <label for="chreminderduedatetelegram" class="switch ml-3">
                                    <input type="checkbox" <?= $reminderduedatetelegram == 'false' ? 'checked' : ''; ?> id="chreminderduedatetelegram" />
                                    <div class="slider round"></div>
                                </label></div>
                            <input type="hidden" name="reminderduedatetelegram" id="reminderduedatetelegram" value="<?= $reminderduedatetelegram ?>">
                            <div class="col-sm-3">Jam
                                <input type="number" name="jamreminderduedatetelegram" min="0" max="23" class="form-control" autocomplete="off" value="<?= isset($timereminderduedatetelegram[0]) ? $timereminderduedatetelegram[0] : '00' ?>" required>
                            </div>
                            <div class="col-sm-3">Menit
                                <input type="number" name="menitreminderduedatetelegram" min="0" max="59" class="form-control" autocomplete="off" value="<?= isset($timereminderduedatetelegram[1]) ? $timereminderduedatetelegram[1] : '00' ?>" required>
                            </div>
                        </div>
                        Url : <a href="<?= base_url('front/reminderduedatetelegram/' . (isset($other['key_apps']) ? $other['key_apps'] : '')); ?>" target="blank"><?= base_url('front/reminderduedatetelegram/' . (isset($other['key_apps']) ? $other['key_apps'] : '')); ?></a>

                        <hr>
                        <div class="form-group">
                            <label for="key_apps">Key Apps</label>
                            <div class="input-group mb-3">
                                <input type="text" id="key_apps" name="key_apps" class="form-control" value="<?= isset($other['key_apps']) ? $other['key_apps'] : '' ?>" required>
                                <div class="input-group-append">
                                    <a href="#" class="input-group-text" id="generatekeyapps" style="text-decoration: none;">Generate</a>
                                </div>
                            </div>
                        </div>

                        <span style="color: red;">Catatan</span> <br>
                        <li>Untuk fitur Schedule dan hitung pemakaian PPPOE / Standalone diperlukan User yang mempunyai akses Write</li>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>

</div>
<script>
    $(function() {
        $("#chisolir").click(function() {
            if ($(this).is(":checked")) {
                $("#isolir").val('false');
            } else {
                $("#isolir").val('true');
            }
        });
        $("#chresetpppoe").click(function() {
            if ($(this).is(":checked")) {
                $("#resetpppoe").val('false');
            } else {
                $("#resetpppoe").val('true');
            }
        });
        $("#chresethotspot").click(function() {
            if ($(this).is(":checked")) {
                $("#resethotspot").val('false');
            } else {
                $("#resethotspot").val('true');
            }
        });
        $("#chresetstatic").click(function() {
            if ($(this).is(":checked")) {
                $("#resetstatic").val('false');
            } else {
                $("#resetstatic").val('true');
            }
        });
        $("#chcountpppoe").click(function() {
            if ($(this).is(":checked")) {
                $("#countpppoe").val('false');
            } else {
                $("#countpppoe").val('true');
            }
        });
        $("#chcountstandalone").click(function() {
            if ($(this).is(":checked")) {
                $("#countstandalone").val('false');
            } else {
                $("#countstandalone").val('true');
            }
        });
        $("#chcekconnection").click(function() {
            if ($(this).is(":checked")) {
                $("#cekconnection").val('false');
            } else {
                $("#cekconnection").val('true');
            }
        });
        $("#chcreatebill").click(function() {
            if ($(this).is(":checked")) {
                $("#createbill").val('false');
            } else {
                $("#createbill").val('true');
            }
        });
        $("#chreminderduedate").click(function() {
            if ($(this).is(":checked")) {
                $("#reminderduedate").val('false');
            } else {
                $("#reminderduedate").val('true');
            }
        });
        $("#chreminderduedatetelegram").click(function() {
            if ($(this).is(":checked")) {
                $("#reminderduedatetelegram").val('false');
            } else {
                $("#reminderduedatetelegram").val('true');
            }
        });
        $("#chbackupdb").click(function() {
            if ($(this).is(":checked")) {
                $("#backupdb").val('false');
            } else {
                $("#backupdb").val('true');
            }
        });
    });
    $(function() {
        $("#generatekeyapps").click(function() {
            var keyapps = makeid(16)
            $("#key_apps").val(keyapps);
        });
    });

    function makeid(length) {
        var result = [];
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result.push(characters.charAt(Math.floor(Math.random() *
                charactersLength)));
        }
        return result.join('');
    }

    console.log(makeid(16));
</script>
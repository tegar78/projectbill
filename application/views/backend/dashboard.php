<?php $this->view('messages') ?>
<?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
<?php $menu = $this->db->get_where('role_menu', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
<!-- Content Row -->

<?php if ($this->session->userdata('role_id') == 1 or $menu['customer_menu'] == 1) { ?>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="nm-card nm-card-sm nm-form">
                <div class="d-flex align-items-center mb-2">
                    <span class="nm-label" style="color: var(--nm-brand);"><i class="fas fa-search mr-1"></i> Pencarian Cepat Layanan</span>
                </div>
                <?php if ($this->session->userdata('role_id') == 1 or $menu['bill_menu'] == 1) { ?>
                    <?php if (count($customer) > 0) { ?>
                        <div class="form-group mb-0">
                            <select class="form-control select2 nm-input" style="width: 100% !important;" name="no_services" id="no_services" onchange="getdetailcustomer()" required>
                                <option value="">Pilih No Layanan - Nama Pelanggan - Status </option>
                                <?php
                                foreach ($customer as $r => $data) { ?>
                                    <option value="<?= $data->no_services ?>"><?= $data->no_services ?> - <?= $data->name ?> - <?= $data->c_status; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<div class="loading"></div>

<div class="getdatacustomer"></div>

<div class="" id="contents">
    <div class="row">
        <!-- Card 1: Data Pelanggan -->
        <?php if ($role['role_id'] == 1 or $menu['customer_menu'] == 1) { ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="nm-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="nm-label" style="color: var(--nm-brand);">Data Pelanggan</span>
                        <div class="d-flex align-items-center" style="gap: 8px;">
                            <button type="button" class="nm-btn nm-btn-circle-sm" style="width: 28px; height: 28px; border-radius: 50%; padding: 0;" title="Sembunyikan/Tampilkan">
                                <i id="showcustomer" class="fa fa-eye-slash" style="font-size: 0.75rem;"></i>
                                <i id="hidecustomer" class="fa fa-eye" style="display: none; font-size: 0.75rem;"></i>
                            </button>
                            <div class="nm-icon-well nm-icon-well-inset" style="width: 36px; height: 36px; font-size: 0.95rem; color: var(--nm-brand);">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <div class="container p-0" id="loading1"></div>
                    <div id="cardcustomer">
                        <a href="<?= site_url('customer/active') ?>" style="text-decoration: none;">
                            <div class="h4 mb-2 font-weight-bold" style="color: var(--nm-text-main);">
                                Aktif : <span id="customeractive" style="color: var(--nm-accent-success);">xxx</span>
                            </div>
                        </a>
                        <div class="d-flex flex-column" style="font-size: 0.85rem;">
                            <a href="<?= site_url('customer/nonactive') ?>" style="text-decoration: none;" class="d-flex justify-content-between py-1">
                                <span class="stat-subtext">Non-Aktif</span>
                                <span id="customernonactive" class="font-weight-bold" style="color: var(--nm-text-main);">xxx</span>
                            </a>
                            <a href="<?= site_url('customer/wait') ?>" style="text-decoration: none;" class="d-flex justify-content-between py-1">
                                <span class="stat-subtext">Menunggu</span>
                                <span id="customerwaiting" class="font-weight-bold" style="color: var(--nm-accent-warning);">xxx</span>
                            </a>
                            <a href="<?= site_url('customer/free') ?>" style="text-decoration: none;" class="d-flex justify-content-between py-1">
                                <span class="stat-subtext">Free</span>
                                <span id="customerfree" class="font-weight-bold" style="color: var(--nm-text-main);">xxx</span>
                            </a>
                            <a href="<?= site_url('bill/duedate') ?>" style="text-decoration: none;" class="d-flex justify-content-between py-1">
                                <span class="stat-subtext">Jatuh Tempo</span>
                                <span id="customerduedate" class="font-weight-bold" style="color: var(--nm-accent-warning);">xxx</span>
                            </a>
                            <a href="<?= site_url('customer/isolir') ?>" style="text-decoration: none;" class="d-flex justify-content-between align-items-center pt-2 mt-1" style="border-top: 1px solid var(--nm-shadow-dark);">
                                <span class="stat-subtext-danger font-weight-bold">ISOLIR</span>
                                <span class="badge badge-danger px-2 py-1" style="box-shadow: var(--nm-inset-sm); border-radius: var(--nm-radius-pill); font-weight: 700;">
                                    <span id="customerisolir">xxx</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Card 2: Pemasukan Bulan Ini -->
        <?php if ($this->session->userdata('role_id') == 1 or $role['show_saldo'] == 1) { ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="nm-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="nm-label" style="color: var(--nm-accent-success);">Pemasukan Bulan Ini</span>
                        <div class="d-flex align-items-center" style="gap: 8px;">
                            <button type="button" class="nm-btn nm-btn-circle-sm" style="width: 28px; height: 28px; border-radius: 50%; padding: 0;" title="Sembunyikan/Tampilkan">
                                <i id="showincome" class="fa fa-eye-slash" style="font-size: 0.75rem;"></i>
                                <i id="hideincome" class="fa fa-eye" style="display: none; font-size: 0.75rem;"></i>
                            </button>
                            <div class="nm-icon-well nm-icon-well-inset" style="width: 36px; height: 36px; font-size: 0.95rem; color: var(--nm-accent-success);">
                                <i class="fas fa-wallet"></i>
                            </div>
                        </div>
                    </div>
                    <div class="container p-0" id="loading2"></div>
                    <div id="cardincome">
                        <a href="<?= site_url('income') ?>" style="text-decoration: none;">
                            <div class="h4 mb-2 font-weight-bold" style="color: var(--nm-accent-success);">
                                <span id="incomethismonth">xxx</span>
                            </div>
                            <div class="d-flex flex-column" style="font-size: 0.85rem;">
                                <div class="d-flex justify-content-between py-1">
                                    <span class="stat-subtext">Bulan Kemarin</span>
                                    <span id="incomelastmonth" class="font-weight-bold" style="color: var(--nm-text-main);">xxx</span>
                                </div>
                                <div class="d-flex justify-content-between py-1">
                                    <span class="stat-subtext">Hari Ini</span>
                                    <span id="incometoday" class="font-weight-bold" style="color: var(--nm-accent-success);">xxx</span>
                                </div>
                                <div class="d-flex justify-content-between py-1">
                                    <span class="stat-subtext">Kemarin</span>
                                    <span id="incomeyesterday" class="font-weight-bold" style="color: var(--nm-text-main);">xxx</span>
                                </div>
                                <div class="pt-2 mt-1" style="border-top: 1px solid var(--nm-shadow-dark);">
                                    <span class="stat-subtext d-block" style="font-size: 0.75rem;">Selisih Masuk & Keluar:</span>
                                    <span id="difference" class="font-weight-bold" style="color: var(--nm-brand);">xxx</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Card 3: Pengeluaran Bulan Ini -->
        <?php if ($this->session->userdata('role_id') == 1 or $role['show_saldo'] == 1) { ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="nm-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="nm-label" style="color: var(--nm-accent-blue);">Pengeluaran Bulan Ini</span>
                        <div class="d-flex align-items-center" style="gap: 8px;">
                            <button type="button" class="nm-btn nm-btn-circle-sm" style="width: 28px; height: 28px; border-radius: 50%; padding: 0;" title="Sembunyikan/Tampilkan">
                                <i id="showexpenditure" class="fa fa-eye-slash" style="font-size: 0.75rem;"></i>
                                <i id="hideexpenditure" class="fa fa-eye" style="display: none; font-size: 0.75rem;"></i>
                            </button>
                            <div class="nm-icon-well nm-icon-well-inset" style="width: 36px; height: 36px; font-size: 0.95rem; color: var(--nm-accent-blue);">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                        </div>
                    </div>
                    <div class="container p-0" id="loading3"></div>
                    <div>
                        <a href="<?= site_url('expenditure') ?>" style="text-decoration: none;">
                            <div class="h4 mb-2 font-weight-bold" style="color: var(--nm-accent-blue);">
                                <span id="expenditurethismonth">xxx</span>
                            </div>
                            <div class="d-flex flex-column" style="font-size: 0.85rem;">
                                <div class="d-flex justify-content-between py-1">
                                    <span class="stat-subtext">Bulan Kemarin</span>
                                    <span id="expenditurelastmonth" class="font-weight-bold" style="color: var(--nm-text-main);">xxx</span>
                                </div>
                                <div class="d-flex justify-content-between py-1">
                                    <span class="stat-subtext">Hari Ini</span>
                                    <span id="expendituretoday" class="font-weight-bold" style="color: var(--nm-text-main);">xxx</span>
                                </div>
                                <div class="d-flex justify-content-between py-1">
                                    <span class="stat-subtext">Kemarin</span>
                                    <span id="expenditureyesterday" class="font-weight-bold" style="color: var(--nm-text-main);">xxx</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Card 4: Menunggu Pembayaran -->
        <?php if ($this->session->userdata('role_id') == 1 or $menu['bill_menu'] == 1) { ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="nm-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="nm-label" style="color: var(--nm-accent-warning);">Menunggu Pembayaran</span>
                        <div class="d-flex align-items-center" style="gap: 8px;">
                            <button type="button" class="nm-btn nm-btn-circle-sm" style="width: 28px; height: 28px; border-radius: 50%; padding: 0;" title="Sembunyikan/Tampilkan">
                                <i id="showbill" class="fa fa-eye-slash" style="font-size: 0.75rem;"></i>
                                <i id="hidebill" class="fa fa-eye" style="display: none; font-size: 0.75rem;"></i>
                            </button>
                            <div class="nm-icon-well nm-icon-well-inset" style="width: 36px; height: 36px; font-size: 0.95rem; color: var(--nm-accent-warning);">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                        </div>
                    </div>
                    <div class="container p-0" id="loading4"></div>
                    <div>
                        <a href="<?= site_url('bill/unpaid') ?>" style="text-decoration: none;">
                            <div class="h4 mb-2 font-weight-bold" style="color: var(--nm-text-main);">
                                <span id="pendingpayment" style="color: var(--nm-accent-warning);">xxx</span> <span style="font-size: 0.95rem; color: var(--nm-text-muted);">Tagihan</span>
                            </div>
                            <?php if ($this->session->userdata('role_id') == 1 or $role['show_saldo'] == 1) { ?>
                                <div class="mt-3 p-2 d-flex align-items-center justify-content-between" style="background: var(--nm-bg); box-shadow: var(--nm-inset-sm); border-radius: var(--nm-radius-md);">
                                    <span class="stat-subtext font-weight-bold">Nominal:</span>
                                    <span class="stat-subtext-danger font-weight-bold" id="amountpendingpayment">xxx</span>
                                </div>
                            <?php } ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="row">
        <!-- Coverage Area -->
        <?php if ($this->session->userdata('role_id') == 1 or $menu['coverage_menu'] == 1) { ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="<?= site_url('coverage') ?>" style="text-decoration: none;">
                    <div class="nm-card h-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="nm-label" style="color: var(--nm-accent-blue);">Coverage Area</span>
                            <div class="nm-icon-well nm-icon-well-inset" style="width: 36px; height: 36px; font-size: 0.95rem; color: var(--nm-accent-blue);">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                        </div>
                        <div class="h3 font-weight-bold mb-0" style="color: var(--nm-text-main);"><?= $coverage; ?></div>
                        <small class="stat-subtext">Wilayah Jangkauan</small>
                    </div>
                </a>
            </div>
        <?php } ?>

        <!-- Tiket Pending -->
        <?php if ($this->session->userdata('role_id') == 1 or $menu['help_menu'] == 1) { ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="<?= site_url('help/pending') ?>" style="text-decoration: none;">
                    <div class="nm-card h-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="nm-label" style="color: var(--nm-accent-danger);">Tiket Pending</span>
                            <div class="nm-icon-well nm-icon-well-inset" style="width: 36px; height: 36px; font-size: 0.95rem; color: var(--nm-accent-danger);">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        </div>
                        <div class="h3 font-weight-bold mb-0" style="color: var(--nm-accent-danger);"><?= $this->help_m->getpending()->num_rows(); ?></div>
                        <small class="stat-subtext">Gangguan Belum Ditangani</small>
                    </div>
                </a>
            </div>

            <!-- Tiket Process -->
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="<?= site_url('help/proses') ?>" style="text-decoration: none;">
                    <div class="nm-card h-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="nm-label" style="color: var(--nm-accent-warning);">Tiket Proses</span>
                            <div class="nm-icon-well nm-icon-well-inset" style="width: 36px; height: 36px; font-size: 0.95rem; color: var(--nm-accent-warning);">
                                <i class="fas fa-tools"></i>
                            </div>
                        </div>
                        <div class="h3 font-weight-bold mb-0" style="color: var(--nm-accent-warning);"><?= $this->help_m->getprocess()->num_rows(); ?></div>
                        <small class="stat-subtext">Sedang Dikerjakan Teknisi</small>
                    </div>
                </a>
            </div>

            <!-- Tiket Done -->
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="<?= site_url('help/done') ?>" style="text-decoration: none;">
                    <div class="nm-card h-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="nm-label" style="color: var(--nm-accent-success);">Tiket Selesai</span>
                            <div class="nm-icon-well nm-icon-well-inset" style="width: 36px; height: 36px; font-size: 0.95rem; color: var(--nm-accent-success);">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="h3 font-weight-bold mb-0" style="color: var(--nm-accent-success);"><?= $this->help_m->getdone()->num_rows(); ?></div>
                        <small class="stat-subtext">Tiket Berhasil Selesai</small>
                    </div>
                </a>
            </div>
        <?php } ?>
    </div>

    <div class="row">
        <!-- Area Chart -->
        <?php if ($this->session->userdata('role_id') == 1 or $role['show_saldo'] == 1) { ?>
            <div class="col-xl-6 col-lg-6 mb-4">
                <div class="nm-card h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="nm-label font-weight-bold" style="color: var(--nm-brand);">Pemasukan Tahun Ini</span>
                    </div>
                    <div class="chart-area">
                        <canvas id="myAreaChart" style="display: block; height: 320px; width: 100%;" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Activity Log -->
        <?php if ($this->session->userdata('role_id') == 1 or $menu['setting_logs'] == 1) { ?>
            <div class="col-xl-6 col-lg-6 mb-4 d-none d-sm-block d-md-block">
                <div class="nm-card h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="nm-label font-weight-bold" style="color: var(--nm-brand);">Aktivitas Terakhir</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr style="text-align: center">
                                    <th style="text-align: center; width:20px">No</th>
                                    <th>Name</th>
                                    <th>Level</th>
                                    <th>Time</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($logs as $log) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $log->name; ?></td>
                                        <td>
                                            <?= $log->role_id == 0 ? 'System' : '' ?>
                                            <?= $log->role_id == 1 ? 'Admin' : '' ?>
                                            <?= $log->role_id == 2 ? 'Pelanggan' : '' ?>
                                            <?= $log->role_id == 3 ? 'Operator' : '' ?>
                                            <?= $log->role_id == 5 ? 'Teknisi' : '' ?>
                                        </td>
                                        <td><?= date('d-M-Y', $log->datetime) ?> - <?= date('H:i:s', $log->datetime) ?></td>
                                        <td><?= $log->remark ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <a href="<?= site_url('logs') ?>" class="nm-btn nm-btn-primary">Lihat Semua Aktivitas</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

</div>



<?php $Jan = 0;
foreach ($incomeJan as $c => $data) {
    $Jan += $data->nominal;
} ?>
<?php $Feb = 0;
foreach ($incomeFeb as $c => $data) {
    $Feb += $data->nominal;
} ?>
<?php $Mar = 0;
foreach ($incomeMar as $c => $data) {
    $Mar += $data->nominal;
} ?>
<?php $Apr = 0;
foreach ($incomeApr as $c => $data) {
    $Apr += $data->nominal;
} ?>
<?php $May = 0;
foreach ($incomeMay as $c => $data) {
    $May += $data->nominal;
} ?>
<?php $Jun = 0;
foreach ($incomeJun as $c => $data) {
    $Jun += $data->nominal;
} ?>
<?php $Jul = 0;
foreach ($incomeJul as $c => $data) {
    $Jul += $data->nominal;
} ?>
<?php $Aug = 0;
foreach ($incomeAug as $c => $data) {
    $Aug += $data->nominal;
} ?>
<?php $Sep = 0;
foreach ($incomeSep as $c => $data) {
    $Sep += $data->nominal;
} ?>
<?php $Oct = 0;
foreach ($incomeOct as $c => $data) {
    $Oct += $data->nominal;
} ?>
<?php $Nov = 0;
foreach ($incomeNov as $c => $data) {
    $Nov += $data->nominal;
} ?>
<?php $Dec = 0;
foreach ($incomeDec as $c => $data) {
    $Dec += $data->nominal;
} ?>
<script src="<?= base_url('assets/backend/') ?>js/Chart.min.js"></script>
<script>
    var isDarkChart = $('body').hasClass('dark-mode');
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = isDarkChart ? '#cbd5e1' : '#858796';

    function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    // Area Chart Example
    var ctx = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Income",
                lineTension: 0.3,
                backgroundColor: isDarkChart ? "rgba(96, 165, 250, 0.15)" : "rgba(78, 115, 223, 0.05)",
                borderColor: isDarkChart ? "#60a5fa" : "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: isDarkChart ? "#60a5fa" : "rgba(78, 115, 223, 1)",
                pointBorderColor: isDarkChart ? "#60a5fa" : "rgba(78, 115, 223, 1)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "#f47b20",
                pointHoverBorderColor: "#f47b20",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [<?php echo "$Jan"; ?>, <?php echo "$Feb"; ?>, <?php echo "$Mar"; ?>, <?php echo "$Apr"; ?>, <?php echo "$May"; ?>, <?php echo "$Jun"; ?>, <?php echo "$Jul"; ?>, <?php echo "$Aug"; ?>, <?php echo "$Sep"; ?>, <?php echo "$Oct"; ?>, <?php echo "$Nov"; ?>, <?php echo "$Dec"; ?>],
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7,
                        fontColor: isDarkChart ? '#cbd5e1' : '#858796'
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        fontColor: isDarkChart ? '#cbd5e1' : '#858796',
                        callback: function(value, index, values) {
                            return 'Rp.' + number_format(value);
                        }
                    },
                    gridLines: {
                        color: isDarkChart ? "rgba(255, 255, 255, 0.08)" : "rgb(234, 236, 244)",
                        zeroLineColor: isDarkChart ? "rgba(255, 255, 255, 0.12)" : "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: isDarkChart ? "#161c2e" : "rgb(255,255,255)",
                bodyFontColor: isDarkChart ? "#f1f5f9" : "#858796",
                titleMarginBottom: 10,
                titleFontColor: isDarkChart ? "#ffffff" : '#6e707e',
                titleFontSize: 14,
                borderColor: isDarkChart ? "rgba(255, 255, 255, 0.15)" : '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': Rp. ' + number_format(tooltipItem.yLabel);
                    }
                }
            }
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('#showcustomer').click(function() {
            $.ajax({
                type: 'get',
                url: '<?= site_url('dashboard/getcustomer') ?>',
                cache: false,
                beforeSend: function() {

                    $('#loading1').html(` <div class="container">
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>`);
                },
                success: function(data) {
                    $('#hidecustomer').show();
                    $('#showcustomer').hide();
                    var c = jQuery.parseJSON(data);
                    $("#cardcustomer").show();
                    $("#loading1").hide();
                    $('#customeractive').html(c['customeractive']);
                    $('#customernonactive').html(c['customernonactive']);
                    $('#customerwaiting').html(c['customerwaiting']);
                    $('#customerfree').html(c['customerfree']);
                    $('#customerisolir').html(c['customerisolir']);
                    $('#customerduedate').html(c['customerduedate']);

                }
            });
        });
        $('#hidecustomer').click(function() {

            $('#hidecustomer').hide();
            $('#showcustomer').show();
            $('#customeractive').html('xxx');
            $('#customernonactive').html('xxx');
            $('#customerwaiting').html('xxx');
            $('#customerfree').html('xxx');
            $('#customerisolir').html('xxx');
            $('#customerduedate').html('xxx');
        });

        $('#showincome').click(function() {
            $.ajax({
                type: 'get',
                url: '<?= site_url('dashboard/getincome') ?>',
                cache: false,
                beforeSend: function() {

                    $('#loading2').html(` <div class="container">
<div class="text-center">
<div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
<span class="sr-only">Loading...</span>
</div>
</div>
</div>`);
                },
                success: function(data) {
                    $('#hideincome').show();
                    $('#showincome').hide();
                    $('#loading2').hide();
                    var c = jQuery.parseJSON(data);

                    $('#incomethismonth').html(c['incomethismonth']);
                    $('#incomelastmonth').html(c['incomelastmonth']);
                    $('#incometoday').html(c['incometoday']);
                    $('#incomeyesterday').html(c['incomeyesterday']);
                    $('#difference').html(c['difference']);

                }
            });
        });
        $('#hideincome').click(function() {

            $('#hideincome').hide();
            $('#showincome').show();
            $('#incomethismonth').html('xxx');
            $('#incomelastmonth').html('xxx');
            $('#incometoday').html('xxx');
            $('#incomeyesterday').html('xxx');
            $('#difference').html('xxx');
        });

        $('#showexpenditure').click(function() {
            $.ajax({
                type: 'get',
                url: '<?= site_url('dashboard/getexpenditure') ?>',
                cache: false,
                beforeSend: function() {

                    $('#loading3').html(` <div class="container">
<div class="text-center">
<div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
<span class="sr-only">Loading...</span>
</div>
</div>
</div>`);
                },
                success: function(data) {
                    var c = jQuery.parseJSON(data);
                    $('#hideexpenditure').show();
                    $('#showexpenditure').hide();

                    $("#loading3").hide();
                    $('#expenditurethismonth').html(c['expenditurethismonth']);
                    $('#expenditurelastmonth').html(c['expenditurelastmonth']);
                    $('#expendituretoday').html(c['expendituretoday']);
                    $('#expenditureyesterday').html(c['expenditureyesterday']);

                }
            });
        });
        $('#hideexpenditure').click(function() {

            $('#hideexpenditure').hide();
            $('#showexpenditure').show();
            $("#loading3").hide();
            $('#expenditurethismonth').html('xxx');
            $('#expenditurelastmonth').html('xxx');
            $('#expendituretoday').html('xxx');
            $('#expenditureyesterday').html('xxx');
        });


        $('#showbill').click(function() {
            $.ajax({
                type: 'get',
                url: '<?= site_url('dashboard/getbill') ?>',
                cache: false,
                beforeSend: function() {

                    $('#loading4').html(` <div class="container">
<div class="text-center">
<div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
<span class="sr-only">Loading...</span>
</div>
</div>
</div>`);
                },
                success: function(data) {
                    var c = jQuery.parseJSON(data);
                    $('#hidebill').show();
                    $('#showbill').hide();
                    $("#loading4").hide();
                    $('#pendingpayment').html(c['pendingpayment']);
                    $('#amountpendingpayment').html(c['amountpendingpayment']);

                }
            });
        });
        $('#hidebill').click(function() {

            $('#hidebill').hide();
            $('#showbill').show();
            $("#loading4").hide();
            $('#pendingpayment').html('xxx');
            $('#amountpendingpayment').html('xxx');
        });




        return false;
    })
</script>



<script type="text/javascript">
    setInterval("cekbill();", 300000);
    setInterval("fixdouble();", 780000);
    setInterval("fixbill();", 900000);
    setInterval("fixbillamount();", 180000);
    setInterval("deldouble();", 120000);
    var month = "<?= date('m') ?>";
    var year = "<?= date('Y') ?>";

    function deldouble() {
        console.log('menjalankan hapus double pemasukan');
        $.ajax({
            type: 'get',
            url: '<?= site_url('income/deldouble/') ?>' + month + '/' + year,
            cache: false,
            success: function(data) {}
        });
    }

    function cekbill() {
        console.log('menjalankan cek bill');
        $.ajax({
            type: 'get',
            url: '<?= site_url('customer/cekbill') ?>',
            cache: false,
            success: function(data) {}
        });
    }

    function fixdouble() {
        console.log('menjalankan fixdouble');
        $.ajax({
            type: 'get',
            url: '<?= site_url('bill/fixdouble') ?>',
            cache: false,
            success: function(data) {}
        });
    }

    function fixbill() {
        console.log('menjalankan fixbill');
        $.ajax({
            type: 'get',
            url: '<?= site_url('dashboard/fixbill') ?>',
            cache: false,
            success: function(data) {}
        });
    }

    function fixbillamount() {
        console.log('menjalankan fixbillamount');
        $.ajax({
            type: 'get',
            url: '<?= site_url('dashboard/fixbillamount') ?>',
            cache: false,
            success: function(data) {}
        });
    }
</script>
<script>
    $(document).ready(function() {
        $.ajax({
            type: 'get',
            url: '<?= site_url('dashboard/createbill') ?>',
            cache: false,
            success: function(data) {}
        });

        return false;
    })
</script>
<?php $pg = $this->db->get('payment_gateway')->row_array(); ?>
<?php if ($pg['is_active'] == 1) { ?>
    <?php if ($pg['vendor'] == 'Tripay') { ?>
        <script>
            $(document).ready(function() {
                $.ajax({
                    type: 'get',
                    url: '<?= site_url('tripay/transaction') ?>',
                    cache: false,
                    success: function(data) {}
                });

                return false;
            })
        </script>
    <?php } ?>
<?php } ?>
<?php $this->view('messages') ?>

<?php
$router_id = isset($customer['router']) ? $customer['router'] : '';
$no_services = isset($customer['no_services']) ? $customer['no_services'] : '';
$cekbillisolir = !empty($no_services) ? $this->customer_m->getrecheckisolir($router_id, $no_services)->row_array() : null;
if (!empty($cekbillisolir) && $cekbillisolir > 0) {
    isolir($no_services, $router_id);
}
?>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4 nm-card">
            <div class="card-header py-3 nm-card-header">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold" style="color: var(--nm-text-main);"><i class="fas fa-id-card mr-2" style="color: var(--nm-brand);"></i> Data Pelanggan</h6>
                    <button type="button" class="btn btn-sm btn-outline-secondary nm-btn" onclick="closedetailcustomer()" style="font-size: 0.8rem;">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col">Nama</div>
                            <div class="col">: <?= isset($customer['name']) ? htmlspecialchars($customer['name']) : '-'; ?></div>
                        </div>
                        <div class="row">
                            <div class="col">No Layanan</div>
                            <div class="col">: <?= isset($customer['no_services']) ? htmlspecialchars($customer['no_services']) : '-'; ?></div>
                        </div>
                        <div class="row">
                            <div class="col">Tanggal Daftar </div>
                            <div class="col">: <?= !empty($customer['register_date']) ? indo_date($customer['register_date']) : '-'; ?></div>
                        </div>
                        <div class="row">
                            <div class="col">Area</div>
                            <?php $coverage = !empty($customer['coverage']) ? $this->db->get_where('coverage', ['coverage_id' => $customer['coverage']])->row_array() : null; ?>
                            <div class="col">: <?= isset($coverage['c_name']) ? htmlspecialchars($coverage['c_name']) : '-'; ?></div>
                        </div>
                        <div class="row">
                            <div class="col">Router</div>
                            <?php $router = !empty($customer['router']) ? $this->db->get_where('router', ['id' => $customer['router']])->row_array() : null; ?>
                            <div class="col">: <?= isset($router['alias']) ? htmlspecialchars($router['alias']) : '-'; ?></div>
                        </div>


                        <div class="row">
                            <div class="col">Mode</div>
                            <div class="col">: <?= isset($customer['mode_user']) ? htmlspecialchars($customer['mode_user']) : '-'; ?></div>
                        </div>
                        <div class="row">
                            <div class="col">User <?= isset($customer['mode_user']) ? htmlspecialchars($customer['mode_user']) : ''; ?></div>
                            <div class="col">: <?= isset($customer['user_mikrotik']) ? htmlspecialchars($customer['user_mikrotik']) : '-'; ?></div>
                        </div>

                        <?php 
                        $usage = !empty($customer['no_services']) ? $this->mikrotik_m->usagethismonth($customer['no_services'])->result() : [];
                        $totalusage = 0;
                        if (!empty($usage)) {
                            foreach ($usage as $c => $u) {
                                if (isset($u->count_usage)) {
                                    $totalusage += $u->count_usage;
                                }
                            }
                        }
                        ?>
                        <div class="row">
                            <div class="col">Auto Isolir</div>

                            <div class="col">: <?= isset($customer['auto_isolir']) && $customer['auto_isolir'] == 1 ? 'Aktif' : 'Tidak Aktif' ?></div>
                        </div>

                        <?php if ($totalusage > 0) { ?>
                            <div class="row">
                                <div class="col">Pemakaian Bulan Ini </div>


                                <div class="col">: <?= formatBites($totalusage, 2); ?></div>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col">ODC</div>
                            <?php $odc = !empty($customer['id_odc']) ? $this->db->get_where('m_odc', ['id_odc' => $customer['id_odc']])->row_array() : null; ?>
                            <div class="col">: <?= isset($odc['code_odc']) ? htmlspecialchars($odc['code_odc']) : '-'; ?></div>
                        </div>
                        <div class="row">
                            <div class="col">ODP</div>
                            <?php $odp = !empty($customer['id_odp']) ? $this->db->get_where('m_odp', ['id_odp' => $customer['id_odp']])->row_array() : null; ?>
                            <div class="col">: <?= isset($odp['code_odp']) ? htmlspecialchars($odp['code_odp']) : '-'; ?> </div>
                        </div>
                        <div class="row">
                            <div class="col">Port ODP</div>

                            <div class="col">: <?= isset($customer['no_port_odp']) ? htmlspecialchars($customer['no_port_odp']) : '-'; ?> </div>
                        </div>
                        <div class="row">
                            <div class="col">Keterangan</div>

                            <div class="col">: <?= isset($customer['cust_description']) ? htmlspecialchars($customer['cust_description']) : '-'; ?> </div>
                        </div>


                        <div class="mt-4 pt-3 border-top d-flex flex-wrap" style="gap: 8px; border-color: var(--nm-border-card) !important;">
                            <a href="<?= base_url('customer/add') ?>" class="btn nm-btn nm-btn-sm nm-btn-success">
                                <i class="fas fa-user-plus mr-1"></i> Tambah Pelanggan
                            </a>
                            <a href="<?= base_url('customer/edit/' . $customer['customer_id']) ?>" class="btn nm-btn nm-btn-sm nm-btn-primary">
                                <i class="fas fa-user-edit mr-1"></i> Edit Pelanggan
                            </a>
                            <a href="<?= base_url('customer/print/' . $customer['no_services']) ?>" class="btn nm-btn nm-btn-sm" target="_blank">
                                <i class="fas fa-print mr-1"></i> Cetak
                            </a>
                            <a href="<?= base_url('services/detail/' . $customer['no_services']) ?>" class="btn nm-btn nm-btn-sm nm-btn-danger">
                                <i class="fas fa-box-open mr-1"></i> Detail Paket
                            </a>
                            <a href="<?= base_url('mikrotik/client/' . $customer['no_services']) ?>" class="btn nm-btn nm-btn-sm nm-btn-warning" target="_blank">
                                <i class="fas fa-network-wired mr-1"></i> Koneksi
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (count($bill) > 0) { ?>





                <div class="card shadow mb-4 nm-card mt-3" id="databillunpaid">
                    <div class="card-header py-3 nm-card-header">
                        <div class="d-sm-flex align-items-center justify-content-between ">
                            <h6 class="m-0 font-weight-bold" style="color: var(--nm-accent-danger);"><i class="fas fa-exclamation-circle mr-2"></i> TAGIHAN BELUM DIBAYAR</h6>
                            <?php
                            $total = 0;
                            $totalcodeunique = 0;
                            foreach ($bill as $r => $data) {
                                $total += $data->amount;
                                $totalcodeunique += $data->code_unique;

                                if ($data->codeunique == 1) {
                                    $totalbill = $total + $totalcodeunique;
                                } else {
                                    $totalbill = $total;
                                };
                            }
                            ?>
                            <input type="hidden" id="amount" value="<?= $totalbill ?>">
                            <span class="nm-badge nm-badge-inset font-weight-bold" style="color: var(--nm-accent-danger); font-size: 0.95rem; padding: 6px 14px;"><?= indo_currency($totalbill); ?></span>

                        </div>
                        <span class="small font-italic" style="color: var(--nm-text-muted);"><?= number_to_words($totalbill) ?></span>
                    </div>
                    <div class="card-body">
                        <div class="box box-primary">
                            <div class="box-body">
                                <h5 class="font-weight-bold mb-3" style="color: var(--nm-text-main);"><i class="fas fa-receipt mr-2" style="color: var(--nm-brand);"></i> Rincian Tagihan</h5>
                                <?php
                                foreach ($bill as $r => $data) { ?>
                                    <div class="row mb-1">
                                        <div class="col">Periode </div>
                                        <div class="col">: <b> <?= indo_month($data->month); ?> <?= $data->year; ?></b></div>
                                    </div>
                                    <?php if ($data->codeunique == 1) {
                                        $codeunique = $data->code_unique;
                                    } else {
                                        $codeunique = 0;
                                    }; ?>
                                    <div class="row mb-1">
                                        <div class="col">Total Tagihan</div>
                                        <div class="col">: <?= indo_currency($data->amount + $codeunique); ?></div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col">Terhitung</div>
                                        <div class="col">: <?= number_to_words($data->amount + $codeunique); ?></div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col">Jatuh Tempo</div>
                                        <div class="col">: <?= indo_date($data->inv_due_date); ?></div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col">Tanggal Isolir</div>
                                        <div class="col">: <?= indo_date($data->date_isolir); ?></div>
                                    </div>
                                    <div class="row mt-3 align-items-center">

                                        <div class="col d-flex justify-content-center flex-wrap" style="gap: 10px;">
                                            <a target="_blank" href="<?= base_url('bill/detail/' . $data->invoice) ?>" class="btn nm-btn nm-btn-sm nm-btn-primary">
                                                <i class="fas fa-file-invoice mr-1"></i> Detail Invoice
                                            </a>
                                            <a data-toggle="modal" data-target="#ModalBayar<?= $data->invoice_id ?>" href="#" class="btn nm-btn nm-btn-sm nm-btn-success">
                                                <i class="fas fa-money-bill-wave mr-1"></i> Bayar Tagihan
                                            </a>
                                        </div>

                                    </div>
                                    <hr style="border-color: var(--nm-border-card);">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>


        </div>
    </div>
    <?php
    foreach ($bill as $r => $data) { ?>

        <div class="modal fade" id="ModalBayar<?= $data->invoice_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bayar Tagihan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open_multipart('bill/billpaid') ?>

                        <input type="hidden" name="no_services" value="<?= $customer['no_services'] ?>" class="form-control">
                        <input type="hidden" name="invoice_id" value="<?= $data->invoice_id ?>" class="form-control">
                        <input type="hidden" name="invoice" value="<?= $data->invoice ?>" class="form-control">
                        <input type="hidden" name="month" value="<?= indo_month($data->month) ?>" class="form-control">
                        <input type="hidden" name="name" value="<?= $customer['name'] ?>" class="form-control">
                        <input type="hidden" name="email_customer" value="<?= $customer['email'] ?>" class="form-control">
                        <input type="hidden" name="periode" value="<?= indo_month($data->month) ?> <?= $data->year ?>" class="form-control">
                        <input type="hidden" name="agen" value="<?= $user['name'] ?>" class="form-control">

                        <input type="hidden" name="year" value="<?= $data->year ?>" class="form-control">
                        <input type="hidden" name="date_payment" value="<?= date('Y-m-d') ?>" class="form-control">
                        <!-- PPN -->



                        Apakah yakin tagihan dengan no layanan <?= $customer['no_services'] ?> a/n <?= $customer['name'] ?> Periode <span id="peri"></span> sudah terbayarkan ?,


                        <div class="form-group mt-2">
                            <label for="">Nominal</label>
                            <input type="hidden" name="nominal" value="<?= $data->amount ?>" class="form-control">
                            <input type="text" id="shownominal" value="<?= $data->amount ?>" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Metode Pembayaran</label>
                            <select name="metode_payment" id="" class="form-control" required>
                                <option value="">-Pilih-</option>
                                <option value="Cash"> Cash </option>
                                <option value="Transfer">Transfer</option>
                                <option value="Payment Gateway">Payment Gateway</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Kategori</label>
                            <select name="category" id="" class="form-control" required>
                                <?php $category = $this->db->get('cat_income')->result() ?>
                                <?php foreach ($category as $data) { ?>
                                    <option value="<?= $data->category_id ?>"><?= $data->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if ($this->session->userdata('role_id') == 1) { ?>
                            <div class="form-group">
                                <label for="">Diterima Oleh</label>
                                <select name="create_by" class="form-control select2" style="width: 100%;" required>
                                    <option value="<?= $this->session->userdata('id') ?>"><?= $this->session->userdata('name') ?></option>
                                    <?php $receipt = $this->bill_m->getreceipt()->result() ?>
                                    <?php foreach ($receipt as $data) { ?>
                                        <option value="<?= $data->id ?>"><?= $data->name ?> -
                                            <?= $data->role_id == 1 ? 'Admin' : '' ?>
                                            <?= $data->role_id == 2 ? 'Pelanggan' : '' ?>
                                            <?= $data->role_id == 3 ? 'Operator' : '' ?>
                                            <?= $data->role_id == 4 ? 'Mitra' : '' ?>
                                            <?= $data->role_id == 5 ? 'Teknisi' : '' ?>
                                            <?= $data->role_id == 6 ? 'Outlet' : '' ?>
                                            <?= $data->role_id == 7 ? 'Kolektor' : '' ?>
                                            <?= $data->role_id == 8 ? 'Finance' : '' ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>
                        <?php if ($this->session->userdata('role_id') != 1) { ?>
                            <input type="hidden" name="create_by" value="<?= $this->session->userdata('id') ?>">
                        <?php } ?>
                        <div class="modal-footer" style="border-top: 1px solid var(--nm-border-card);">
                            <button type="button" class="btn nm-btn nm-btn-sm" data-dismiss="modal">
                                <i class="fas fa-times mr-1"></i> Batal
                            </button>
                            <button type="submit" id="click-me" class="btn nm-btn nm-btn-sm nm-btn-success font-weight-bold">
                                <i class="fas fa-check mr-1"></i> Ya, Lanjutkan
                            </button>
                        </div>
                        <?php echo form_close() ?>
                    </div>

                </div>
            </div>
        </div>
    <?php } ?>

    <div class="col-lg-6" id="databillhistory">
        <div class="card shadow mb-4 nm-card">
            <div class="card-header py-3 nm-card-header">
                <h6 class="m-0 font-weight-bold" style="color: var(--nm-text-main);"><i class="fas fa-history mr-2" style="color: var(--nm-brand);"></i> Riwayat Tagihan <span id="year"><?= date('Y'); ?></span></h6>
            </div>
            <input type="hidden" id="detail_customer_no_services" value="<?= isset($customer['no_services']) ? htmlspecialchars($customer['no_services']) : '' ?>">
            <div class="row ml-4">
                <div class="col-md-0 mt-2">
                    <label class="col-sm-12 col-form-label">Tahun</label>
                </div>
                <div class="col-sm-3  mt-3">
                    <select class="form-control" style="width: 100%;" name="year" id="selectyear" onchange="selectyear()">
                        <option value="<?= date('Y') ?>"><?= date('Y') ?></option>
                        <?php
                        for ($i = date('Y'); $i >= 2018; $i -= 1) {
                        ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="card-body">
                <div class="container" id="loading1">
                    <div class="text-center">
                        <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="" id="datahistory"></div>

            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        // Hanya inisialisasi Select2 pada modal yang belum aktif agar tidak merusak select2 di halaman utama
        $('#databillhistory select.select2, .modal select.select2').each(function() {
            if (!$(this).hasClass('select2-hidden-accessible')) {
                $(this).select2({
                    dropdownParent: $(this).closest('.modal')
                });
            }
        });
    });
    $(document).ready(function() {
        getbillhistory();

        function getbillhistory() {
            var no_services = $("#detail_customer_no_services").val();
            var year = $("#selectyear").val();

            $.ajax({
                type: 'POST',
                data: "&no_services=" + no_services + "&year=" + year,
                url: '<?= site_url('bill/gethistorybill') ?>',
                cache: false,
                success: function(data) {
                    $("#loading1").hide();
                    $("#datahistory").html(data);

                }
            });
        }
        return false;
    })

    function selectyear() {
        var no_services = $("#detail_customer_no_services").val();
        var year = $("#selectyear").val();
        $.ajax({
            type: 'POST',
            data: "&no_services=" + no_services + "&year=" + year,
            url: '<?= site_url('bill/gethistorybill') ?>',
            cache: false,
            beforeSend: function() {
                $("#loading1").html(` <div class="container">
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>`);
            },
            success: function(data) {
                $("#loading1").hide();
                $("#year").html(year);
                $("#datahistory").html(data);
            }
        });
        return false;
    }
</script>
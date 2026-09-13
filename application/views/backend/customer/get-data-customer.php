<link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png') ?>">
<!-- Custom fonts for this template-->
<link href="<?= base_url('assets/backend/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<!-- Custom styles for this template-->
<link href="<?= base_url('assets/backend/') ?>css/sb-admin-2.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
<!-- Custom styles for this page -->
<link href="<?= base_url('assets/backend/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?= base_url('assets/backend/') ?>css/select2.min.css" rel="stylesheet">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?= base_url('assets/backend') ?>/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
<!-- Neumorphism Soft UI Theme -->
<link href="<?= base_url('assets/backend/') ?>css/neumorphism.css?v=<?= time() ?>" rel="stylesheet">
<input type="hidden" id="status" value="<?= isset($post['status']) ? $post['status'] : '' ?>">
<input type="hidden" id="coverage" value="<?= isset($post['coverage']) ? $post['coverage'] : '' ?>">
<?php 
$cov_id = isset($post['coverage']) ? $post['coverage'] : 0;
$coverage = (!empty($cov_id) && $cov_id !== 'Semua') ? $this->db->get_where('coverage', ['coverage_id' => $cov_id])->row_array() : null;
$c_name = (!empty($coverage) && isset($coverage['c_name'])) ? $coverage['c_name'] : 'Semua Area';
?>
<div class="nm-card mb-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-3 pb-3" style="border-bottom: 1px solid var(--nm-shadow-dark);">
        <h5 class="m-0 font-weight-bold" style="color: var(--nm-text-main);"><i class="fas fa-users mr-2" style="color: var(--nm-brand);"></i> Data Pelanggan Area <?= $c_name; ?></h5>
        <div class="" id="cardestimation" style="display: none;">
            <?php if ($this->session->userdata('role_id') == 1) { ?>
                <?php if (isset($post['status']) && $post['status'] == 'Aktif') { ?>
                    <div class="px-3 py-2 text-right" style="background: var(--nm-bg); box-shadow: var(--nm-inset-sm); border-radius: var(--nm-radius-md);">
                        <small class="nm-label d-block" style="color: var(--nm-brand);">Estimasi Pendapatan <?= $c_name; ?></small>
                        <span id="estimation" class="font-weight-bold" style="color: var(--nm-accent-success); font-size: 1.1rem;"></span> <small style="color: var(--nm-text-muted);">/ Bulan</small>
                        <div style="font-size: 0.72rem; color: var(--nm-text-muted);">Belum Termasuk PPN</div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive mt-2">
            <form method="post" action="<?php echo base_url('bill/printinvoiceselected') ?>" id="submit-update">

                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr style="text-align: center">
                            <th style="text-align: center; width:20px">No</th>
                            <th style="text-align: center; width:20px"> <input type='checkbox' class='check-item' id="selectAll"></th>
                            <th>Nama</th>
                            <th>No Layanan</th>
                            <th>Email</th>
                            <th>No Telp.</th>
                            <th>Status</th>
                            <th>Ppn</th>
                            <?php if ($this->session->userdata('role_id') == 1) { ?>
                                <th style="width: 100px">Tagihan / Bulan</th>
                            <?php } ?>
                            <th>Alamat</th>
                            <th style="text-align: center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('customer/delete') ?>
                <input type="hidden" name="customer_id" id="customer_id" class="form-control">

                Apakah and yakin hapus pelanggan <span id="no_services"></span> <span id="name"></span> ?
                <br>
                <br>
                <input type="checkbox" id="clickdelincome"> <label for="">Hapus Data Pemasukan</label>
                <input type="hidden" name="delincome" id="delincome">
                <br>
                <div id="formdelincome" style="display: none">
                    <span style="color: blue;">Penghapusan data pemasukan akan mempengaruhi Saldo Kas dan Data Pemasukan</span>
                    <br>
                </div>
                <span style="color: red;">
                    Penghapusan ini akan menghapus semua data riwayat tagihan pelanggan tsb</span>
                <br> <input type="checkbox" id="agree" required> <label for="">* Saya Setuju</label>
                <input type="hidden" name="iagree" id="iagree">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="click-me" class="btn btn-danger">Hapus</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var coverage = $("#coverage").val();
        var status = $("#status").val();
        // DataTable
        $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('customer/getfiltercoverage/') ?>",
                data: {
                    coverage: coverage,
                    status: status,
                },

                "type": "POST",
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }],
            "lengthMenu": [
                [50, 100, 250, 500, 1000],
                [50, 100, 250, 500, 1000]
            ],
            dom: 'lBfrtip',
            buttons: [{
                    extend: ['copy'],
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['csv'],
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['excel'],
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['pdf'],
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['print'],
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ],

            "language": {
                "emptyTable": "No data available in table",
                "zeroRecords": "No data available in table",
                "info": "Showing <b>_START_</b> to <b>_END_ of _TOTAL_</b> entries",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                },
                search: "_INPUT_",
                searchPlaceholder: "No Layanan, Nama"
            },
            "columnDefs": [{
                "targets": [0, 1, 8],
                "orderable": false
            }],

        });

    });
</script>
<script>
    $(document).ready(function() {
        $("#selectAll").click(function() {
            if ($(this).is(":checked"))
                $(".check-item").prop("checked", true);
            else // Jika checkbox all tidak diceklis
                $(".check-item").prop("checked", false);
        });
        $("#createuser").click(function() {
            $('#submit-update').attr('action', '<?php echo base_url('customer/createuserlogin') ?>').attr('target', '_blank');
            Swal.fire({
                title: 'Apakah anda yakin ?',
                text: "Akan membuat user login untuk pelanggan yang dipilih, default password : 1234",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {

                    $("#submit-update").submit();
                }


            })


        });
        var coverage = $("#coverage").val();
        $.ajax({
            type: 'post',
            url: '<?= site_url('customer/getestimationincomecoverage') ?>',
            data: {
                coverage: coverage,
            },
            cache: false,
            success: function(data) {
                var c = jQuery.parseJSON(data);
                $("#cardestimation").show();
                $('#estimation').html(c['estimation']);
            }
        });
        return false;
    })
</script>

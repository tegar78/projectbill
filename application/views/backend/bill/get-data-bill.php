<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
<!-- Custom styles for this page -->
<link href="<?= base_url('assets/backend/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- Neumorphism Soft UI Theme -->
<link href="<?= base_url('assets/backend/') ?>css/neumorphism.css?v=<?= time() ?>" rel="stylesheet">
<?php $coverage = isset($post['coverage']) ? $this->db->get_where('coverage', ['coverage_id' => $post['coverage']])->row_array() : null; ?>

<div class="table-responsive">
    <form method="post" action="<?php echo base_url('bill/printinvoiceselected') ?>" id="submit-cetak">
        <!-- <input type="hidden" name='invoice[]' id="result" size="60"> -->
        <table class="table table-bordered table-hover text-nowrap w-100" id="example" width="100%" cellspacing="0">
            <thead>
                <tr style="text-align: center">
                    <th style="text-align: center; width:20px">No</th>
                    <th style="width:20px">
                        <input type='checkbox' class='check-item' id="selectAll">
                    </th>
                    <th>Nama Pelanggan</th>
                    <th>No. Telepon</th>
                    <th>No. Layanan</th>
                    <th>No. Invoice</th>
                    <th>Periode</th>
                    <th>Jatuh Tempo</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Coverage</th>
                    <th style="text-align: center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </form>
</div>

<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content nm-card border-0">
            <div class="modal-header nm-card-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-trash-alt mr-2 text-danger"></i> Hapus Tagihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('bill/delete') ?>
                <input type="hidden" id="invoice_idd" name="invoice_id" class="form-control">
                <input type="hidden" id="invoicee" name="invoice" class="form-control">
                <input type="hidden" id="monthhh" name="month" class="form-control">
                <input type="hidden" id="yearrr" name="year" class="form-control">
                <input type="hidden" id="no_servicesss" name="no_services" class="form-control">
                Apakah yakin akan hapus tagihan <span id="noservices" class="font-weight-bold"></span> <span id="periodee"> </span> Periode <span id="period" class="font-weight-bold"></span> A/N <span id="namee" class="font-weight-bold"></span> ?
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary nm-btn" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger nm-btn">Hapus</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var coverageVal = <?= json_encode(isset($post['coverage']) ? $post['coverage'] : 'all') ?>;
        var statusVal = <?= json_encode(isset($post['status']) ? $post['status'] : '') ?>;
        var monthVal = <?= json_encode(isset($post['month']) ? $post['month'] : '') ?>;
        var yearVal = <?= json_encode(isset($post['year']) ? $post['year'] : '') ?>;

        // DataTable
        $('#example').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('bill/getfiltercoverage/') ?>",
                "data": {
                    coverage: coverageVal,
                    status: statusVal,
                    month: monthVal,
                    year: yearVal
                },
                "type": "POST"
            },
            "columnDefs": [
                {
                    "targets": [0, 1, 11],
                    "orderable": false,
                    "className": "text-center text-nowrap"
                },
                {
                    "targets": [2, 3, 4, 5, 6, 7, 8, 9, 10],
                    "className": "text-nowrap"
                }
            ],
            "lengthMenu": [
                [10, 25, 50, 100, 250, 500, 1000],
                [10, 25, 50, 100, 250, 500, 1000]
            ],
            dom: 'lBfrtip',
            buttons: [
                {
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
                "emptyTable": "Tidak ada data",
                "zeroRecords": "Tidak ada data",
                "info": "Showing <b>_START_</b> to <b>_END_ of _TOTAL_</b> entries",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                },
                search: "_INPUT_",
                searchPlaceholder: "No Layanan, No Invoice, Nama, No HP"
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#selectAll").click(function() {
            if ($(this).is(":checked"))
                $(".check-item").prop("checked", true);
            else
                $(".check-item").prop("checked", false);
        });
    });
</script>
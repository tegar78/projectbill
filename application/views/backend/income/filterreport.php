<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
<!-- Custom styles for this page -->
<link href="<?= base_url('assets/backend/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Laporan Keuangan <?= $date; ?> <?= indo_month($month); ?> <?= $year; ?></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="tablerep" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="width:100px">Tanggal</th>
                        <th>Keterangan</th>
                        <th>Kategori</th>
                        <th style="width:100px">Debit</th>
                        <th style="width:100px">Kredit</th>
                        <th style="width:100px">Saldo</th>
                    </tr>
                </thead>
                <tfoot>
                    <?php
                    $income = 0;
                    $expend = 0;
                    $report_list = is_array($report) ? $report : json_decode($report, true);
                    if (!is_array($report_list)) {
                        $report_list = [];
                    }
                    foreach ($report_list as $key => $data) {
                        $income += isset($data['income']) ? (float)$data['income'] : 0;
                        $expend += isset($data['expenditure']) ? (float)$data['expenditure'] : 0;
                    }
                    ?>
                    <tr style="text-align: center">
                        <th style="text-align: right; font-weight:bold" colspan="3"><b>Total</b></th>
                        <th style="text-align: right"><?= indo_currency($income) ?> </th>
                        <th style="text-align: right"><?= indo_currency($expend) ?></th>
                        <th style="text-align: right"><?= indo_currency($income - $expend) ?></th>
                    </tr>

                </tfoot>
                <tbody>

                    <?php
                    $saldo = 0;
                    foreach ($report_list as $key => $data) {
                        $saldo = $saldo + (float)$data['income'] - (float)$data['expenditure'];
                    ?>
                        <tr>
                            <td><?= !empty($data['date']) ? indo_date($data['date']) : '-'  ?> </td>
                            <td><?= isset($data['remark']) ? htmlspecialchars($data['remark']) : '' ?></td>
                            <td><?= isset($data['category']) ? htmlspecialchars($data['category']) : '' ?></td>
                            <td style="text-align: right"><?= !empty($data['income']) ? indo_currency($data['income']) : '-'   ?></td>
                            <td style="text-align: right"><?= !empty($data['expenditure']) ? indo_currency($data['expenditure']) : '-'  ?></td>
                            <td style="text-align: right"><?= indo_currency($saldo)  ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tablerep').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "lengthMenu": [
                [25, 50, 100, -1],
                [25, 50, 100, "Semua"]
            ],
            dom: 'lBfrtip',
            buttons: [{
                    extend: ['copy'],
                    footer: true,
                    title: 'Laporan Keuangan  <?= $date ?> <?= indo_month($month) ?> <?= $year ?>',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['csv'],
                    footer: true,
                    title: 'Laporan Keuangan  <?= $date ?> <?= indo_month($month) ?> <?= $year ?>',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['excel'],
                    footer: true,
                    title: 'Laporan Keuangan  <?= $date ?> <?= indo_month($month) ?> <?= $year ?>',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['pdf'],
                    footer: true,
                    title: 'Laporan Keuangan  <?= $date ?> <?= indo_month($month) ?> <?= $year ?>',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['print'],
                    footer: true,
                    title: 'Laporan Keuangan  <?= $date ?> <?= indo_month($month) ?> <?= $year ?>',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ],
            "columnDefs": [{
                "targets": [0],
                "orderable": false
            }],

        });
    });
</script>
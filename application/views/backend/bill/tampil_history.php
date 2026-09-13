<div class="table-responsive">
    <?php 
    $cust = $this->db->get_where('customer', ['no_services' => $no_services])->row_array();
    $customer_name = isset($cust['name']) ? $cust['name'] : '';

    // Ambil seluruh invoice untuk tahun terkait dalam 1 query efisien
    $invoice_list = $this->db->get_where('invoice', [
        'no_services' => $no_services,
        'year' => $year
    ])->result_array();

    $invoices_by_month = [];
    if (!empty($invoice_list)) {
        foreach ($invoice_list as $inv) {
            $invoices_by_month[(int)$inv['month']] = $inv;
        }
    }

    $month_names = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];
    ?>
    <div class="font-weight-bold mb-3" style="color: var(--nm-text-main); font-size: 0.95rem;">
        <i class="fas fa-user-circle mr-1" style="color: var(--nm-brand);"></i> <?= htmlspecialchars($customer_name) ?> - <?= htmlspecialchars($no_services) ?> - <?= htmlspecialchars($year) ?>
    </div>
    <table class="table table-bordered nm-table" id="dataTable" cellspacing="0" style="font-size: 13px;">
        <thead>
            <tr style="text-align: center">
                <th style="vertical-align: middle;">Bulan</th>
                <th style="vertical-align: middle;">No Invoice</th>
                <th style="vertical-align: middle;">Tagihan</th>
                <th style="vertical-align: middle;">Status</th>
                <th style="vertical-align: middle; width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($month_names as $m_num => $m_name) { 
                $invoice = isset($invoices_by_month[$m_num]) ? $invoices_by_month[$m_num] : null;
            ?>
            <tr>
                <td style="text-align: center; vertical-align: middle; font-weight: 500;"><?= $m_name ?></td>
                <?php if (!empty($invoice)) { ?>
                    <td style="text-align: center; vertical-align: middle;">
                        <a href="<?= base_url('bill/detail/' . $invoice['invoice']) ?>" class="font-weight-bold" style="color: var(--nm-brand); text-decoration: none;">
                            <?= $invoice['invoice'] ?>
                        </a>
                    </td>
                    <td style="text-align: center; vertical-align: middle; font-weight: 600;">
                        <?= indo_currency($invoice['amount']); ?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                            <span class="nm-badge nm-badge-inset font-weight-bold" style="color: var(--nm-accent-danger); font-size: 0.72rem; padding: 4px 10px;">Belum Bayar</span>
                        <?php } else if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                            <span class="nm-badge nm-badge-inset font-weight-bold" style="color: var(--nm-accent-success); font-size: 0.72rem; padding: 4px 10px;">Sudah Bayar</span>
                        <?php } else { ?>
                            <span class="badge badge-secondary"><?= $invoice['status'] ?></span>
                        <?php } ?>
                    </td>
                    <td style="text-align: center; vertical-align: middle; white-space: nowrap;">
                        <div class="d-inline-flex align-items-center justify-content-center" style="gap: 6px; flex-wrap: nowrap;">
                            <a class="btn nm-btn nm-btn-xs" target="_blank" href="<?= site_url('bill/printinvoice/' . $invoice['invoice']) ?>" title="Cetak Invoice A4">
                                <i class="fas fa-print" style="color: var(--nm-brand);"></i> <span>A4</span>
                            </a>
                            <a class="btn nm-btn nm-btn-xs" target="_blank" href="<?= site_url('bill/printinvoicethermal/' . $invoice['invoice']) ?>" title="Cetak Invoice Thermal">
                                <i class="fas fa-receipt" style="color: #d97706;"></i> <span>Thermal</span>
                            </a>
                        </div>
                    </td>
                <?php } else { ?>
                    <td style="vertical-align: middle;"></td>
                    <td style="vertical-align: middle;"></td>
                    <td style="vertical-align: middle;"></td>
                    <td style="vertical-align: middle;"></td>
                <?php } ?>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
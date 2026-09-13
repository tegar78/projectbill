<section class="section">

    <?php $this->view('messages') ?>

</section>



<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <a href="<?= site_url('odp/add') ?>" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah odp</a>



</div>

<!-- DataTales Example -->

<div class="card shadow mb-4">

    <div class="card-header py-3">

        <h6 class="m-0 font-weight-bold">Data ODP</h6>



    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered" id="tablebt" width="100%" cellspacing="0">

                <thead>

                    <tr>

                        <th>No</th>

                        <th style="text-align: center;">Aksi</th>

                        <th>Kode ODP</th>

                        <th>Kode ODC</th>

                        <th>Port ODC</th>

                        <th>Total Pelanggan</th>

                        <th>Wilayah</th>

                        <th>Titik Koordinat</th>

                        <th>No Tiang</th>

                        <th>Jumlah Port</th>

                        <th>Warna Tube FO</th>

                        <th>Document</th>

                        <th>Keterangan</th>

                    </tr>

                </thead>

                <tbody>

                    <?php $no = 1;

                    foreach ($odp as $r => $data) { ?>

                        <tr>

                            <td width="35px"><?= $no++ ?>.</td>

                            <td class="text-center" width="160px">

                                <form>

                                    <a class="btn btn-xs btn-primary" href="<?= site_url('odp/edit/' . $data->id_odp) ?>" title="Edit"><i class="fa fa-edit"> </i></a>

                                    <a class="btn btn-xs btn-danger btn-delete-odp" href="#ModalHapus" data-toggle="modal" data-id="<?= $data->id_odp ?>" data-code="<?= htmlspecialchars($data->code_odp) ?>" title="Hapus"><i class="fa fa-trash"></i></a>

                                </form>

                            </td>

                            <td><?= $data->code_odp ?></td>

                            <td><?= !empty($data->odc_code) ? $data->odc_code : '-' ?></td>

                            <td style="text-align: center;"><?= $data->no_port_odc ?></td>

                            <td style="text-align: center;"><?= $data->total_customer ?></td>

                            <td><?= !empty($data->coverage_name) ? $data->coverage_name : '-' ?></td>

                            <td>

                                Latitude : <?= $data->latitude ?><br>

                                Longitude : <?= $data->longitude ?> <br>

                                <?php if (!empty($data->latitude) && !empty($data->longitude)) { ?>

                                    <a target="_blank" href="http://www.google.com/maps/place/<?= $data->latitude ?> , <?= $data->longitude ?>">

                                        <div class="badge badge-primary">Rute Maps</div>

                                    </a>

                                <?php } ?>

                            </td>

                            <td><?= $data->no_pole ?></td>

                            <td>

                                <?= indo_currency($data->total_port) ?> <br>

                                <?php if ($data->active_customer < $data->total_port) { ?>

                                    <div class="badge badge-success">Available</div>

                                <?php } else { ?>

                                    <div class="badge badge-danger">Full</div>

                                <?php } ?>

                            </td>

                            <td><?= $data->color_tube_fo ?></td>

                            <td>

                                <?php if (!empty($data->document)) { ?>

                                    <a href="#imagemodal" data-toggle="modal" data-target="#myModal1">

                                        <img loading="lazy" class="getSrc" src="<?= base_url('assets/images/document/' . $data->document) ?>" alt="" width="250px">

                                    </a>

                                <?php } else { ?>

                                    -

                                <?php } ?>

                            </td>

                            <td><?= $data->remark; ?></td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>



    <script type="text/javascript">
        $('.getSrc').click(function() {

            var src = $(this).attr('src');



            $('.showPic').attr('src', src);

        });
    </script>



    <!-- MODAL -->



    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="myModal1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="col-md-12">



                    <img src="" style="width: 100%;" class="showPic">

                </div>

            </div>

        </div>

    </div>

    <!-- MODAL Hapus Tunggal Dinamis -->

    <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" style="display: none;" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h3 class="modal-title" id="formModalLabel">Hapus odp</h3>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    <form method="post" action="<?= base_url('odp/delete') ?>" enctype="multipart/form-data">

                        <input type="hidden" name="id_odp" id="delete_id_odp" class="form-control">

                        Apakah anda yakin akan hapus odp <span id="delete_code_odp" class="font-weight-bold"></span> ?

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    <button class="btn btn-danger"> Ya, lanjutkan</button>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <!--END MODAL Hapus-->

    <script>
        $(function() {

            //Initialize Select2 Elements

            $('.select2').select2();

            $(document).on('click', '.btn-delete-odp', function() {
                var id = $(this).data('id');
                var code = $(this).data('code');
                $('#delete_id_odp').val(id);
                $('#delete_code_odp').text(code);
            });

        });
    </script>
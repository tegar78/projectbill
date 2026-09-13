<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<style>
    #mapid {
        height: 250px;
    }
</style>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title ?> | <?= $company['company_name'] ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/backend/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.10.4/dist/sweetalert2.all.min.js"></script>
    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/backend/') ?>css/sb-admin-2.min.css" rel="stylesheet">
    <?php $role = $this->db->get_where('role_management', ['role_id' => 2])->row_array() ?>

</head>

<body class="bg-gradient-primary">
    <div class="container">
        <?php if ($role['register_show'] != 1) {
            redirect('auth');
        } ?>
        <?php $is_cov_pkg = (isset($package) && is_array($package) && isset($package['coverage_package']) && $package['coverage_package'] == 1); ?>
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10">
                <div class="card o-hidden border-0 shadow-lg my-4 my-md-5">
                    <div class="card-body p-0">
                        <div class="p-4 p-md-5">
                            <div class="text-center mb-4">
                                <?php if (!empty($company['logo']) && file_exists(FCPATH . 'assets/images/' . $company['logo'])) { ?>
                                    <img class="mb-3 img-fluid mx-auto d-block" style="max-height: 70px; width: auto;" src="<?= base_url('assets/images/' . $company['logo']) ?>" alt="<?= htmlspecialchars($company['company_name'] ?? 'Logo') ?>">
                                <?php } elseif (file_exists(FCPATH . 'assets/images/logo.png')) { ?>
                                    <img class="mb-3 img-fluid mx-auto d-block" style="max-height: 70px; width: auto;" src="<?= base_url('assets/images/logo.png') ?>" alt="Logo">
                                <?php } else { ?>
                                    <div class="text-center mb-3">
                                        <i class="fas fa-wifi text-primary" style="font-size: 44px;"></i>
                                    </div>
                                <?php } ?>
                                <h1 class="h4 text-gray-900 font-weight-bold">Daftar Pelanggan <?= htmlspecialchars($company['company_name']); ?></h1>
                                <p class="text-muted small">Lengkapi formulir pendaftaran untuk berlangganan layanan internet</p>
                            </div>
                            <?= $this->session->flashdata('message') ?>
                            <?php echo form_open_multipart('auth/register') ?>
                            <div class="form-group">
                                <input type="hidden" name="no_services" value="0">
                                <input type="hidden" class="form-control form-control-user" name="due_date" value="0">
                                <label for="name" class="small text-muted font-weight-bold">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap" value="<?= set_value('name') ?>" required>
                                <?= form_error('name', '<small class="text-danger pl-1">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <label for="Email" class="small text-muted font-weight-bold">Alamat Email</label>
                                <input type="email" class="form-control" id="Email" name="email" placeholder="Alamat Email" value="<?= set_value('email') ?>" required>
                                <?= form_error('email', '<small class="text-danger pl-1">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <label for="no_wa" class="small text-muted font-weight-bold">No. Whatsapp</label>
                                <input type="number" class="form-control" id="no_wa" name="no_wa" placeholder="No Whatsapp" value="<?= set_value('no_wa') ?>" required>
                                <?= form_error('no_wa', '<small class="text-danger pl-1">', '</small>') ?>
                            </div>
                            <label for="no_ktp" class="small text-muted font-weight-bold">Identitas Diri (ID Card)</label>
                            <div class="form-group row">
                                <div class="col-sm-4 mb-2 mb-sm-0">
                                    <select name="type_id" id="type_id" class="form-control" required>
                                        <option value="">-Pilih-</option>
                                        <option value="KTP">KTP</option>
                                        <option value="SIM">SIM</option>
                                        <option value="NPWP">NPWP</option>
                                        <option value="Pasport">Pasport</option>
                                    </select>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" id="no_ktp" name="no_ktp" class="form-control" placeholder="Nomor KTP / SIM / NPWP" value="<?= set_value('no_ktp') ?>" required>
                                    <?= form_error('no_ktp', '<small class="text-danger pl-1">', '</small>') ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-2 mb-sm-0">
                                    <label for="Password1" class="small text-muted font-weight-bold">Password</label>
                                    <input type="password" class="form-control" id="Password1" name="password1" placeholder="Password" required>
                                    <?= form_error('password1', '<small class="text-danger pl-1">', '</small>') ?>
                                </div>
                                <div class="col-sm-6">
                                    <label for="Password2" class="small text-muted font-weight-bold">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="Password2" name="password2" placeholder="Konfirmasi Password" required>
                                </div>
                            </div>
                            <?php if ($role['register_coverage'] == 1) { ?>
                                <div class="form-group">
                                    <label for="coverage" class="small text-muted font-weight-bold">Coverage Area</label>
                                    <?php $coverage = $this->db->get_where('coverage', ['public' => 1])->result() ?>
                                    <select name="coverage" id="coverage" class="form-control" <?= $is_cov_pkg ? ' onChange="selectcoverage(this);"' : ''; ?>>
                                        <option value="">-Pilih Coverage-</option>
                                        <?php foreach ($coverage as $cov) { ?>
                                            <option value="<?= $cov->coverage_id ?>"><?= $cov->c_name ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <?php if ($is_cov_pkg) { ?>
                                <div class="loading"></div>
                                <div class="form-group">
                                    <label for="paket" class="small text-muted font-weight-bold">Paket Langganan</label>
                                    <select name="paket" id="datapackage" class="form-control datapackage" required onChange="selectpackage(this);">

                                    </select>
                                </div>
                            <?php } ?>
                            <?php if (!$is_cov_pkg) { ?>
                                <div class="form-group">
                                    <label for="paket" class="small text-muted font-weight-bold">Paket Langganan</label>
                                    <?php $items = $this->db->get_where('package_item', ['public' => 1, 'is_active' => 1])->result() ?>
                                    <select name="paket" id="paket" class="form-control" required>
                                        <option value="">-Pilih Paket-</option>
                                        <?php foreach ($items as $item) { ?>
                                            <option value="<?= $item->p_item_id ?>"><?= $item->name ?> - Rp. <?= indo_currency($item->price); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } ?>

                            <?php if ($role['register_coverage'] == 0) { ?>
                                <input type="hidden" name="coverage" value="0">
                            <?php } ?>
                            <div class="form-group">
                                <label for="address" class="small text-muted font-weight-bold">Alamat Lengkap Pemasangan</label>
                                <textarea id="address" autocomplete="off" name="address" class="form-control" rows="3" placeholder="Alamat lengkap lokasi pemasangan internet" required></textarea>
                            </div>

                            <?php if ($role['register_maps'] == 1) { ?>
                                <div class="form-group">
                                    <label class="small text-muted font-weight-bold">Pilih Titik Lokasi pada Peta</label>
                                    <div id="mapid" class="rounded border"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label for="lat" class="small text-muted font-weight-bold">Latitude</label>
                                        <input type="text" id="lat" name="lat" class="form-control form-control-sm" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label for="long" class="small text-muted font-weight-bold">Longitude</label>
                                        <input type="text" id="long" name="long" class="form-control form-control-sm" readonly>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($role['register_maps'] == 0) { ?>
                                <input type="hidden" id="long" name="long" value="" class="form-control" readonly>
                                <input type="hidden" id="lat" name="lat" value="" class="form-control" readonly>
                            <?php } ?>

                            <div class="form-group my-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="termsCheck" required>
                                    <label class="custom-control-label small text-muted" for="termsCheck">
                                        Saya menyetujui <a href="<?= site_url('syarat-dan-ketentuan.html') ?>" target="_blank" style="text-decoration: none;">Syarat & Ketentuan</a> dan <a href="<?= site_url('kebijakan-privasi.html') ?>" target="_blank" style="text-decoration: none;">Kebijakan Privasi</a> yang berlaku.
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block font-weight-bold py-2 shadow-sm">
                                <i class="fas fa-user-plus mr-1"></i> Daftar Berlangganan
                            </button>
                            </form>
                            <hr class="my-4">
                            <div class="text-center small">
                                <a class="text-muted mr-3" href="<?= site_url('auth/forgotpassword'); ?>">Lupa Password?</a>
                                <a class="font-weight-bold text-primary" href="<?= site_url('auth') ?>">Sudah punya akun? Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/backend/') ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/backend/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/backend/') ?>js/sb-admin-2.min.js"></script>

</body>

</html>
<script>
    function selectcoverage(sel) {
        var coverage = $('#coverage').val();
        if (coverage == '') {
            Swal.fire({
                icon: 'error',
                html: 'Area tidak boleh kosong',
                showConfirmButton: true,
            })

            $('#datapackage').html('');
        } else {
            var url = "<?= site_url('coverage/getpackagebycoverage') ?>" + "/" + Math.random();
            $.ajax({
                type: 'POST',
                url: url,
                data: "&coverage=" + coverage,
                cache: false,
                beforeSend: function() {
                    $('.loading').html(` <div class="container">
<div class="text-center">
    <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
</div>`);
                },
                success: function(data) {
                    $('.loading').html('');
                    $('#datapackage').html(data);
                }
            });
            return false;
        }


    }
</script>

<script>
    var company = "";
    var lat = "";
    var long = "";
    if (lat == '') {
        var mymap = L.map('mapid').fitWorld();
    } else {
        var mymap = L.map('mapid').setView([lat, long], 16);
    }

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        maxZoom: 18,
        // attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
        //     'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
    }).addTo(mymap);


    if (lat == '') {
        function onLocationFound(e) {
            var radius = e.accuracy / 2;
            markernow = L.marker(e.latlng).addTo(mymap)
                .bindPopup("Lokasi Anda Saat Ini <br>Latitude : " + e.latlng.lat + " <br> Longitude : " + e.latlng.lng + "").openPopup();
            L.circle(e.latlng, radius).addTo(mymap);
            $("#long").val(e.latlng.lng);
            $("#lat").val(e.latlng.lat);
        }


        function onLocationError(e) {
            alert(e.message);
        }
        var theMarker = {};

        function onMapClick(e) {
            latt = e.latlng.lat;
            lonn = e.latlng.lng;
            //Clear existing marker, 

            if (theMarker != undefined) {
                mymap.removeLayer(theMarker);
                mymap.removeLayer(markernow);
            };

            //Add a marker to show where you clicked.
            theMarker = L.marker([latt, lonn]).addTo(mymap)
                .bindPopup("Latitude : " + latt + " <br> Longitude : " + lonn + "")
                .openPopup();;

            $("#long").val(e.latlng.lng);
            $("#lat").val(e.latlng.lat);
        }
        mymap.on('locationfound', onLocationFound);
        mymap.on('locationerror', onLocationError);

        mymap.locate({
            setView: true,
            maxZoom: 16
        });
    } else {
        var markernow = L.marker([lat, long]).addTo(mymap)
            .bindPopup(company).openPopup();
        var popup = L.popup();
        var theMarker = {};

        function onMapClick(e) {
            latt = e.latlng.lat;
            lonn = e.latlng.lng;
            //Clear existing marker, 

            if (theMarker != undefined) {
                mymap.removeLayer(theMarker);
                mymap.removeLayer(markernow);
            };

            //Add a marker to show where you clicked.
            theMarker = L.marker([latt, lonn]).addTo(mymap);
            // popup
            //     .setLatLng(e.latlng)
            //     .setContent("You clicked the map at " + e.latlng.toString())
            //     .openOn(mymap);
            $("#long").val(e.latlng.lng);
            $("#lat").val(e.latlng.lat);
        }
        // mymap.locate({
        //     setView: true,
        //     maxZoom: 16
        // });
    }

    mymap.on('click', onMapClick);
</script>
<?= $this->extend('layout/admin'); ?>
<?= $this->section('content'); ?>
<?= $this->include('layout/sidebar-admin'); ?>
<?= session()->getFlashdata('pesan'); ?>
<!-- *************
				************ Main container start *************
			************* -->
<div class="main-container">
    <script src="https://kit.fontawesome.com/42fc19a824.js" crossorigin="anonymous"></script>
    <!-- Page header starts -->
    <div class="page-header">

        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-6 col-9">

                <!-- Search container start -->
                <div class="search-container">

                    <!-- Toggle sidebar start -->
                    <div class="toggle-sidebar" id="toggle-sidebar">
                        <i class="icon-menu"></i>
                    </div>
                    <!-- Toggle sidebar end -->

                    <!-- Mega Menu Start -->
                    <div class="cd-dropdown-wrapper" style="opacity: 0;">
                    </div>
                    <!-- Mega Menu End -->

                    <!-- Search input group start -->
                    <div class="ui fluid category search" style="opacity: 0;">
                    </div>
                    <!-- Search input group end -->

                </div>
                <!-- Search container end -->

            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-3">

                <!-- Header actions start -->
                <ul class="header-actions">
                    <li class="dropdown">
                    </li>
                    <li class="dropdown">
                    </li>
                    <li class="dropdown">
                        <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                            <style>
                            .avatar img {
                                width: 50px; /* Atur lebar gambar */
                                height: 50px; /* Atur tinggi gambar */
                                object-fit: cover; /* Pastikan gambar menutupi seluruh area tanpa mempengaruhi rasio aspek */
                                border-radius: 50%; /* Opsi tambahan: membuat gambar menjadi lingkaran */
                            }
                            </style>
                            <span class="avatar">
                                <img src="<?= base_url(); ?>/assets/img/pegawai/<?= $admin->gambar; ?>" alt="User Avatar">
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end md" aria-labelledby="userSettings">
                            <div class="header-profile-actions">
                                <a href="<?= base_url('admin/profile'); ?>"><i class="icon-user1"></i>Profile</a>
                                <a href="<?= base_url('auth/logout'); ?>"><i class="icon-log-out1"></i>Logout</a>
                            </div>
                        </div>
                    </li>
                </ul>
                <!-- Header actions end -->

            </div>
        </div>
        <!-- Row end -->

    </div>
    <!-- Page header ends -->

    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">
        <!-- Content wrapper start -->
        <div class="content-wrapper">

            <!-- DETAIL ABSEN -->
            <div class="row gutters">

                <div class="d-flex justify-content-start">
                    <a href="<?= base_url('admin/absen'); ?>/<?= $absensi->kode_absensi; ?>" class="btn btn-info" style="display: block; text-align: left; margin: 0; padding: 10px; background-color: transparent; border: none; color: #3468C0; "><i class="fa-solid fa-chevron-left"></i><span style="margin-left: 20px">Kembali</span></a>
                </div>
                <h5>DETAIL ABSENSI <span style="text-transform: uppercase;"><?= $detail_absensi->nama_pegawai; ?></span></h5>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Absen Masuk
                            </h5>
                            <div class="row">
                                <?php if ($detail_absensi->absen_masuk != null) : ?>
                                    <div class="col-lg-4 mt-1">
                                        <center>
                                            <img src="<?= base_url('assets/img/pegawai'); ?>/<?= $detail_absensi->bukti_masuk; ?>" class="img-thumbnail" alt="">
                                        </center>
                                    </div>
                                    <div class="col-lg-8 mt-1">
                                        <style>
                                            .list-group-item {
                                                display: flex;
                                                justify-content: space-between;
                                            }
                                        </style>
                                        <ul class="list-group">
                                            <li class="list-group-item"><span>Jadwal Masuk: </span><?= $pengaturan->jam_masuk; ?></li>
                                            <li class="list-group-item"><span>Absen Masuk: </span><?= date('H:i', $detail_absensi->absen_masuk); ?></li>
                                            <li class="list-group-item">
                                                <span>Status Absen: </span>
                                                <?php if ($detail_absensi->status_masuk == 0) : ?>
                                                    <span class="badge bg-success">Sukses</span>
                                                <?php else : ?>
                                                    <span class="badge bg-danger">Terlambat</span>
                                                <?php endif; ?>
                                            </li>
                                        </ul>
                                    </div>
                                <?php else : ?>
                                    <div class="alert alert-danger">Belum Absen Masuk</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Absen Pulang
                            </h5>
                            <div class="row">
                                <?php if ($detail_absensi->absen_keluar != null) : ?>
                                    <div class="col-lg-4 mt-1">
                                        <center>
                                            <img src="<?= base_url('assets/img/pegawai'); ?>/<?= $detail_absensi->bukti_keluar; ?>" class="img-thumbnail" alt="">
                                        </center>
                                    </div>
                                    <div class="col-lg-8 mt-1">
                                        <style>
                                            .list-group-item {
                                                display: flex;
                                                justify-content: space-between;
                                            }
                                        </style>
                                        <ul class="list-group">
                                            <li class="list-group-item"><span>Jadwal Pulang: </span><?= $pengaturan->jam_keluar; ?></li>
                                            <li class="list-group-item"><span>Absen Pulang: </span><?= date('H:i', $detail_absensi->absen_keluar); ?></li>
                                            <li class="list-group-item">
                                                <span>Status Absen: </span>
                                                <span class="badge bg-success">Sukses</span>
                                            </li>
                                        </ul>
                                    </div>
                                <?php else : ?>
                                    <div class="alert alert-danger">Belum Absen Pulang</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end DETAIL ABSEN -->

        </div>
        <!-- Content wrapper end -->

        <!-- App Footer start -->
        <div class="app-footer">Copyright © 2024. All rights reserved.</div>
        <!-- App footer end -->

    </div>
    <!-- Content wrapper scroll end -->

</div>
<!-- *************
				************ Main container end *************
			************* -->
<?= $this->endSection(); ?>
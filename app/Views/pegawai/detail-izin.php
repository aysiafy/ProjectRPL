<?= $this->extend('layout/pegawai'); ?>
<?= $this->section('content'); ?>
<?= $this->include('layout/sidebar-pegawai'); ?>
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
                                <img src="<?= base_url(); ?>/assets/img/pegawai/<?= $pegawai->gambar; ?>" alt="User Avatar">
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end md" aria-labelledby="userSettings">
                            <div class="header-profile-actions">
                                <a href="<?= base_url('pegawai/profile'); ?>"><i class="icon-user1"></i>Profile</a>
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
            <!-- ROW -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <?php if ($detail_absensi->izin == null) : ?>
                                <div class="d-flex justify-content-start w-100">
                                    <a href="<?= base_url('pegawai/absensi'); ?>" class="btn btn-info" style="display: block; text-align: left; margin: 0; padding: 10px; background-color: transparent; border: none; color: #3468C0; "><i class="fa-solid fa-chevron-left"></i><span style="margin-left: 20px">Kembali</span></a>
                                </div>
                                <h5 class="card-title">
                                    Form Permohonan Izin Absensi
                                </h5>
                                <form action="<?= base_url('pegawai/izin'); ?>" method="post" enctype="multipart/form-data">
                                    <!-- Field wrapper start -->
                                    <input type="hidden" name="kode_absen" value="<?= $detail_absensi->kode_absensi; ?>">
                                    <div class="field-wrapper">
                                        <textarea name="alasan" class="form-control" id="" cols="30" rows="10" required></textarea>
                                        <div class="field-placeholder">Alasan <span class="text-danger">*</span></div>
                                        <div class="form-text">
                                            Tuliskan Alasan Izin
                                        </div>
                                    </div>
                                    <!-- Field wrapper end -->

                                    <!-- Field wrapper start -->
                                    <div class="field-wrapper">
                                        <input class="form-control" type="file" name="bukti_izin" accept=".jpg, .jpeg, .png, .pdf, .doc" required>
                                        <div class="field-placeholder">Bukti</div>
                                        <div class="form-text">
                                            Bukti Berupa File Foto Atapun PDF
                                        </div>
                                    </div>
                                    <!-- Field wrapper end -->
                                    <button type="submit" class="btn btn-primary stripes-btn">Kirim</button>
                                </form>
                            <?php else : ?>
                                <div class="d-flex justify-content-start w-100">
                                    <a href="<?= base_url('pegawai/absensi'); ?>" class="btn btn-info" style="display: block; text-align: left; margin: 0; padding: 10px; background-color: transparent; border: none; color: #3468C0; "><i class="fa-solid fa-chevron-left"></i><span style="margin-left: 20px">Kembali</span></a>
                                </div>
                                <h5 class="card-title">
                                    Data Permohonan Izin Absensi
                                </h5>
                                <h6 class="text-primary">Alasan</h6>
                                <p><?= $detail_absensi->alasan; ?></p>
                                <div class="d-flex justify-content-end w-100 mb-2">
                                <form action="<?= base_url('pegawai/cancel_izin'); ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id_detail_absensi" value="<?= $detail_absensi->id_detail_absensi; ?>">
                                    <input type="hidden" name="kode_absen" value="<?= $detail_absensi->kode_absensi; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Batal Izin</button>
                                </form>
                                </div>
                                <div class="doc-block" style="padding: 13px;">
                                    <div class="doc-icon">
                                        <img src="<?= base_url('assets/template/presensi-abdul'); ?>/img/docs/file.png" alt="Doc Icon">
                                    </div>
                                    <div class="doc-title">File Bukti Izin</div>
                                    <a href="<?= base_url('pegawai/download_izin'); ?>/<?= $detail_absensi->bukti_izin; ?>" class="btn btn-primary" target="_blank">Download</a>
                                </div>
                                <p>Status Izin : <?= ($detail_absensi->status_izin == 0) ? '<span class="badge bg-warning">Pending</span>' : '<span class="badge bg-success">Di Setujui</span>'; ?></p>

                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- ROW -->

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
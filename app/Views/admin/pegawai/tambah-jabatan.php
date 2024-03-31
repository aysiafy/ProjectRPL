<?= $this->extend('layout/admin'); ?>
<?= $this->section('content'); ?>
<?= $this->include('layout/sidebar-admin'); ?>
<!-- *************
				************ Main container start *************
			************* -->
<div class="main-container">

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
            <!-- Row start -->
            <!-- Row start -->
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <script src="https://kit.fontawesome.com/42fc19a824.js" crossorigin="anonymous"></script>
                        <div class="card-header" style="padding:0.50rem 1.25rem 0 1.25rem">
                            <div class="d-flex justify-content-start w-100">
                                <a href="<?= base_url('admin/jabatan'); ?>" class="btn btn-info" style="display: block; text-align: left; margin: 0; padding: 10px; background-color: transparent; border: none; color: #3468C0; "><i class="fa-solid fa-chevron-left"></i><span style="margin-left: 20px">Kembali</span></a>
                            </div>
                        </div>
                        <div class="card-header" style="padding:0.25rem 1.25rem 0 1.25rem">
                            <div class="card-title">Form Jabatan</div>
                            <div class="d-flex justify-content-end">
                                <a href="javascript:void(0);" class="btn btn-primary tambah-baris">Tambah Baris</a>
                            </div>
                        </div>
                        <div class="card-body">

                            <form action="<?= base_url('admin/tambah_jabatan_'); ?>" method="post">
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="font-size: 13px;">
                                        <thead>
                                            <tr>
                                                <td>Jabatan</td>
                                                <td>Aksi</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="text" name="nama_jabatan[]" style="width: 100%; outline: none; border: none;"></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <button class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
            <!-- Row end -->
            <!-- Row end -->

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

<script>
    $('.tambah-baris').click(function() {
        var html = `
        <tr>
            <td><input type="text" name="nama_jabatan[]" style="width: 100%; outline: none; border: none;"></td>
            <td>
                <a href="javascript:void(0);" class="badge bg-danger">
                    Hapus
                </a>
            </td>
        </tr>
       `;

        $('tbody').append(html);
    });

    $('tbody').on('click', 'tr td a', function() {
        $(this).parents('tr').remove();
    });
</script>
<?= $this->endSection(); ?>
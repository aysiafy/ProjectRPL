<?php

namespace App\Controllers;

use App\Models\JabatanModel;
use App\Models\PegawaiModel;
use App\Models\PengaturanModel;
use App\Models\AbsenModel;
use App\Models\AbsenDetailModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Pegawai extends BaseController
{
    protected $JabatanModel;
    protected $PegawaiModel;
    protected $PengaturanModel;
    protected $AbsenModel;
    protected $AbsenDetailModel;

    public function __construct()
    {

        $this->JabatanModel = new JabatanModel();
        $this->PegawaiModel = new PegawaiModel();
        $this->PengaturanModel = new PengaturanModel();
        $this->AbsenModel = new AbsenModel();
        $this->AbsenDetailModel = new AbsenDetailModel();
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        if (session()->get('role') != 2) {
            return redirect()->to('auth');
        }
        $data['menu'] = [
            'tab_home' => 'show active',
            'dashboard' => 'current-page',
            'absensi' => ''
        ];

        // Plugin Tambahan
        $data['plugin'] = '
            
        ';

        $data['judul_halaman'] = 'Dashboard Pegawai | Presensi By Abduloh Malela';
        $data['judul_sidebar'] = 'Dashboard';

        $data['pegawai'] = $this->PegawaiModel->getByEmail(session()->get('email'));
        $data['pengaturan'] = $this->PengaturanModel->asObject()->first();
        $data['absensi'] = $this->AbsenModel->getByTanggal(date('d-M-Y', time()));
        // dd($data['absensi']);

        return view('pegawai/dashboard', $data);
    }
    public function profile()
    {
        if (session()->get('role') != 2) {
            return redirect()->to('auth');
        }
        $data['menu'] = [
            'tab_home' => 'show active',
            'dashboard' => 'current-page',
            'absensi' => ''
        ];

        // Plugin Tambahan
        $data['plugin'] = '
            
        ';

        $data['judul_halaman'] = 'Dashboard Pegawai | Presensi By Abduloh Malela';
        $data['judul_sidebar'] = 'Dashboard';

        $data['pegawai'] = $this->PegawaiModel->getByEmail(session()->get('email'));
        $data['pengaturan'] = $this->PengaturanModel->asObject()->first();
        $data['absensi'] = $this->AbsenModel->getByTanggal(date('d-M-Y', time()));
        // dd($data['absensi']);

        return view('pegawai/profile', $data);
    }
    public function profile_()
    {
        $fileGambar = $this->request->getFile('gambar');

        // Cek Gambar, Apakah Tetap Gambar lama
        if ($fileGambar->getError() == 4) {
            $nama_gambar = $this->request->getVar('gambar_lama');
        } else {
            // Generate nama file Random
            $nama_gambar = $fileGambar->getRandomName();
            // Upload Gambar

            $fileGambar->move('assets/img/pegawai', $nama_gambar);
            if ($this->request->getVar('gambar_lama') != 'default.jpg') {
                unlink('assets/img/pegawai/' . $this->request->getVar('gambar_lama'));
            }
        }

        $this->PegawaiModel
            ->set('nama_pegawai', $this->request->getVar('nama'))
            ->set('gambar', $nama_gambar)
            ->where('id_pegawai', session()->get('id_pegawai'))
            ->update();

        session()->setFlashdata('pesan', "
            <script>
                Swal.fire(
                    'Berhasil!',
                    'Profile Updated!',
                    'success'
                )
            </script>
        ");

        return redirect()->to('pegawai/profile');
    }
    public function password()
    {
        $pegawai = $this->PegawaiModel->asObject()->find(session()->get('id_pegawai'));

        $current_password = $this->request->getVar('current_password');
        $new_password = $this->request->getVar('new_password');

        if ($current_password != $pegawai->password) {
            session()->setFlashdata('pesan', "
                <script>
                    Swal.fire(
                        'Error!',
                        'Current Password salah!',
                        'error'
                    )
                </script>
            ");

            return redirect()->to('pegawai/profile');
        }

        $this->PegawaiModel
            ->set('password', $new_password)
            ->where('id_pegawai', session()->get('id_pegawai'))
            ->update();

        session()->setFlashdata('pesan', "
            <script>
                Swal.fire(
                    'Berhasil!',
                    'Password Terupdate!',
                    'success'
                )
            </script>
        ");

        return redirect()->to('pegawai/profile');
    }

    // START::ABSENSI
    public function absensi()
    {
        if (session()->get('role') != 2) {
            return redirect()->to('auth');
        }
        $data['menu'] = [
            'tab_home' => 'show active',
            'dashboard' => '',
            'absensi' => 'current-page'
        ];

        // Plugin Tambahan
        $data['plugin'] = '
            <link rel="stylesheet" href="' . base_url('assets/template/presensi-abdul') . '/vendor/datatables/dataTables.bs4.css" />
            <link rel="stylesheet" href="' . base_url('assets/template/presensi-abdul') . '/vendor/datatables/dataTables.bs4-custom.css" />
            <link href="' . base_url('assets/template/presensi-abdul') . '/vendor/datatables/buttons.bs.css" rel="stylesheet" />
            <script src="' . base_url('assets/template/presensi-abdul') . '/vendor/datatables/dataTables.min.js"></script>
            <script src="' . base_url('assets/template/presensi-abdul') . '/vendor/datatables/dataTables.bootstrap.min.js"></script>
            <script src="' . base_url('assets/template/presensi-abdul') . '/vendor/datatables/custom/custom-datatables.js"></script>
            <script src="' . base_url('assets/template/presensi-abdul') . '/vendor/datatables/buttons.min.js"></script>
            <script src="' . base_url('assets/template/presensi-abdul') . '/vendor/datatables/jszip.min.js"></script>
            <script src="' . base_url('assets/template/presensi-abdul') . '/vendor/datatables/pdfmake.min.js"></script>
            <script src="' . base_url('assets/template/presensi-abdul') . '/vendor/datatables/vfs_fonts.js"></script>
            <script src="' . base_url('assets/template/presensi-abdul') . '/vendor/datatables/html5.min.js"></script>
            <script src="' . base_url('assets/template/presensi-abdul') . '/vendor/datatables/buttons.print.min.js"></script>	
        ';

        $data['judul_halaman'] = 'Absensi | Presensi By Abduloh Malela';
        $data['judul_sidebar'] = 'Dashboard';

        $data['pegawai'] = $this->PegawaiModel->getByEmail(session()->get('email'));
        $data['absensi'] = $this->AbsenModel->getByTanggal(date('d-M-Y', time()));
        $data['riwayat_absensi'] = $this->AbsenDetailModel->riwayatAbsen(session('id_pegawai'));

        return view('pegawai/data-absen', $data);
    }
    public function absen($kode_absen)
    {
        if (session()->get('role') != 2) {
            return redirect()->to('auth');
        }
        $data['menu'] = [
            'tab_home' => 'show active',
            'dashboard' => '',
            'absensi' => 'current-page'
        ];

        // Plugin Tambahan
        $data['plugin'] = '
            <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>	
        ';

        $data['judul_halaman'] = 'Isi Absen | Presensi By Abduloh Malela';
        $data['judul_sidebar'] = 'Dashboard';

        $data['pegawai'] = $this->PegawaiModel->getByEmail(session()->get('email'));
        $data['absensi'] = $this->AbsenDetailModel->getByKodeAndIdPegawai($kode_absen, session()->get('id_pegawai'));
        $data['pengaturan'] = $this->PengaturanModel->asObject()->first();

        return view('pegawai/isi-absen', $data);
    }
    public function absen_masuk()
    {
        $kode_absensi = $this->request->getVar('kode_absensi');
        $absensi = $this->AbsenModel->getByKode($kode_absensi);
        $pengaturan_absen = $this->PengaturanModel->asObject()->first();
        $latitude = $this->request->getVar('latitude');
        $longitude = $this->request->getVar('longitude');
        $image_tag = $this->request->getVar('image_tag');
        $waktu_absen = date('H:i', time());

        if ($kode_absensi == null || $latitude == null || $longitude == null || $image_tag == null) {
            session()->setFlashdata('jarak', '
                <div class="alert alert-danger" role="alert">
                    Semua data harus dilengkapi. pastikan izin lokasi sudah di aktifkan
                </div>
            ');
            return redirect()->to('pegawai/absen' . '/' . $kode_absensi);
        }

        function distance($lat1, $lon1, $lat2, $lon2, $unit)
        {
            if (($lat1 == $lat2) && ($lon1 == $lon2)) {
                return 0;
            } else {
                $theta = $lon1 - $lon2;
                $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = $dist * 60 * 1.1515;
                $unit = strtoupper($unit);

                if ($unit == "K") {
                    return ($miles * 1.609344);
                } else if ($unit == "N") {
                    return ($miles * 0.8684);
                } else {
                    return $miles;
                }
            }
        }
        $jarak_belum_bulat =  (distance($pengaturan_absen->latitude, $pengaturan_absen->longitude, $latitude, $longitude, "K") * 1000);
        $jarak = ceil($jarak_belum_bulat);

        if ($pengaturan_absen->batas_jarak < $jarak) {
            session()->setFlashdata('jarak', '
                <div class="alert alert-danger" role="alert">
                    Jarak Kamu dari lokasi kantor adalah <strong>' . $jarak . '</strong> Meter, melebihi aturan batas jarak. Batas jarak yg di tetapkan adalah <strong>' . $pengaturan_absen->batas_jarak . '</strong> Meter
                </div>
            ');
            return redirect()->to('pegawai/absen' . '/' . $kode_absensi);
        }

        // echo "Jarak Saya dengan Kantor adalah $jarak M, Batas Jarak yg di tetapkan adalah $pengaturan_absen->batas_jarak M";

        // CEK APAKAH DIA TERLAMBAT
        if (strtotime($waktu_absen) > strtotime($pengaturan_absen->jam_masuk)) {
            $terlambat = 1; // 1 Berarti Telambat
        } else {
            $terlambat = 0; // 0 Berarti tidak terlambat
        }

        //UPLOAD-GAMBAR
        $img = str_replace('data:image/png;base64,', '', $image_tag);
        $img = base64_decode($img, true);
        $filename = random_string('alnum', 15) . '.png';
        file_put_contents(FCPATH . '/assets/img/pegawai/' . $filename, $img);

        $this->AbsenDetailModel
            ->set('absen_masuk', time())
            ->set('status_masuk', $terlambat)
            ->set('latitude_masuk', $latitude)
            ->set('longitude_masuk', $longitude)
            ->set('bukti_masuk', $filename)
            ->where('kode_absensi', $kode_absensi)
            ->where('pegawai', session()->get('id_pegawai'))
            ->update();

        $jumlah_masuk = ($absensi->jumlah_absen_masuk + 1);
        $jumlah_pegawai = ($absensi->total_pegawai + 1);
        $this->AbsenModel
            ->set('jumlah_absen_masuk', $jumlah_masuk)
            ->set('total_pegawai', $jumlah_pegawai)
            ->where('kode_absensi', $kode_absensi)
            ->update();

        session()->setFlashdata('pesan', "
            <script>
                Swal.fire(
                    'Berhasil!',
                    'Absen Masuk Berhasil!',
                    'success'
                )
            </script>
        ");

        return redirect()->to('pegawai/absensi');
    }
    public function absen_pulang()
    {
        $kode_absensi = $this->request->getVar('kode_absensi');
        $absensi = $this->AbsenModel->getByKode($kode_absensi);
        $pengaturan_absen = $this->PengaturanModel->asObject()->first();
        $latitude = $this->request->getVar('latitude');
        $longitude = $this->request->getVar('longitude');
        $image_tag = $this->request->getVar('image_tag');
        $waktu_absen = date('H:i', time());

        if ($kode_absensi == null || $latitude == null || $longitude == null || $image_tag == null) {
            session()->setFlashdata('jarak', '
                <div class="alert alert-danger" role="alert">
                    Semua data harus dilengkapi. pastikan izin lokasi sudah di aktifkan
                </div>
            ');
            return redirect()->to('pegawai/absen' . '/' . $kode_absensi);
        }

        function distance2($lat1, $lon1, $lat2, $lon2, $unit)
        {
            if (($lat1 == $lat2) && ($lon1 == $lon2)) {
                return 0;
            } else {
                $theta = $lon1 - $lon2;
                $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = $dist * 60 * 1.1515;
                $unit = strtoupper($unit);

                if ($unit == "K") {
                    return ($miles * 1.609344);
                } else if ($unit == "N") {
                    return ($miles * 0.8684);
                } else {
                    return $miles;
                }
            }
        }
        $jarak_belum_bulat =  (distance2($pengaturan_absen->latitude, $pengaturan_absen->longitude, $latitude, $longitude, "K") * 1000);
        $jarak = ceil($jarak_belum_bulat);

        if ($pengaturan_absen->batas_jarak < $jarak) {
            session()->setFlashdata('jarak', '
                <div class="alert alert-danger" role="alert">
                    Jarak Kamu dari lokasi kantor adalah <strong>' . $jarak . '</strong> Meter, melebihi aturan batas jarak. Batas jarak yg di tetapkan adalah <strong>' . $pengaturan_absen->batas_jarak . '</strong> Meter
                </div>
            ');
            return redirect()->to('pegawai/absen' . '/' . $kode_absensi);
        }

        // echo "Jarak Saya dengan Kantor adalah $jarak M, Batas Jarak yg di tetapkan adalah $pengaturan_absen->batas_jarak M";

        //UPLOAD-GAMBAR
        $img = str_replace('data:image/png;base64,', '', $image_tag);
        $img = base64_decode($img, true);
        $filename = random_string('alnum', 15) . '.png';
        file_put_contents(FCPATH . '/assets/img/pegawai/' . $filename, $img);

        $this->AbsenDetailModel
            ->set('absen_keluar', time())
            ->set('latitude_keluar', $latitude)
            ->set('longitude_keluar', $longitude)
            ->set('bukti_keluar', $filename)
            ->where('kode_absensi', $kode_absensi)
            ->where('pegawai', session()->get('id_pegawai'))
            ->update();

        $jumlah_keluar = ($absensi->jumlah_absen_keluar + 1);
        $this->AbsenModel
            ->set('jumlah_absen_keluar', $jumlah_keluar)
            ->where('kode_absensi', $kode_absensi)
            ->update();

        session()->setFlashdata('pesan', "
            <script>
                Swal.fire(
                    'Berhasil!',
                    'Absen Pulang Berhasil!',
                    'success'
                )
            </script>
        ");

        return redirect()->to('pegawai/absensi');
    }
    public function izin_absen($kode_absen)
    {
        if (session()->get('role') != 2) {
            return redirect()->to('auth');
        }
        $data['menu'] = [
            'tab_home' => 'show active',
            'dashboard' => '',
            'absensi' => 'current-page'
        ];

        // Plugin Tambahan
        $data['plugin'] = '
            
        ';

        $data['judul_halaman'] = 'Izin Absen | Presensi By Abduloh Malela';
        $data['judul_sidebar'] = 'Dashboard';

        $data['pegawai'] = $this->PegawaiModel->getByEmail(session()->get('email'));
        $data['detail_absensi'] = $this->AbsenDetailModel->getByKodeAndIdPegawai($kode_absen, session()->get('id_pegawai'));
        $data['pengaturan'] = $this->PengaturanModel->asObject()->first();

        return view('pegawai/detail-izin', $data);
    }
    public function izin()
    {
        $pengaturan_absen = $this->PengaturanModel->asObject()->first();
        $absensi = $this->AbsenModel->getByKode($this->request->getVar('kode_absen'));

        $file_izin = $this->request->getFile('bukti_izin');
        // dd($file_izin);
        // Generate nama file Random
        $bukti = $file_izin->getRandomName();
        // Upload Gambar
        $file_izin->move('assets/img/pegawai', $bukti);

        $this->AbsenDetailModel
            ->set('izin', 1)
            ->set('status_izin', 0)
            ->set('alasan', $this->request->getVar('alasan'))
            ->set('bukti_izin', $bukti)
            ->where('kode_absensi', $this->request->getVar('kode_absen'))
            ->where('pegawai', session()->get('id_pegawai'))
            ->update();

        $jumlah_izin = ($absensi->jumlah_izin + 1);
        $jumlah_pegawai = ($absensi->total_pegawai + 1);
        $this->AbsenModel
            ->set('jumlah_izin', $jumlah_izin)
            ->set('total_pegawai', $jumlah_pegawai)
            ->where('kode_absensi', $this->request->getVar('kode_absen'))
            ->update();

        session()->setFlashdata('pesan', "
            <script>
                Swal.fire(
                    'Berhasil!',
                    'Permintaan Izin Dikirim!',
                    'success'
                )
            </script>
        ");

        return redirect()->to('pegawai/izin_absen' . '/' . $this->request->getVar('kode_absen'));
    }
    public function download_izin($bukti_izin)
    {
        return $this->response->download('assets/img/pegawai/' . $bukti_izin, null);
    }
    public function detail_absen($kode_absen)
    {
        if (session()->get('role') != 2) {
            return redirect()->to('auth');
        }
        $data['menu'] = [
            'tab_home' => 'show active',
            'dashboard' => '',
            'absensi' => 'current-page'
        ];

        // Plugin Tambahan
        $data['plugin'] = '';

        $data['judul_halaman'] = 'Detail Absen | Presensi By Abduloh Malela';
        $data['judul_sidebar'] = 'Dashboard';

        $data['pegawai'] = $this->PegawaiModel->getByEmail(session()->get('email'));
        $data['detail_absen'] = $this->AbsenDetailModel->getByKodeAndIdPegawai($kode_absen, session()->get('id_pegawai'));
        $data['pengaturan'] = $this->PengaturanModel->asObject()->first();

        return view('pegawai/detail_absen', $data);
    }
    // END::ABSENSI
}

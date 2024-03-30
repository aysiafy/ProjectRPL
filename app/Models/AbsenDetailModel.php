<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsenDetailModel extends Model
{
    protected $table            = 'detail_absensi';
    protected $primaryKey       = 'id_detail_absensi';
    protected $protectFields    = true;
    protected $allowedFields    = ['kode_absensi', 'pegawai', 'absen_masuk', 'status_masuk', 'latitude_masuk', 'longitude_masuk', 'absen_keluar', 'status_keluar', 'latitude_keluar', 'longitude_keluar', 'izin', 'status_izin', 'alasan', 'bukti_izin', 'bukti_masuk', 'bukti_keluar'];

    public function getAllByKodeAbsen($kode_absen)
    {
        return $this
            ->join('pegawai', 'pegawai.id_pegawai=detail_absensi.pegawai')
            ->where('detail_absensi.kode_absensi', $kode_absen)
            ->get()->getResultObject();
    }

    public function riwayatAbsen($id_pegawai)
    {
        return $this
            ->join('pegawai', 'pegawai.id_pegawai=detail_absensi.pegawai')
            ->join('absensi', 'absensi.kode_absensi=detail_absensi.kode_absensi')
            ->where('detail_absensi.pegawai', $id_pegawai)
            ->orderBy('detail_absensi.id_detail_absensi', 'DESC')
            ->get()->getResultObject();
    }

    public function getByKodeAndIdPegawai($kode_absen, $id_pegawai)
    {
        return $this
            ->join('pegawai', 'pegawai.id_pegawai=detail_absensi.pegawai')
            ->join('absensi', 'absensi.kode_absensi=detail_absensi.kode_absensi')
            ->where('detail_absensi.kode_absensi', $kode_absen)
            ->where('detail_absensi.pegawai', $id_pegawai)
            ->get()->getRowObject();
    }

    // public function jumlah_masuk($kode_absen)
    // {
    //     return $this
    //         ->where('kode_absensi', $kode_absen)
    //         ->where('absen_masuk !=', null)
    //         ->get()->getResultObject();
    // }

    // public function jumlah_keluar($kode_absen)
    // {
    //     return $this
    //         ->where('kode_absensi', $kode_absen)
    //         ->where('absen_keluar !=', null)
    //         ->get()->getResultObject();
    // }

    // public function jumlah_keluar($kode_absen)
    // {
    //     return $this
    //         ->where('kode_absensi', $kode_absen)
    //         ->where('absen_keluar !=', null)
    //         ->get()->getResultObject();
    // }
}

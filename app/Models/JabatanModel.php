<?php

namespace App\Models;

use CodeIgniter\Model;

class JabatanModel extends Model
{
    protected $table            = 'jabatan';
    protected $primaryKey       = 'id_jabatan';
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_jabatan'];

    public function getJumlahPegawaiPerJabatan($id_jabatan) {
        $builder = $this->db->table('pegawai'); 
        $builder->where('jabatan', $id_jabatan); 
        $builder->select('COUNT(*) as jumlah');
        $query = $builder->get();
        return $query->getRow()->jumlah; // Get the count of employees and return it
    }
}

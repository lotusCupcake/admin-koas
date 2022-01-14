<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table = 'absensi';
    protected $primaryKey = 'absensiId';
    protected $allowedFields = ['absensiNim', 'absensiTanggal', 'absensiKeterangan', 'absensiLatLong', 'absensiLokasi'];
    protected $returnType = 'object';

    public function absensiPaginate(int $nb_page, $group)
    {

        // $builder = $this->select();
        // $builder = $this->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = absensi.absensiNim', 'LEFT');
        // $builder = $this->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder = $this->db->query('CALL Absensi');
        $builder = $this->paginate($nb_page, $group);
        $absensi = $builder;
        return $absensi;
    }
}

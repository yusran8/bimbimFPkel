<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple;

Class Ambil extends Model{
    public $id;
    public $siswa;
    public $kelas_id;
    public $mapel;
    public $ruang;
    public $waktu;
    public $pengajar;

    // public function initialize(){
    //     $this->belongsTo(
    //         'siswa',
    //         'Users',
    //         'id'
    //     );

    //     $this->belongsTo(
    //         'kelas',
    //         'Kelas',
    //         'id'
    //     );
    // }

    public function setSiswa($params){
        $this->siswa = $params;

        return $this;
    }

    public function setKelas($params){
        $this->kelas_id = $params;

        return $this;
    }

    public function setMapel($params){
        $this->mapel = $params;

        return $this;
    }

    public function setPengajar($params){
        $this->pengajar = $params;

        return $this;
    }

    public function setRuang($params){
        $this->ruang = $params;

        return $this;
    }

    public function setWaktu($params){
        $this->waktu = $params;

        return $this;
    }

}
<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
use Phalcon\Mvc\Model\Relation;

class Kelas extends Model
{
    public $id;
    public $mapel;
    public $pengajar;
    public $ruang;
    public $waktu;

    public function initialize(){
        $this->hasMany(
            'id',
            Ambil::class,
            'kelas',
            // [
            //     'foreignKey' => [
            //         'action' => Relation::ACTION_CASCADE,
            //     ]
            // ]
            
        );
    }
    
    public static function findKelasByMapel(string $params)
    {
        $sql = 'SELECT * FROM Kelas WHERE mapel = ' . $params;
        $kelas = new Kelas();

        return new Resultset(
            null,
            $kelas,
            $kelas->getReadConnection()->query($sql)
        );
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
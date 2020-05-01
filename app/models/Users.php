<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness as Uniqueness;

class Users extends Model
{
    public $id;
    public $name;
    public $password;
    public $role;
    public $active;
    public $created;
    public $updated;

    public function initialize(){
        $this->hasMany(
            'id',
            'Ambil',
            'siswa'
        );
    }

    public function setPassword($params){
        $this->password = $params;

        return $this;
    }

    public function setName($params){
        $this->name = $params;

        return $this;
    }

    public function setId($params){
        $this->id = $params;

        return $this;
    }

    public function setActive(int $params){
        $this->active = $params;

        return $this;
    }

    public function setRole($params){
        $this->role = $params;

        return $this;
    }

    public function setCreated($params){
        $this->created = $params;

        return $this;
    }

    public function setUpdated($params){
        $this->updated = $params;

        return $this;
    }

    public function getId(){
        return $this->id;
    }

    
    public function getName(){
        return $this->name;
    }
    
    public function getPassword(){
        return $this->password;
    }
    
    public function getRole(){
        return $this->role;
    }
    
    public function getActive(){
        return $this->active;
    }

    public function getUpdated(){
        return $this->updated;
    }

    
    public function getcreated(){
        return $this->created;
    }


    // public function validation(){
    //     $validator = new Validation();
    //     $validator->add(
    //         'id',
    //         new Uniqueness(
    //             [
    //                 'model' => $this,
    //                 'message' => 'ID exists',
    //                 'cancelOnFail' => true,
    //             ]
    //         )
    //     );

    //     return $this->validate($validator);

    // }

    // public function initialize(){
    //     //$this->setSchema("PBKKdb");
    //     $this->setSource("users");
    // }

    // // public function getSource(){
    // //     return 'users';
    // // }

    public function columnMap(){
        return [
            'id' => 'id',
            'name' => 'name',
            'password' => 'password',
            'active' => 'active',
            'role' => 'role',
            'created' => 'created',
            'updated' => 'updated'

        ];
    }
}
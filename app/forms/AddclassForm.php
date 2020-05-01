<?php
namespace App\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
// Validation
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Forms\Element\Date;

class AddclassForm extends Form
{
    public function initialize($entity = null, $options = [])
    {

        if (isset($options['edit'])) {
            $id = new Hidden("id", [
                'required' => true,
            ]);
            $this->add($id);
        
        }
        /**
         * Name
         */
        $mapel = new Text('mapel', [
            "class" => "form-control",
            "required" => true,
            "placeholder" => "Enter Mata Pelajaran"
        ]);

        // form name field validation
        $mapel->addValidator(
            new PresenceOf(['message' => 'Mata Pelajaran is required'])
        );

        $ruang = new Text('ruang', [
            "class" => "form-control",
            "required" => true,
            "placeholder" => "Enter ruang"
        ]);

        $ruang->addValidator(
            new PresenceOf(['message' => 'Ruangan is required'])
        );

        $waktu = new Date('waktu', [
            "class" => "form-control",
            "required" => true,
        ]);


        /**
         * Submit Button
         */
        $submit = new Submit('submit', [
            "value" => "Tambahkan Kelas",
            "class" => "btn btn-primary",
        ]);

        
        $this->add($mapel);
        $this->add($ruang);
        $this->add($waktu);
        $this->add($submit);
    }
}
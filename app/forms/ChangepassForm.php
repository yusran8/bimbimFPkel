<?php
namespace App\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
// Validation
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\Email;

class ChangepassForm extends Form
{
    public function initialize()
    {
        /**
         * Name
         */
        // $name = new Text('name', [
        //     "class" => "form-control",
        //     "required" => true,
        //     "placeholder" => "Enter Full Name"
        // ]);

        // // form name field validation
        // $name->addValidator(
        //     new PresenceOf(['message' => 'The name is required'])
        // );

        // $role = new Text('role', [
        //     "class" => "form-control",
        //     "required" => true,
        //     "placeholder" => "Enter role"
        // ]);

        // $role->addValidator(
        //     new PresenceOf(['message' => 'The role is required'])
        // );

        // $id = new Text('id', [
        //     "class" => "form-control",
        //     "required" => true,
        //     "placeholder" => "Enter Student ID"
        // ]);

        // // form email field validation
        // $id->addValidators([
        //     new PresenceOf(['message' => 'The Student ID is required']),
        // ]);

        /**
         * New Password
         */
        $password = new Password('password', [
            "class" => "form-control",
            "required" => true,
            "placeholder" => "Your Password"
        ]);

        $password->addValidators([
            new PresenceOf(['message' => 'Password is required']),
            new StringLength(['min' => 5, 'message' => 'Password is too short. Minimum 5 characters.']),
            new Confirmation(['with' => 'password_confirm', 'message' => 'Password doesn\'t match confirmation.']),
        ]);


        /**
         * Confirm Password
         */
        $passwordNewConfirm = new Password('password_confirm', [
            "class" => "form-control",
            "required" => true,
            "placeholder" => "Confirm Password"
        ]);

        $passwordNewConfirm->addValidators([
            new PresenceOf(['message' => 'The confirmation password is required']),
        ]);


        /**
         * Submit Button
         */
        $submit = new Submit('submit', [
            "value" => "Submit",
            "class" => "btn btn-primary",
        ]);

        // $this->add($name);
        // $this->add($id);
        // $this->add($role);
        $this->add($password);
        $this->add($passwordNewConfirm);
        $this->add($submit);
    }
}
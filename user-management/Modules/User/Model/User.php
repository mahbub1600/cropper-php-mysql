<?php
namespace User\Model;

use MyFramework\DB\Model;

class User extends Model{
    public $id;
    public $name;
    public $fatherName;
    public $motherName;
    public $dob;
    public $photo;
    public $mobile;
    public $address;
    public $created;
    public $updated;

}
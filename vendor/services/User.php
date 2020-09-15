<?php

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    include_once("microdb/src/" . $class . '.php');
});

use MicroDB\Database;
use MicroDB\Index;


class User 
{

    protected $db;

    protected $usernameIndex;


    function __construct()
    {
        // Create database
        $this->db = new \MicroDB\Database('data/users');

        // Create index
        $this->usernameIndex = new \MicroDB\Index($this->db, 'username', 'username');
    }


    function create($user)
    {
        $id = $this->db->create(array(
            'username'  => $user['username'],
            'email'     => $user['email'],
            'password'  => $user['password'],
            'phone'     => $user['phone_number']
        ));

        return $id;
    }


    function retrieve($user)
    {
        $to_user = $this->usernameIndex->first($user);

        return $to_user;
    }


    function validate($user)
    {
        $to_user = $this->db->first(array('username' => $user));

        return $to_user;
    }

    
}

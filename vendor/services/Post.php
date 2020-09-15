<?php

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    include_once("microdb/src/" . $class . '.php');
});

use MicroDB\Database;
use MicroDB\Index;

class Post 
{

    protected $db;


    function __construct()
    {
        // Create database
        $this->db = new \MicroDB\Database('data/posts');
    }


    function create($post)
    {
        $id = $this->db->create(array(
            'username'  => $post['username'],
            'message'   => $post['message'],
            'date'      => date("Y-m-d"),
        ));

        return $id;
    }


    function get($q)
    {
        $posts = $this->db->find(array('username' => $q));

        return $posts;
    }





    
}

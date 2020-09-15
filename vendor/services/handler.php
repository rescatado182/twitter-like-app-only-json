<?php

include_once('User.php');
include_once('Post.php');

class Validation 
{

    // Does string contain letters?
    function _has_letters( $string ) {
        return preg_match( '/[a-zA-Z]/', $string );
    }

    // Does string contain numbers?
    function _has_numbers( $string ) {
        return preg_match( '/\d/', $string );
    }

    // Does string contain special characters?
    function _has_special_chars( $string ) {
        return preg_match('/[^a-zA-Z\d]/', $string);
    }


    function check_username( $string ) {
        return preg_match('/[a-z]{4,}[0-9]{2,}|[0-9]{2,}$/', $string);
    }

    function valid_email($string) {
        return preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $string);
    }

    function valid_phone_number($string) {
        return preg_match('/^[0-9]{10,}$/', $string);
    }


    function valid_password($string) {
        return preg_match('/^([A-Z][a-z A-Z0-9\_]{6,})+$/', $string);
    }
}


if( isset($_POST['action']) )
{

    $validation = new Validation();
    $msg_validation = "";
    
    /**
     * Record an user
     */
    if( $_POST['action'] == 'signup' ) 
    {
        if( isset($_POST['username']) && $validation->_has_special_chars($_POST['username']) ) {
            $msg_validation .= "The username can't contains special characters. <br />";
        }

        elseif( isset($_POST['username']) && !$validation->check_username($_POST['username']) ) {
            $msg_validation .= "The username must has at least 4 letters and 2 numbers. <br />";
        }

        if( isset($_POST['email']) && !$validation->valid_email($_POST['email']) ) {
            $msg_validation .= "The email is not valid. <br />";
        }

        if( isset($_POST['phone_number']) && !$validation->valid_phone_number($_POST['phone_number']) ) {
            $msg_validation .= "The Phone Number is not valid. <br />";
        }

        if( isset($_POST['password']) && !$validation->valid_password($_POST['password']) ) {
            $msg_validation .= "The Password is not valid, must has at least 6 letters, contains at least one '_', and least one Uppercase letter. <br />";
        }

        /**
         * Validate and create user
         */
        if( !empty($msg_validation) ) 
        {
            echo($msg_validation);
            header( "refresh:5;url=../../signup.html" );
        }
        else 
        {
            $new_user = new User();

            if( $new_user->create($_POST) ) {
                echo "User created";
                header( "refresh:5;url=../../posting.html?username=" . $_POST['username'] );
                //echo '<meta http-equiv="refresh" content="0;url=posting.html">';
            }
        }
    }


    if( $_POST['action'] == 'login' ) 
    {
        $msg_validation .= "";

        if( isset($_POST['username']) && empty($_POST['username']) ) {
            $msg_validation .= "The username can't be empty. <br />";
        }

        elseif( isset($_POST['password']) && empty($_POST['password']) ) {
            $msg_validation .= "The password can't be empty. <br />";
        }


        if( !empty($msg_validation) ) {
            echo $msg_validation;
            header( "refresh:2;url=../../index.html" );
        }
        else 
        {
            $_user = new User();
            $exist_user = $_user->validate($_POST['username']);

            if( $exist_user ) {

                if($exist_user["password"] == $_POST['password'] ) {
                    echo "User found";
                    header( "refresh:2;url=../../posting.html?username=" . $_POST['username'] );
                } 
                else {
                    echo "User and password doesn't match";
                    header( "refresh:2;url=../../index.html" );
                }
            }
        }
    }


    /**
     * Record an user
     */
    if( $_POST['action'] == 'posting' ) 
    {
        $msg_validation = "";

        if( !isset($_POST['username']) ) {
            $msg_validation .= "The username doesn't exists. <br />";
        }

        elseif( !isset($_POST['message']) && !$validation->check_username($_POST['username']) ) {
            $msg_validation .= "The field message can't be empty. <br />";
        }

        /**
         * Validate and create user
         */
        if( !empty($msg_validation) ) 
        {
            echo($msg_validation);
            header( "refresh:5;url=../../posting.html" );
        }
        else 
        {
            $new_post = new Post();

            if( $new_post->create($_POST) ) {
                echo "Post created";
                header( "refresh:2;url=../../posting.html?username=" . $_POST['username'] );
            }
        }
    }
}


if( isset($_GET['action']) && $_GET['action'] == 'posts' ) 
{
    if( isset($_GET['username']) )  
    {
        $post = new Post();

        $posts = $post->get($_GET['username']);

        echo json_encode($posts);
    }


}


?>
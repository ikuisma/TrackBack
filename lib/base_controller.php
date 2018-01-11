<?php

  class BaseController{

    public static function get_user_logged_in(){
        // Toteuta kirjautuneen käyttäjän haku tähän
        if (isset($_SESSION['user'])){
            $musician_id = $_SESSION['user'];
            return Musician::find($musician_id);
        }
        return null;
    }

    public static function check_logged_in(){
        if (!isset($_SESSION['user'])){
            Redirect::to('/', array('message' => 'Please log into the application!'));
        }
    }

  }

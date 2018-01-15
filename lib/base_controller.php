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

    public static function check_user_can_upload() {
        $musician = self::get_user_logged_in();
        if ($musician->hasPermissionToUpload() == false) {
            Redirect::to('/', array('message' => 'You have to give feedback before you can upload again. '));
        }
    }

  }

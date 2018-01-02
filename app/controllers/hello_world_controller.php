<?php

  class HelloWorldController extends BaseController{

    public static function sandbox(){
        // Testaa koodiasi täällä
        $musicians = Musician::all();
        $qsma = Musician::find(1);
        $tags = Tag::all();
        Kint::dump($musicians);
        Kint::dump($qsma);
        Kint::dump($tags);
    }

    public static function login() {
        View::make('suunnitelmat/login.html');
    }

    public static function register() {
        View::make('suunnitelmat/register.html');
    }

    public static function track_list() {
        View::make('suunnitelmat/track_list.html');
    }

    public static function track_add() {
        View::make('/suunnitelmat/track_add.html');
    }

    public static function track_page() {
        View::make('/suunnitelmat/track_page.html');
    }

    public static function track_edit() {
        View::make('/suunnitelmat/track_edit.html');
    }

    public static function feedback_list() {
        View::make('/suunnitelmat/feedback_list.html');
    }

    public static function feedback_page() {
        View::make('/suunnitelmat/feedback_page.html');
    }

    public static function feedback_add() {
        View::make('/suunnitelmat/feedback_add.html');
    }

    public static function feedback_edit() {
        View::make('/suunnitelmat/feedback_edit.html');
    }

    public static function tags() {
        View::make('/suunnitelmat/tag_list.html');
    }

    public static function tag_edit() {
        View::make('/suunnitelmat/tag_edit.html');
    }

  }

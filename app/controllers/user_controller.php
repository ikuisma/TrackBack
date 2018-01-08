<?php

class UserController extends BaseController{

    public static function login(){
        View::make('user/login.html');
    }

    public static function handleLogin(){
        $params = $_POST;
        $musician = Musician::authenticate($params['username'], $params['password']);
        if (!$musician){
            login();
        } else {
            $_SESSION['user'] = $musician->id;
            Redirect::to('/', array('message' => 'Welcome, ' . $musician->username . '!'));
        }
    }

}

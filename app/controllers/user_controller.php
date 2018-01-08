<?php

class UserController extends BaseController{

    public static function login(){
        View::make('user/login.html');
    }

    public static function handleLogin(){
        $params = $_POST;
        UserController::authenticateLogin($params['username'], $params['password']);
    }

    private static function authenticateLogin($username, $password){
        $musician = Musician::authenticate($username, $password);
        if (!$musician){
            $errors = array('Wrong username or password! ');
            View::make('user/login.html', array('errors' => $errors));
        } else {
            $_SESSION['user'] = $musician->id;
            Redirect::to('/', array('message' => 'Welcome, ' . $musician->username . '!'));
        }
    }

    public static function register() {
        View::make('user/register.html');
    }

    public static function handleRegistration() {
        $params = $_POST;
        $musician = new Musician(array(
            'username' => $params['username'],
            'password' => $params['password']
        ));
        $errors = $musician->errors();
        if (count($errors) == 0){
            $musician->save();
            UserController::authenticateLogin($musician->username, $musician->password);
        } else {
            View::make('user/register.html', array('errors' => $errors, 'attributes' => $musician));
        }
    }

}

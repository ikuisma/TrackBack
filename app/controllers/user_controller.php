<?php

class UserController extends BaseController{

    // Renders the login page.
    public static function login(){
        View::make('user/login.html');
    }

    // Handles a login made via a POST request.
    public static function handleLogin(){
        $params = $_POST;
        UserController::authenticateLogin($params['username'], $params['password']);
    }

    // Logs the user in if the given username and password clear out.
    private static function authenticateLogin($username, $password){
        $musician = Musician::authenticate($username, $password);
        if (!$musician){
            $errors = array('Wrong username or password! ');
            View::make('user/login.html', array('errors' => $errors, 'password' => $password, 'username' => $username));
        } else {
            $_SESSION['user'] = $musician->id;
            Redirect::to('/', array('message' => 'Welcome, ' . $musician->username . '!'));
        }
    }

    // Renders the registration page.
    public static function register() {
        View::make('user/register.html');
    }

    // Handles new registrations made via a POST request.
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

    // Logs the user out and redirects to the front page.
    public static function logout() {
        $_SESSION['user'] = null;
        Redirect::to('/', array('message' => 'You have been logged out!'));
    }

}

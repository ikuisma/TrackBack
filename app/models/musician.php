<?php

class Musician extends BaseModel{

    public $id, $username, $password;

    public function __construct($attributes){
        parent::__construct($attributes);
        $this->validators = array('validateUsername');
    }

    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM musician');
        $query->execute();
        $rows = $query->fetchAll();
        $musicians = array();
        foreach($rows as $row) {
            $musicians[] = new Musician(array(
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password']
            ));
        }
        return $musicians;
    }

    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM musician WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if($row){
            return new Musician(array(
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password']
            ));
        }
        return null;
    }

    public static function authenticate($username, $password){
        $query = DB::connection()->prepare('SELECT * FROM musician WHERE username = :username AND password = :password LIMIT 1');
        $query->execute(array('username' => $username, 'password' => $password));
        $row = $query->fetch();
        if($row){
            return new Musician(array(
                'username' => $username,
                'password' => $password
            ));
        }
        return null;
    }

    public static function findByName($username) {
        $query = DB::connection('SELECT * FROM tag WHERE username = :username LIMIT 1');
        $query->execute(array('name' => $username));
        $row = $query->fetch();
        if ($row) {
            return new Musician(array(
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password']
            ));
        }
        return null;
    }

    public static function musicianWithNameExists($name) {
        return (self::findByName($name) != null);
    }

    public function save(){
        $query = DB::connection()->prepare('INSERT INTO musician (username, password) VALUES (:username, :password) RETURNING id');
        $password = password_hash($this->password);
        $query->execute(array('username' => $this->username, 'password' => $password));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function validateUsername() {
        $errors = array();
        if ($this::emptyString($this->name)){
            $errors[] = 'Username can not be an empty string. ';
        }
        if ($this::exceedsLength($this->name, 200)){
            $errors[] = 'Username must be less than 200 characters in length. ';
        }
        if ($this::musicianWithNameExists){
            $errors[] = 'Username already taken. ';
        }
        return $errors;
    }

    public function validatePassword() {
        $errors = array();
        if ($this::emptyString($this->password)) {
            $errors[] = 'Password can not be an empty string.';
        }
        return $errors;
    }

}

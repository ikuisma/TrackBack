<?php

class Musician extends BaseModel{

    public $id, $username, $password;

    public function __construct($attributes){
        parent::__construct($attributes);
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

}

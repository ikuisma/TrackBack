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

}

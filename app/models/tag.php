<?php

class Tag extends BaseModel{

    public $id, $name;

    public function __construct($attributes){
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM tag');
        $query->execute();
        $rows = $query->fetchAll();
        $tags = array();
        foreach($rows as $row){
            $tags[] = new Tag(array(
                'id' => $row['id'],
                'name' => $row['name']
            ));
        }
        return $tags;
    }

    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM tag WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if($row){
            return new Musician(array(
                'id' => $row['id'],
                'name' => $row['name']
            ));
        }
        return null;
    }

}

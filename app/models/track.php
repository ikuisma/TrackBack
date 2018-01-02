<?php

class Track extends BaseModel {

    public $id, $title, $url, $description, $tags;

    public function __construct($attributes){
        parent::__construct($attributes);
    }

    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM track');
        $query->execute();
        $rows = $query->fetchAll();
        $tracks = array();
        foreach($rows as $row){
            $id = $row['id'];
            $tracks[] = new Track(array(
                'id' => $id,
                'title' => $row['title'],
                'url' => $row['url'],
                'description' => $row['description'],
                'tags' => Tag::findForTrack($id)
            ));
        }
        return $tracks;
    }

    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM track WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if($row){
            return new Track(array(
                'id' => $id,
                'title' => $row['title'],
                'url' => $row['url'],
                'description' => $row['description'],
                'tags' => Tag::findForTrack($id)
            ));
        }
        return null;
    }

}

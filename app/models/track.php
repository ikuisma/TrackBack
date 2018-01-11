<?php

class Track extends BaseModel {

    public $id, $title, $url, $description;

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
                'description' => $row['description']
            ));
        }
        return $tracks;
    }

    public function getTags() {
        return Tag::findForTrack($this->id);
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
                'description' => $row['description']
            ));
        }
        return null;
    }

    public static function findForTag($tag_id){
        $query = DB::connection()->prepare('SELECT * FROM track LEFT JOIN tracktag ON track.id = tracktag.track_id WHERE tracktag.tag_id = :tag_id');
        $query->execute(array('tag_id' => $tag_id));
        $rows = $query->fetchAll();
        $tracks = array();
        foreach($rows as $row){
            $id = $row['id'];
            $tracks[] = new Track(array(
                'id' => $id,
                'title' => $row['title'],
                'url' => $row['url'],
                'description' => $row['description']
            ));
        }
        return $tracks;
    }

}

<?php

class Track extends BaseModel {

    public $id, $title, $url, $description, $tag_ids;

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

    private function insertIntoTrack(){
        $statement = 'INSERT INTO track (title, url, description) VALUES (:title, :url, :description) RETURNING id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'title' => $this->title,
            'url' => $this->url,
            'description' => $this->description
            )
        );
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    private function insertIntoTrackTags(){
        if($this->tag_ids){
            $statement = 'INSERT INTO tracktag (track_id, tag_id) VALUES (:track_id, :tag_id)';
            $query = DB::connection()->prepare($statement);
            foreach($this->tag_ids as $tag_id){
                $query->execute(array('track_id' => $this->id, 'tag_id' => $tag_id));
            }
        }
    }

    public function save(){
        $this->insertIntoTrack();
        $this->insertIntoTrackTags();
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

<?php

class Track extends BaseModel {

    public $id, $musician_id, $title, $url, $description, $tag_ids;

    public function __construct($attributes){
        parent::__construct($attributes);
        $this->validators = array('validateTitle', 'validateUrl', 'validateDescription', 'validateMusicianId');
    }

    public static function all(){
        $query = DB::connection()->prepare('SELECT id, title, url FROM track');
        $query->execute();
        $rows = $query->fetchAll();
        $tracks = array();
        foreach($rows as $row){
            $tracks[] = new Track(array(
                'id' => $row['id'],
                'title' => $row['title'],
                'url' => $row['url']
            ));
        }
        return $tracks;
    }

    public function getTags(){
        return Tag::findForTrack($this->id);
    }

    public static function find($id){
        $statement = 'SELECT track.id, track.musician_id, track.title, track.url, track.description, tracktag.tag_id ';
        $statement .= 'FROM track LEFT JOIN tracktag ON track.id = tracktag.track_id ';
        $statement .= 'WHERE track.id = :id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        if($rows){
            $track = self::trackFromRow($rows[0]);
            $tag_ids = array();
            foreach($rows as $row){
                $tag_ids[] = $row['tag_id'];
            }
            $track->tag_ids = $tag_ids;
            return $track;
        }
        return null;
    }

    private function insertIntoTrack(){
        $statement = 'INSERT INTO track (title, url, description, musician_id) VALUES (:title, :url, :description, :musician_id) RETURNING id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'title' => $this->title,
            'musician_id' => $this->musician_id,
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

    public function destroy(){
        $query = DB::connection()->prepare('DELETE FROM track WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    public function update(){
        $this->updateTrackTable();
        $this->deleteTrackTags();
        $this->insertIntoTrackTags();
    }

    private function updateTrackTable(){
        $statement = 'UPDATE track SET title = :title, url = :url, description = :description WHERE id = :id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url
        ));
    }

    private function deleteTrackTags(){
        $dropQuery = DB::connection()->prepare('DELETE FROM tracktag WHERE track_id = :track_id');
        $dropQuery->execute(array("track_id" => $this->id));
    }

    public static function findForTag($tag_id){
        $query = DB::connection()->prepare('SELECT * FROM track LEFT JOIN tracktag ON track.id = tracktag.track_id WHERE tracktag.tag_id = :tag_id');
        $query->execute(array('tag_id' => $tag_id));
        $rows = $query->fetchAll();
        $tracks = array();
        foreach($rows as $row){
            $tracks[] = self::trackFromRow($row);
        }
        return $tracks;
    }

    private static function trackFromRow($row){
        return new Track(array(
            'id' => $row['id'],
            'title' => $row['title'],
            'musician_id' => $row['musician_id'],
            'url' => $row['url'],
            'description' => $row['description']
        ));
    }

    public function validateTitle(){
        $errors = array();
        $title = $this->title;
        if ($this::emptyString($title)){
            $errors[] = 'Track title can not be empty. ';
        }
        if (self::exceedsLength($title, 100)){
            $errors[] = 'Track title must be less than 100 characters long. ';
        }
        return $errors;
    }

    public function validateUrl(){
        $errors = array();
        $url = $this->url;
        if ($this::emptyString($url)){
            $errors[] = 'Track URL can not be empty. ';
        }
        if (self::exceedsLength($url, 100)){
            $errors[] = 'Track URL must be less than 100 characters long. ';
        }
        if (!filter_var($url, FILTER_VALIDATE_URL)){
            $errors[] = 'The track URL is not a valid URL. ';
        }
        return $errors;
    }

    public function validateDescription(){
        $errors = array();
        $description = $this->description;
        if ($this::emptyString($description)){
            $errors[]  = 'Track description can not be empty. ';
        }
        if ($this::exceedsLength($description, 200)){
            $errors[] = 'Track description must be less than 200 characters long. ';
        }
        return $errors;
    }

    public function validateMusicianId(){
        $errors = array();
        $musician_id = $this->musician_id;
        if (Musician::find($musician_id) == null) {
            $errors[] = 'The musician ID can not be found in the database.';
        }
        return $errors;
    }

}

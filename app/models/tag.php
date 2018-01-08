<?php

class Tag extends BaseModel{

    public $id, $name;

    public function __construct($attributes){
        parent::__construct($attributes);
        $this->validators = array('validateName');
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
            return new Tag(array(
                'id' => $row['id'],
                'name' => $row['name']
            ));
        }
        return null;
    }

    public function save(){
        $query = DB::connection()->prepare('INSERT INTO tag (name) VALUES (:name) RETURNING id');
        $query->execute(array('name' => $this->name));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public static function findForTrack($track_id){
        $query = DB::connection()->prepare('SELECT * FROM tag LEFT JOIN tracktag ON tag.id = tracktag.tag_id WHERE tracktag.track_id = :track_id');
        $query->execute(array('track_id' => $track_id));
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

    public static function findWithName($name){
        $query = DB::connection()->prepare('SELECT * FROM tag WHERE name = :name LIMIT 1');
        $query->execute(array('name' => $name));
        $row = $query->fetch();
        if ($row) {
            return new Tag(array(
                'id' => $row['id'],
                'name' => $row['name']
            ));
        }
        return null;
    }

    public function destroy(){
        $query = DB::connection()->prepare('DELETE FROM tag WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    public function update(){
        $query = DB::connection()->prepare('UPDATE tag SET name = :name WHERE id = :id');
        $query->execute(array('id' => $this->id, 'name' => $this->name));
    }

    public static function tagWithNameExists($name) {
        return (self::findWithName($name) != null);
    }

    public function validateName() {
        $errors = array();
        if ($this::emptyString($this->name)){
            $errors[] = 'Tag name can not be an empty string. ';
        }
        if ($this::exceedsLength($this->name,50)){
            $errors[] = 'Tag name must be less than 50 characters long. ';
        }
        if ($this::tagWithNameExists($this->name)){
            $errors[] = 'Tag with name ' . $this->name . ' already exists. ';
        }
        return $errors;
    }

}

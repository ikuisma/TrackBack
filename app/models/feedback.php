<?php

class Feedback extends BaseModel {

    public $id, $musician_id, $track_id, $summary, $description, $track_title;
    const TABLE_NAME = 'feedback';

    public function __construct($attributes){
        parent::__construct($attributes);
    }

    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM ' . self::TABLE_NAME);
        $query->execute();
        $rows = $query->fetchAll();
        $feedback = array();
        foreach($rows as $row){
            $feedback[] = self::feedbackFromRow($row);
        }
        return $feedback;
    }

    public static function receivedFeedbackFor($musicianId) {
        $statement = 'SELECT feedback.id, feedback.musician_id, feedback.track_id, feedback.summary, ';
        $statement .= 'track.title AS track_title ';
        $statement .= 'FROM feedback INNER JOIN track ON feedback.track_id = track.id ';
        $statement .= 'WHERE track.musician_id = :musician_id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('musician_id' => $musicianId));
        $rows = $query->fetchAll();
        $feedback = array();
        foreach($rows as $row){
            $feedback[] = new Feedback($row);
        }
        return $feedback;
    }

    public static function givenFeedbackBy($musicianId) {
        $statement = 'SELECT feedback.id, feedback.musician_id, feedback.track_id, feedback.summary, ';
        $statement .= 'track.title AS track_title ';
        $statement .= 'FROM feedback INNER JOIN track ON feedback.track_id = track.id ';
        $statement .= 'WHERE feedback.musician_id = :musician_id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('musician_id' => $musicianId));
        $rows = $query->fetchAll();
        $feedback = array();
        foreach($rows as $row) {
            $feedback[] = new Feedback($row);
        }
        return $feedback;
    }


    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
            return self::feedbackFromRow($row);
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO ' . self::TABLE_NAME . ' (musician_id, track_id, summary, description) VALUES (:musician_id, :track_id, :summary, :description) RETURNING id');
        $query->execute(array(
            'musician_id' => $this->musician_id,
            'track_id' => $this->track_id,
            'summary' => $this->summary,
            'description' => $this->description
        ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {
        $queryString = 'UPDATE ' . self::TABLE_NAME;
        $queryString .= ' SET description = :description, musician_id = :musician_id, track_id = :track_id, summary = :summary ';
        $queryString .= ' WHERE id = :id';
        $query = DB::connection()->query($queryString);
        $query->execute(array(
            'musician_id' => $this->musician_id,
            'track_id' => $this->track_id,
            'summary' => $this->summary,
            'description' => $this->description
        ));
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM ' . self::TABLE_NAME . ' WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    private static function feedbackFromRow($row) {
        return $feedback[] = new Feedback(array(
            'id' => $row('id'),
            'musician_id' => $row('musician_id'),
            'track_id' => $row('track_id'),
            'summary' => $row('summary'),
            'description' => $row('description')
        ));
    }

}

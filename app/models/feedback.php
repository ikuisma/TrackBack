<?php

class Feedback extends BaseModel {

    public $id, $musician_id, $track_id, $summary, $description, $track_title, $track_url;
    const TABLE_NAME = 'feedback';

    public function __construct($attributes){
        parent::__construct($attributes);
        $this->validators = array('validateDescription', 'validateSummary', 'validateDomainLogic', 'canCreateFeedbackValidation');
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
        $statement .= 'feedback.description, track.title AS track_title ';
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
        $statement .= 'feedback.description, track.title AS track_title ';
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
        $statement = 'SELECT feedback.id, feedback.musician_id, feedback.track_id, feedback.summary, ';
        $statement .= 'feedback.description, track.title as track_title, track.url as track_url ';
        $statement .= 'FROM feedback INNER JOIN track ON feedback.track_id = track.id ';
        $statement .= 'WHERE feedback.id = :id ';
        $statement .= 'LIMIT 1';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
            return new Feedback($row);
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
        $query = DB::connection()->prepare($queryString);
        $query->execute(array(
            'musician_id' => $this->musician_id,
            'track_id' => $this->track_id,
            'summary' => $this->summary,
            'description' => $this->description,
            'id' => $this->id
        ));
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM ' . self::TABLE_NAME . ' WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    public function validateDescription() {
        $description = $this->description;
        $errors = array();
        if (self::emptyString($description)) {
            $errors[] = 'Description can not be an empty string.';
        }
        if (self::exceedsLength($description, 1000)) {
            $errors[] = 'Description can not exceed 1000 characters.';
        }
        return $errors;
    }

    public function validateSummary() {
        $summary = $this->summary;
        $errors = array();
        if (self::emptyString($summary)) {
            $errors[] = 'The feedback summary can not be an empty string. ';
        }
        if (self::exceedsLength($summary, 150)) {
            $errors[] = 'The feedback summary can not exceed 150 characters. ';
        }
        return $errors;
    }

    private function trackCreatorId() {
        return Track::find($this->track_id)->musician_id;
    }

    private static function trackHasSeparateFeedbackFromMusician($track_id, $musician_id) {
        $query = DB::connection()->prepare('SELECT id FROM feedback WHERE track_id = :track_id AND musician_id = :musician_id');
        $query->execute(array('track_id' => $track_id, 'musician_id' => $musician_id));
        $rows = $query->fetchAll();
        return (count($rows) != 0);
    }

    public function canCreateFeedbackValidation() {
        $errors = array();
        if ($this->id != null) {
            // Feedback has already been given, no need to validate.
            return $errors;
        } else {
            if (self::trackHasSeparateFeedbackFromMusician($this->track_id, $this->musician_id)) {
                $errors[] = 'You have already given feedback for this track. ';
            }
            return $errors;
        }
    }

    public function validateDomainLogic() {
        $errors = array();
        if (self::trackCreatorId() == $this->musician_id) {
            $errors[] = 'You can not give feedback for tracks that you have uploaded. ';
        }
        return $errors;
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

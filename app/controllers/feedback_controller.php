<?php

class FeedbackController extends BaseController {

    public static function index() {
        $musician = self::get_user_logged_in();
        $params = array();
        $params['received_feedback'] = Feedback::receivedFeedbackFor($musician->id);
        $params['given_feedback'] = Feedback::givenFeedbackBy($musician->id);
        View::make('/feedback/index.html', $params);
    }

    public static function show($id) {
        $feedback = Feedback::find($id);
        $track = Track::find($feedback->track_id);
        View::make('/feedback/feedback.html', array('feedback' => $feedback, 'track' => $track));
    }

    public static function create($trackid) {
        $track = Track::find($trackid);
        View::make('/feedback/new.html', array('track' => $track));
    }

    public static function store() {
        $attributes = $_POST;
        $musician = self::get_user_logged_in();
        $feedback = new Feedback($attributes);
        $feedback->musician_id = $musician->id;
        $errors = $feedback->errors();
        if (count($errors) == 0) {
            $feedback->save();
            Redirect::to('/', array('message' => 'Your feedback has been added! '));
        } else {
            $track = Track::find($feedback->track_id);
            View::make('/feedback/new.html', array('errors' => $errors, 'attributes' => $attributes, 'track' => $track));
        }
    }

    public static function edit($id) {
        $feedback = Feedback::find($id);
        $track = Track::find($feedback->track_id);
        View::make('/feedback/edit.html', array('attributes' => $feedback, 'track' => $track));
    }

    public static function update($id) {
        $attributes = $_POST;
        $musician = self::get_user_logged_in();
        $feedback = new Feedback($attributes);
        $feedback->id = $id;
        $feedback->musician_id = $musician->id;
        $feedback->track_id = Feedback::find($id)->track_id;
        $errors = $feedback->errors();
        if (count($errors) == 0) {
            $feedback->update();
            Redirect::to('/feedback/'.$id, array('message' => 'Your feedback has been updated! '));
        } else {
            $track = Track::find($feedback->track_id);
            View::make('/feedback/edit.html', array('attributes' => $feedback, 'track' => $track, 'errors' => $errors));
        }
    }

    public static function destroy($id) {
        $feedback = Feedback::find($id);
        $musician = self::get_user_logged_in();
        if ($musician->id != $feedback->musician_id) {
            Redirect::to('/tracks', array('message' => 'You do not have permission to delete feedback that is not your own. '));
        } else {
            $feedback->destroy();
            Redirect::to('/tracks', array('message' => 'Your feedback has been deleted. '));
        }
    }

}

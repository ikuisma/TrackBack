<?php

class FeedbackController extends BaseController {

    public static function index() {
        $musician = self::get_user_logged_in();
        $params = array();
        $params['received_feedback'] = Feedback::receivedFeedbackFor($musician->id);
        $params['given_feedback'] = Feedback::givenFeedbackBy($musician->id);
        View::make('/feedback/index.html', $params);
    }

}

<?php

class TrackController extends BaseController{

    public static function index(){
        $tracks = Track::all();
        View::make('tracks/index.html', array('tracks' => $tracks));
    }

}

<?php

class TrackController extends BaseController{

    public static function index(){
        $tracks = Track::all();
        View::make('tracks/index.html', array('tracks' => $tracks));
    }

    public static function show($id){
        $track = Track::find($id);
        View::make('/tracks/track.html', array('track' => $track));
    }

}

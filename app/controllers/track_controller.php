<?php

class TrackController extends BaseController{

    public static function index(){
        $tracks = Track::all();
        View::make('tracks/index.html', array('tracks' => $tracks));
    }

    public static function create(){
        $tags = Tag::all();
        View::make('tracks/new.html', array('tags' => $tags));
    }

    public static function store(){
        $attributes = self::stripTrackAttributes($_POST);
        $attributes['musician_id'] = self::get_user_logged_in()->id;
        $track = new Track($attributes);
        $track->save();
        Redirect::to('/tracks', array('message' => 'Your track has been added!'));
    }

    public static function show($id){
        $track = Track::find($id);
        View::make('/tracks/track.html', array('track' => $track));
    }

    private static function stripTrackAttributes($params){
        $attributes = array(
            'title' => $params['title'],
            'url' => $params['url'],
            'description' => $params['description']
        );
        if (isset($params['tag_ids'])) {
            $attributes['tag_ids'] = $params['tag_ids'];
        } else {
            $attributes['tag_ids'] = null;
        }
        return $attributes;
    }

}

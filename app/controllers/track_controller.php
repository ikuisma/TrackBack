<?php

class TrackController extends BaseController{

    public static function index(){
        $tracks = Track::all();
        View::make('tracks/index.html', array('tracks' => $tracks));
    }

    public static function create($params=array()){
        $tags = Tag::all();
        $params = array_merge($params, array('tags' => $tags));
        View::make('tracks/new.html', $params);
    }

    public static function store(){
        $attributes = self::stripTrackAttributes($_POST);
        $attributes['musician_id'] = self::get_user_logged_in()->id;
        $track = new Track($attributes);
        $errors = $track->errors();
        if (count($errors) == 0){
            $track->save();
            Redirect::to('/tracks', array('message' => 'Your track has been added!'));
        } else {
            View::make('tracks/new.html', array('errors' => $errors));
        }
    }

    public static function show($id){
        $track = Track::find($id);
        View::make('/tracks/track.html', array('track' => $track));
    }

    public static function destroy($id){
        $tag = new Track(array('id' => $id));
        $tag->destroy();
        Redirect::to('/', array('message' => 'The tag has been deleted'));
    }

    public static function edit($id, $params=array()){
        $track = Track::find($id);
        $tags = Tag::all();
        View::make('tracks/edit.html', array('tags' => $tags, 'attributes' => $track));
    }

    public static function update($id){
        $attributes = self::stripTrackAttributes($_POST);
        $attributes['musician_id'] = self::get_user_logged_in()->id;
        $track = new Track($attributes);
        $track->id = $id;
        $errors = $track->errors();
        if (count($errors) == 0){
            $track->update();
            $path = '/tracks/' . $id;
            Redirect::to($path, array('message' => 'The track has been updated!'));
        } else {
            $tags = Tag::all();
            View::make('tracks/edit.html', array('errors' => $errors, 'attributes' => $track, 'tags' => $tags));
        }
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

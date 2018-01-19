<?php

class TrackController extends BaseController{

    // Renders the track listing page.
    public static function index(){
        $tracks = Track::all();
        View::make('tracks/index.html', array('tracks' => $tracks));
    }

    // Renders the track creation form.
    public static function create($params=array()){
        $tags = Tag::all();
        $params = array_merge($params, array('tags' => $tags));
        View::make('tracks/new.html', $params);
    }

    // Handles new track creation submissions done via a POST request.
    public static function store(){
        $attributes = self::stripTrackAttributes($_POST);
        $attributes['musician_id'] = self::get_user_logged_in()->id;
        $track = new Track($attributes);
        $errors = $track->errors();
        if (count($errors) == 0){
            $track->save();
            Redirect::to('/tracks', array('message' => 'Your track has been added!'));
        } else {
            $tags = Tag::all();
            View::make('tracks/new.html', array('errors' => $errors, 'attributes' => $attributes, 'tags' => $tags));
        }
    }

    // Renders the page for a track with the given id.
    public static function show($id){
        $track = Track::find($id);
        View::make('/tracks/track.html', array('track' => $track));
    }

    // Destroys the track with the given id.
    public static function destroy($id){
        $tag = new Track(array('id' => $id));
        $tag->destroy();
        Redirect::to('/', array('message' => 'The track has been deleted'));
    }

    // Renders the edit page for a track with the given id.
    public static function edit($id){
        $track = Track::find($id);
        $tags = Tag::all();
        View::make('tracks/edit.html', array('tags' => $tags, 'attributes' => $track));
    }

    // Handled updates to a track with the given id done via a POST request.
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

    // Returns key-value pairs of Track-related attributes from the given parameter array.
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

    public static function checkUserOwnsTrack($id) {
        $track = Track::find($id);
        $musician = self::get_user_logged_in();
        if($track->musician_id != $musician->id) {
            Redirect::to('/', array('message' => 'You are not allowed to edit or delete tracks that you have not uploaded. '));
        }
    }

}

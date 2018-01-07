<?php

class TagController extends BaseController{

    public static function index($params=array()){
        $tags = Tag::all();
        $params = array_merge($params, array('tags' => $tags));
        View::make('tag/index.html', $params);
    }

    public static function show($id){
        $tag = Tag::find($id);
        $tracks = Track::findForTag($id);
        View::make('tag/tag.html', array('tag' => $tag, 'tracks' => $tracks));
    }

    public static function store(){
        $params = $_POST;
        $attributes = array('name' => $params['name']);
        $tag = new Tag($attributes);
        $errors = $tag->errors();
        if (count($errors) == 0){
            $tag->save();
            Redirect::to('/tags', array('message' => 'Your new tag has been added!'));
        } else {
            self::index(array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function destroy($id){
        $tag = new Tag(array('id' => $id));
        $tag->destroy();
        Redirect::to('/tags');
    }

}

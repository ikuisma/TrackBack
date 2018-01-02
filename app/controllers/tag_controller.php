<?php

class TagController extends BaseController{

    public static function index(){
        $tags = Tag::all();
        View::make('tag/index.html', array('tags' => $tags));
    }

    public static function show($id){
        $tag = Tag::find($id);
        View::make('tag/tag.html', array('tag' => $tag));
    }

    public static function store(){
        $params = $_POST;
        $tag = new Tag(array(
            'name' => $params['name']
        ));
        $tag->save();
        Redirect::to('/tags');
    }
}
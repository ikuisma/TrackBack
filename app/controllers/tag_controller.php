<?php

class TagController extends BaseController{

    public static function index(){
        $tags = Tag::all();
        View::make('tag/index.html', array('tags' => $tags));
    }
}

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
        $attributes = self::stripTagAttributes($_POST);
        $tag = new Tag($attributes);
        $errors = $tag->errors();
        if (count($errors) == 0){
            $tag->save();
            Redirect::to('/tags', array('message' => 'Your new tag has been added!'));
        } else {
            self::index(array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function edit($id){
        $tag = Tag::find($id);
        View::make('tag/edit.html', array('attributes' => $tag));
    }

    public static function update($id){
        $attributes = self::stripTagAttributes($_POST);
        $attributes['id'] = $id;
        $tag = new Tag($attributes);
        $errors = $tag->errors();
        if (count($errors) == 0){
            $tag->update();
            Redirect::to('/tags', array('message' => 'The tag has been updated!'));
        } else {
            View::make('tag/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function destroy($id){
        $tag = new Tag(array('id' => $id));
        $tag->destroy();
        Redirect::to('/tags');
    }

    private static function stripTagAttributes($params){
        return array('name' => $params['name']);
    }

}

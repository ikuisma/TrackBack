<?php

  $routes->get('/', function() {
      Redirect::to('/tracks');
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/suunnitelmat/login', function() {
      HelloWorldController::login();
  });

  $routes->get('/suunnitelmat/register', function() {
      HelloWorldController::register();
  });

  $routes->get('/suunnitelmat/tracks', function() {
      HelloWorldController::track_list();
  });

  $routes->get('/suunnitelmat/tracks/1', function() {
      HelloWorldController::track_page();
  });

  $routes->get('/suunnitelmat/feedback', function() {
      HelloWorldController::feedback_list();
  });

  $routes->get('/suunnitelmat/feedback/1', function() {
      HelloWorldController::feedback_page();
  });

  $routes->get('/suunnitelmat/tracks/1/add_feedback', function() {
      HelloWorldController::feedback_add();
  });

  $routes->get('/suunnitelmat/tracks/create_form', function() {
      HelloWorldController::track_add();
  });

  $routes->get('/suunnitelmat/tags', function() {
      HelloWorldController::tags();
  });

  $routes->get('/suunnitelmat/tags/1/edit_form', function() {
      HelloWorldController::tag_edit();
  });

  $routes->get('/suunnitelmat/feedback/1/edit_form', function() {
      HelloWorldController::feedback_edit();
  });

  $routes->get('/suunnitelmat/tracks/1/edit_form', function() {
      HelloWorldController::track_edit();
  });

  $routes->get('/tags', function() {
      TagController::index();
  });

  $routes->get('/tags/:id', function($id){
      TagController::show($id);
  });

  $routes->post('/tags', function(){
      TagController::store();
  });

  $routes->get('/tracks', function(){
      TrackController::index();
  });


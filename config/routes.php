<?php

  function check_logged_in(){
      BaseController::check_logged_in();
  }

  function check_user_can_upload(){
      BaseController::check_user_can_upload();
  }

  $routes->get('/', function() {
      Redirect::to('/tracks');
  });

  $routes->get('/hiekkalaatikko', 'check_logged_in', function() {
    PlanController::sandbox();
  });

  $routes->group('/tags', function () use ($routes) {

      $routes->get('/', function() {
          TagController::index();
      });

      $routes->get('/:id', function($id){
          TagController::show($id);
      });

      $routes->post('/', 'check_logged_in', function(){
          TagController::store();
      });

      $routes->post('/:id/destroy', 'check_logged_in', function($id){
          TagController::destroy($id);
      });

      $routes->get('/:id/edit', 'check_logged_in', function($id){
          TagController::edit($id);
      });

      $routes->post('/:id/edit', 'check_logged_in', function($id){
          TagController::update($id);
      });

  });

  $routes->group('/tracks', function () use ($routes) {

      $routes->get('/', function(){
          TrackController::index();
      });

      $routes->post('/', 'check_logged_in', 'check_user_can_upload', function(){
          TrackController::store();
      });

      $routes->get('/new', 'check_logged_in', 'check_user_can_upload', function(){
          TrackController::create();
      });

      $routes->get('/:id', function($id){
          TrackController::show($id);
      });

      $routes->post('/:id/destroy', 'check_logged_in', function($id){
          TrackController::destroy($id);
      });

      $routes->get('/:id/edit', 'check_logged_in', function($id){
          TrackController::edit($id);
      });

      $routes->post('/:id/edit', 'check_logged_in', function($id){
          TrackController::update($id);
      });

     $routes->get('/:id/feedback/new', 'check_logged_in', function($trackid){
         FeedbackController::create($trackid);
     });

  });

  $routes->group('/feedback', function () use ($routes) {

      $routes->get('/', 'check_logged_in', function() {
          FeedbackController::index();
      });

      $routes->get('/:id', 'check_logged_in', function($id) {
          FeedbackController::show($id);
      });

      $routes->post('/', 'check_logged_in', function() {
          FeedbackController::store();
      });

      $routes->get('/:id/edit', 'check_logged_in', function($id) {
          FeedbackController::edit($id);
      });

      $routes->post('/:id/edit', 'check_logged_in', function($id) {
          FeedbackController::update($id);
      });

      $routes->post('/:id/destroy', 'check_logged_in', function($id) {
          FeedbackController::destroy($id);
      });

  });

  $routes->get('/login', function(){
      UserController::login();
  });

  $routes->post('/login', function(){
      UserController::handleLogin();
  });

  $routes->get('/register', function(){
      UserController::register();
  });

  $routes->post('/register', function(){
      UserController::handleRegistration();
  });

  $routes->post('/logout', 'check_logged_in', function(){
      UserController::logout();
  });


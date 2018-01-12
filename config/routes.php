<?php

  function check_logged_in(){
      BaseController::check_logged_in();
  }

  $routes->get('/', function() {
      Redirect::to('/tracks');
  });

  $routes->group('/suunnitelmat', function () use ($routes) {

      $routes->get('/login', function() {
          PlanController::login();
      });

      $routes->get('/register', function() {
          PlanController::register();
      });

      $routes->get('/tracks', function() {
          PlanController::track_list();
      });

      $routes->get('/tracks/1', function() {
          PlanController::track_page();
      });

      $routes->get('/feedback', function() {
          PlanController::feedback_list();
      });

      $routes->get('/feedback/1', function() {
          PlanController::feedback_page();
      });

      $routes->get('/tracks/1/add_feedback', function() {
          PlanController::feedback_add();
      });

      $routes->get('/tracks/create_form', function() {
          PlanController::track_add();
      });

      $routes->get('/tags', function() {
          PlanController::tags();
      });

      $routes->get('/tags/1/edit_form', function() {
          PlanController::tag_edit();
      });

      $routes->get('/feedback/1/edit_form', function() {
          PlanController::feedback_edit();
      });

      $routes->get('/tracks/1/edit_form', function() {
          PlanController::track_edit();
      });
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

      $routes->post('/', function(){
          TagController::store();
      });

      $routes->post('/:id/destroy', function($id){
          TagController::destroy($id);
      });

      $routes->get('/:id/edit', function($id){
          TagController::edit($id);
      });

      $routes->post('/:id/edit', function($id){
          TagController::update($id);
      });

  });

  $routes->group('/tracks', function () use ($routes) {

      $routes->get('/', function(){
          TrackController::index();
      });

      $routes->post('/', 'check_logged_in', function(){
          TrackController::store();
      });

      $routes->get('/new', 'check_logged_in', function(){
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


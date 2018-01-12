<?php

  function check_logged_in(){
      BaseController::check_logged_in();
  }

  $routes->get('/', function() {
      Redirect::to('/tracks');
  });

  $routes->get('/hiekkalaatikko', 'check_logged_in', function() {
    PlanController::sandbox();
  });

  $routes->get('/suunnitelmat/login', function() {
      PlanController::login();
  });

  $routes->get('/suunnitelmat/register', function() {
      PlanController::register();
  });

  $routes->get('/suunnitelmat/tracks', function() {
      PlanController::track_list();
  });

  $routes->get('/suunnitelmat/tracks/1', function() {
      PlanController::track_page();
  });

  $routes->get('/suunnitelmat/feedback', function() {
      PlanController::feedback_list();
  });

  $routes->get('/suunnitelmat/feedback/1', function() {
      PlanController::feedback_page();
  });

  $routes->get('/suunnitelmat/tracks/1/add_feedback', function() {
      PlanController::feedback_add();
  });

  $routes->get('/suunnitelmat/tracks/create_form', function() {
      PlanController::track_add();
  });

  $routes->get('/suunnitelmat/tags', function() {
      PlanController::tags();
  });

  $routes->get('/suunnitelmat/tags/1/edit_form', function() {
      PlanController::tag_edit();
  });

  $routes->get('/suunnitelmat/feedback/1/edit_form', function() {
      PlanController::feedback_edit();
  });

  $routes->get('/suunnitelmat/tracks/1/edit_form', function() {
      PlanController::track_edit();
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

  $routes->post('/tracks', function(){
      TrackController::store();
  });

  $routes->get('/tracks/new', function(){
      TrackController::create();
  });

  $routes->get('/tracks/:id', function($id){
      TrackController::show($id);
  });

  $routes->post('/tags/:id/destroy', function($id){
      TagController::destroy($id);
  });

  $routes->get('/tags/:id/edit', function($id){
      TagController::edit($id);
  });

  $routes->post('/tags/:id/edit', function($id){
      TagController::update($id);
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

  $routes->post('/logout', function(){
      UserController::logout();
  });


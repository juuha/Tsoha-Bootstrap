<?php
  
  //SceneController routet

  $routes->get('/scene/:id/new', function($id){
    SceneController::new($id);
  });

  $routes->get('/story/:id/new_scene', function($story_id){
    SceneController::newFirstScene($story_id);
  });

  $routes->get('/scene/:id', function($id){
    SceneController::view($id);
  });

  $routes->get('/story/:storyid/read', function($story_id){
    SceneController::read($story_id);
  });

  $routes->get('/story/:storyid/scenes', function($story_id){
    SceneController::list($story_id);
  });

  $routes->get('/scene/:id/edit', function($id){
    SceneController::edit($id);
  });

  $routes->post('/scene/new', function(){
    SceneController::storeNew();
  });

  $routes->post('/scene/first', function(){
    SceneController::storeFirst();
  });

  $routes->post('/scene/existing', function(){
    SceneController::storeExisting();
  });

  $routes->post('/scene/:id/delete', function($id){
    SceneController::delete($id);
  });

  $routes->post('/scene/:id/edit', function($id){
    SceneController::update($id);
  });

  $routes->post('/scene/:id/delete/child', function($id){
    SceneController::deleteLink($id);
  });


  //StoryController routet

  $routes->get('/story', function() {
    StoryController::list();
  });

  $routes->get('/story/new', function(){
    StoryController::new();
  });

  $routes->get('/story/:id', function($id){
    StoryController::view($id);
  });

  $routes->get('/story/:id/edit', function($id){
    StoryController::edit($id);
  });

  $routes->post('/story', function(){
    StoryController::store();
  });

  $routes->post('/story/:id/edit', function($id){
    StoryController::update($id);
  });

  $routes->post('/story/:id/delete', function($id){
    StoryController::delete($id);
  });


  //Login routet

  $routes->get('/login', function(){
    AuthorController::login();
  });

  $routes->post('/login', function(){
    AuthorController::handle_login();
  });


  //Testi ja suunnitelma routet
  
  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/suunnitelmat/login', function() {
  	HelloWorldController::login();
  }); 

  $routes->get('/suunnitelmat/scene_edit', function() {
  	HelloWorldController::scene_edit();
  }); 

  $routes->get('/suunnitelmat/scene_view', function() {
  	HelloWorldController::scene_view();
  }); 

  $routes->get('/suunnitelmat/story_edit', function() {
  	HelloWorldController::story_edit();
  }); 

  $routes->get('/suunnitelmat/story_list', function() {
  	HelloWorldController::story_list();
  }); 

  $routes->get('/suunnitelmat/story_view', function() {
  	HelloWorldController::story_view();
  }); 

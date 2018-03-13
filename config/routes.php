<?php

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

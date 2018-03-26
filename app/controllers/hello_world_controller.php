<?php
  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('home.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      $options = array('author_id' => 1);
      $stories = Story::allFrom($options);
      
      Kint::dump($stories);
    }

    public static function login(){
      View::make('suunnitelmat/login.html');
    }

    public static function scene_view(){
      View::make('suunnitelmat/scene_view.html');
    }

    public static function scene_edit(){
      View::make('suunnitelmat/scene_edit.html');
    }

    public static function story_edit(){
      View::make('suunnitelmat/story_edit.html');
    }

    public static function story_list(){
      View::make('suunnitelmat/story_list.html');
    }

    public static function story_view(){
      View::make('suunnitelmat/story_view.html');
    }
  }

<?php
  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('home.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      $story = new Scene(array(
        'name' => 'Waking Up',
        'story_id' => '1'
        ));

      $errors = $story->errors();

      Kint::dump($errors);
      
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

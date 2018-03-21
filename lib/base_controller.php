<?php

  class BaseController{

    public static function get_user_logged_in(){
      if (isset($_SESSION['author'])) {
        $author_id = $_SESSION['author'];
        $author = Author::find($author_id);

        return $author;
      } else return null;
    }

    public static function check_logged_in(){
      if(!isset($_SESSION['author'])){
        Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään!'));
      }
    }

  }

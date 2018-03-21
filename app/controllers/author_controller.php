<?php

class AuthorController extends BaseController{
	
	public static function login(){
		View::make('author/login.html');
	}

	public static function handle_login(){
		$params = $_POST;

		$author = Author::authenticate($params['name'], $params['password']);

		if (!$author){
			View::make('author/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana.', 'name' => $params['name']));
		} else {
			$_SESSION['author'] = $author->id;

			Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $author->name . '!'));
		}
	}

}

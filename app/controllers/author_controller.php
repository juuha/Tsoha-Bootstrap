<?php

class AuthorController extends BaseController{
	
	public static function login(){
		View::make('author/login.html');
	}

	public static function logout(){
		$_SESSION['author'] = null;
		Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
	}

	public static function new(){
		View::make('author/new.html');
	}

	public static function save(){
		$params = $_POST;

		$author = new Author(array(
			'name' => $params['name'],
			'password' => $params['password']
			));

		$errors = $author->errors();

		if ($params['password'] != $params['password_check']){
			$errors[] = "Salasanat eivät täsmää.";
		}


		if(count($errors) == 0){
			$author->save();
			Redirect::to('/login', array('message' => 'käyttäjätunnus luotu onnistuneesti.', 'name' => $params['name']));
		} else {
			View::make('author/new.html', array('name' => $params['name'], 'errors' => $errors));
		}
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

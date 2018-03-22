<?php

class StoryController extends BaseController{
	public static function list(){
		$params = $_GET;
		$options = array();
		if(isset($params['search'])){
			$options['search'] = $params['search'];
		}

		$stories = Story::all($options);

		View::make('story/list.html', array('stories' => $stories));
	}

	public static function view($id){
		$story = Story::find($id);
		$author = Author::find($story->author_id);
		$has_first_scene = Story::hasFirstScene($id);

		View::make('story/view.html', array('story' => $story, 'has_first_scene' => $has_first_scene, 'author' => $author));
	}

	public static function new(){
		View::make('story/new.html');
	}

	public static function listFrom($author_id){
		$stories = Story::allFrom($author_id);
		$author = Author::find($author_id);

		View::make('story/list.html', array('stories' => $stories, 'author' => $author));
	}

	public static function store(){
		$params = $_POST;

		if (!StoryController::user_is_owner($params['author_id'])){
			Redirect::to('/', array('error' => 'Et voi muuttaa toisen käyttäjän tarinaa.'));
		}

		$attributes = array(
			'name' => $params['name'],
			'author_id' => $params['author_id'],
			'genre' => $params['genre'],
			'synopsis' => $params['synopsis']
			);

		$story = new Story($attributes);
		$errors = $story->errors();
		if(count($errors) == 0){
			$story->save();

			Redirect::to('/story/' . $story->id, array('message' => 'Tarina lisätty kirjastoon.'));
		} else {
			Redirect::to('/story/new', array('errors' => $errors, 'attributes' => $attributes));
		}

	}

	public static function edit($id){
		$story = Story::find($id);

		if (!StoryController::user_is_owner($story->author_id)){
			Redirect::to('/', array('error' => 'Et voi muuttaa toisen käyttäjän tarinaa.'));
		}

		View::make('story/edit.html', array('story' => $story));
	}

	public static function update($id){
		$params = $_POST;

		if (!StoryController::user_is_owner($params['author_id'])){
			Redirect::to('/', array('error' => 'Et voi muuttaa toisen käyttäjän tarinaa.'));
		}

		$attributes = array(
			'id' => $id,
			'name' => $params['name'],
			'author_id' => $params['author_id'],
			'genre' => $params['genre'],
			'synopsis' => $params['synopsis']
			);

		$story = new Story($attributes);

		$errors = $story->errors();

		if(count($errors) == 0){
			$story->update();
			Redirect::to('/story/'. $story->id, array('message' => 'Tarinaa on muokattu onnistuneesti.'));
		} else {
			View::make('story/edit.html', array('errors' => $errors, 'attributes' => $attributes, 'story' => $story));
		}
	}

	public static function delete($id){
		$story = Story::find($id);

		if (!StoryController::user_is_owner($story->author_id)){
			Redirect::to('/', array('error' => 'Et voi muuttaa toisen käyttäjän tarinaa.'));
		}

		$scenes = Scene::allIn($story->id);
		foreach ($scenes as $scene) {
			$scene_links = SceneLink::findFamilyOf($scene->id);
			foreach ($scene_links as $link) {
				$link->delete();
			}
			$scene->delete();
		}
		$story->delete();

		Redirect::to('/story', array('message' => 'Tarina poistettu onnistuneesti.'));
	}

}
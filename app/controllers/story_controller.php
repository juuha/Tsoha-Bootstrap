<?php

class StoryController extends BaseController{
	public static function list(){
		$stories = Story::all();

		View::make('story/list.html', array('stories' => $stories));
	}

	public static function view($id){
		$story = Story::find($id);
		$has_first_scene = Story::hasFirstScene($id);

		View::make('story/view.html', array('story' => $story, 'has_first_scene' => $has_first_scene));
	}

	public static function new(){
		View::make('story/new.html');
	}

	public static function store(){
		$params = $_POST;

		$attributes = array(
			'name' => $params['name'],
			'author_id' => 1, //TODO
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
	//TODO
	public static function edit($id){

	}
}
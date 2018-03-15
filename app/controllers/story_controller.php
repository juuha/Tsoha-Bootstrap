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

		$story = new Story(array(
			'name' => $params['name'],
			'author_id' => 1, //TODO
			'genre' => $params['genre'],
			'synopsis' => $params['synopsis']
			));

		$story->save();

		Redirect::to('/story/' . $story->id, array('message' => 'Tarina lisätty kirjastoon.'));
	}
	//TODO
	public static function edit($id){

	}
}
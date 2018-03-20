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

	public static function edit($id){
		$story = Story::find($id);
		View::make('story/edit.html', array('story' => $attributes));
	}

	public static function update($id){
		$params = $_POST;

		$attributes = array(
			'id' => $id,
			'name' => $params['name'],
			'genre' => $params['genre'],
			'synopsis' => $params['synopsis']
			);

		$story = new Story($attributes);
		$errors = $story->errors();

		if(count($errors) == 0){
			$story->update();
			Redirect::to('/story/'. $story->id, array('message' => 'Tarinaa on muokattu onnistuneesti.'));
		} else {
			View::make('story/edit.html', array('errors' => $errors, 'attributes' => $attributes));
		}
	}

	public static function delete($id){
		$story = Story::find($id);
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
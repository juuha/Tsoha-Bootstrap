<?php

class SceneController extends BaseController{
	
	public static function view($id){
		$scene = Scene::find($id);
		$story = Story::find($scene->story_id);
		$scenes = Scene::allIn($story->id);
		$child_links = SceneLink::findScenesAndLinksOf($scene->id);

		View::make('scene/view.html', array('scene' =>$scene,'story' => $story, 'scenes' => $scenes, 'child_links' => $child_links));
	}

	public static function new($id){
		$story = Story::find(Scene::find($id)->story_id);
		if (!StoryController::user_is_owner($story->author_id)){
			Redirect::to('/', array('message' => 'Et voi muuttaa toisen käyttäjän tarinaa.'));
		}
		View::make('scene/new.html', array('parent_scene_id' => $id, 'story' => $story));
	}

	public static function newFirstScene($id){
		$story = Story::find($id);
		if (!StoryController::user_is_owner($story->author_id)){
			Redirect::to('/', array('message' => 'Et voi muuttaa toisen käyttäjän tarinaa.'));
		}
		View::make('scene/new.html', array('story_id' => $id, 'first_scene' => 1));
	}

	public static function read($story_id){
		$scene = Scene::firstSceneIn($story_id);
		$story = Story::find($story_id);
		$scenes = Scene::allIn($story_id);
		$child_links = SceneLink::findScenesAndLinksOf($scene->id);

		View::make('scene/view.html', array('scene' => $scene,"story" => $story, 'scenes' => $scenes, 'child_links' => $child_links));
	}

	public static function list($story_id){
		$scenes = Scene::AllIn($story_id);

		View::make('scene/list.html', array('scenes' => $scenes, 'story_id' => $story_id));
	}

	//save and link a new scene to the story
	public static function storeNew(){
		$params = $_POST;

		$story = Story::find($params['story_id']);
		if (!StoryController::user_is_owner($story->author_id)){
			Redirect::to('/', array('message' => 'Et voi muuttaa toisen käyttäjän tarinaa.'));
		}

		$attributes = array(
			'name' => $params['name'],
			'story_id' => $params['story_id'],
			'situation' => $params['situation'],
			'question' => $params['question'],
			'first_scene' => $params['first_scene'],
			'option_name' => $params['option_name']
			);

		$scene = 	new Scene($attributes);
		$errors =  $scene->errors();

		if(count($errors) == 0){
			$scene->save();

			$scene_link = new SceneLink(array(
				'option_name' => $params['option_name'],
				'parent_scene_id' => $params['parent_scene_id'],
				'child_scene_id' => $scene->id
				));
			$errors = array_merge($errors, $scene_link->errors());

			if(count($errors) == 0){
				$scene_link->save();
				Story::find($scene->story_id)->edited();
				Redirect::to('/scene/' . $params['parent_scene_id'], array('message' =>'Uusi kohtaus lisätty.'));
			} else {
				$scene->delete();
			}
		} else {
			$scene_link = new SceneLink(array(
				'option_name' => $params['option_name']
				));
			$errors = array_merge($errors, $scene_link->errors());
		}
		Redirect::to('/scene/' . $params['parent_scene_id'] .'/new', array('errors' => $errors, 'attributes' => $attributes));
	}

	//Save the first scene of a story
	public static function storeFirst(){
		$params = $_POST;

		$story = Story::find($params['story_id']);

		if (!StoryController::user_is_owner($story->author_id)){
			Redirect::to('/', array('message' => 'Et voi muuttaa toisen käyttäjän tarinaa.'));
		}

		$attributes = array(
			'name' => $params['name'],
			'story_id' => $params['story_id'],
			'situation' => $params['situation'],
			'question' => $params['question'],
			'first_scene' => $params['first_scene']
			);

		$scene = new Scene($attributes);
		$errors = $scene->errors();

		if(count($errors) == 0){
			$scene->save();
			Story::find($scene->story_id)->edited();
			Redirect::to('/scene/' . $scene->id, array('message' =>'Uusi kohtaus lisätty.'));
		} else {
			Redirect::to('/story/' . $params['story_id'] . '/new_scene', array('errors' => $errors, 'attributes' => $attributes));
		}
	}

	//Link an existing scene to another scene
	public static function storeExisting(){
		$params = $_POST;

		$story = Story::find(Scene::find($params['parent_scene_id'])->story_id);

		if (!StoryController::user_is_owner($story->author_id)){
			Redirect::to('/', array('message' => 'Et voi muuttaa toisen käyttäjän tarinaa.'));
		}

		if(isset($params['child_scene_id'])){
			$attributes = array(
				'option_name' => $params['option_name'],
				'child_scene_id' => $params['child_scene_id'],
				'parent_scene_id' => $params['parent_scene_id']
				);
			$scene_link = new SceneLink($attributes);
			$errors = $scene_link->errors();
		} else {	
			$errors[] = 'Sinun täytyy valita lapsi.';
			$scene_link = new SceneLink(array(
				'option_name' => $params['option_name']
				));
			$errors = array_merge($errors, $scene_link->errors());
		}
		if (count($errors) == 0){
			$scene_link->save();
			$story->edited();
			Redirect::to('/scene/' . $params['parent_scene_id'], array('message' => 'Uusi lapsi lisätty'));
		} else {
			$attributes = array();
			Redirect::to('/scene/' . $params['parent_scene_id'], array('errors' => $errors, 'attributes' => $attributes));
		}
	}

	public static function edit($id){
		$scene = Scene::find($id);
		$story = Story::find($scene->story_id);

		if (!StoryController::user_is_owner($story->author_id)){
			Redirect::to('/', array('message' => 'Et voi muuttaa toisen käyttäjän tarinaa.'));
		}

		View::make('scene/edit.html', array('scene' => $scene));
	}

	public static function update($id){
		$story = Story::find(Scene::find($id)->story_id);

		$params = $_POST;

		if (!StoryController::user_is_owner($story->author_id)){
			Redirect::to('/', array('message' => 'Et voi muuttaa toisen käyttäjän tarinaa.'));
		}

		$attributes = array(
			'id' => $id,
			'story_id' => $story->id,
			'name' => $params['name'],
			'situation' => $params['situation'],
			'question' => $params['question']
			);

		$scene = new Scene($attributes);
		$errors = $scene->errors();

		if (count($errors) == 0){
			$scene->update();
			$story->edited();
			Redirect::to('/scene/' . $scene->id, array('message' => 'Kohtaus päivitetty onnistuneesti.'));
		} else {
			View::make('scene/edit.html', array('errors' => $errors, 'attributes' => $attributes, 'scene' => $scene));
		}
	}

	public static function delete($id){
		$scene = Scene::find($id);
		$story_id = $scene->story_id;
		$story = Story::find($story_id);

		if (!StoryController::user_is_owner($story->author_id)){
			Redirect::to('/', array('message' => 'Et voi muuttaa toisen käyttäjän tarinaa.'));
		}

		$scene_links = SceneLink::findFamilyOf($id);
		foreach ($scene_links as $scene_link) {
			$scene_link->delete();
		}
		$scene->delete();
		$story->edited();
		Redirect::to('/story/' . $story_id . '/scenes', array('message' => 'Kohtaus poistettu onnistuneesti.'));
	}

	public static function deleteLink($id){
		$story = Story::find(Scene::find($id)->story_id);
		if (!StoryController::user_is_owner($story->author_id)){
			Redirect::to('/', array('message' => 'Et voi muuttaa toisen käyttäjän tarinaa.'));
		}

		$params = $_POST;

		$scene_link = SceneLink::find($params['scene_link_id']);
		if ($scene_link){
			$scene_link->delete();
			$story->edited();
			Redirect::to('/scene/' . $id, array('message' => 'Yhteys lapseen poistettu onnistuneesti.'));
		} 
	}
}

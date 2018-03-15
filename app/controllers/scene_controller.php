<?php

class SceneController extends BaseController{
	
	public static function view($id){
		$scene = Scene::find($id);
		$story = Story::find($scene->story_id);
		$links = SceneLink::findChildrenOf($scene->id);
		$scenes = Scene::allIn($story->id);

		View::make('scene/view.html', array('scene' =>$scene,'story' => $story, 'links' => $links, 'scenes' => $scenes));
	}

	public static function new($id){
		$story = Story::find(Scene::find($id)->story_id);
		View::make('scene/new.html', array('parent_scene_id' => $id, 'story' => $story));
	}

	public static function newFirstScene($id){
		View::make('scene/new.html', array('story_id' => $id, 'first_scene' => 1));
	}

	public static function storeNew(){
		$params = $_POST;

		$scene = new Scene(array(
			'name' => $params['name'],
			'story_id' => $params['story_id'],
			'situation' => $params['situation'],
			'question' => $params['question'],
			'first_scene' => $params['first_scene']
			));

		$scene->save();

		$sceneLink = new SceneLink(array(
			'option_name' => $params['option_name'],
			'parent_scene_id' => $params['parent_scene_id'],
			'child_scene_id' => $scene->id
			));

		$sceneLink->save();

		Redirect::to('/scene/' . $params['parent_scene_id'], array('message' =>'Uusi kohtaus lisätty.'));
		
	}

	public static function storeFirst(){
		$params = $_POST;

		$scene = new Scene(array(
			'name' => $params['name'],
			'story_id' => $params['story_id'],
			'situation' => $params['situation'],
			'question' => $params['question'],
			'first_scene' => $params['first_scene']
			));

		$scene->save();

		Redirect::to('/scene/' . $scene->id, array('message' =>'Uusi kohtaus lisätty.'));
		
	}

	public static function storeExisting(){
		$params = $_POST;

		$sceneLink = new SceneLink(array(
			'option_name' => $params['option_name'],
			'child_scene_id' => $params['child_scene_id'],
			'parent_scene_id' => $params['parent_scene_id']
			));

		$sceneLink->save();

		Redirect::to('/scene/' . $params['parent_scene_id'], array('message' => 'Uusi lapsi lisätty'));
	}

	public static function read($story_id){
		$scene = Scene::firstSceneIn($story_id);
		$story = Story::find($scene->story_id);
		$links = SceneLink::findChildrenOf($scene->id);

		View::make('scene/view.html', array('scene' => $scene,"story" => $story, 'links' => $links));
	}

	public static function list($story_id){
		$scenes = Scene::AllIn($story_id);

		View::make('scene/list.html', array('scenes' => $scenes, 'story_id' => $story_id));
	}
}

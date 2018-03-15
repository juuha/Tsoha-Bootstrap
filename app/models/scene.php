<?php

class Scene extends BaseModel{
	public $id, $name, $story_id, $situation, $question, $first_scene;

	public function __construct($attributes){
		parent::__construct($attributes);
	}

	public static function allIn($story_id){
		$query = DB::connection()->prepare('SELECT * FROM Scene WHERE story_id = :story_id');
		$query->execute(array('story_id' => $story_id));
		$rows = $query->fetchAll();
		$scenes = Array();

		foreach ($rows as $row) {
			$scenes[] = new Scene(array(
				'id' => $row['id'],
				'name' => $row['name'],
				'story_id' => $row['story_id'],
				'situation' => $row['situation'],
				'question' => $row['question'],
				'first_scene' => $row['first_scene']
				));
		}

		return $scenes;
	}

	public static function find($id){
		$query = DB::connection()->prepare('SELECT * FROM Scene WHERE id = :id LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if ($row){
			$scene = new Scene(array(
				'id' => $row['id'],
				'name' => $row['name'],
				'story_id' => $row['story_id'],
				'situation' => $row['situation'],
				'question' => $row['question'],
				'first_scene' => $row['first_scene']
				));

			return $scene;
		}

		return null;
	}

	public static function firstSceneIn($story_id){
		$query = DB::connection()->prepare('SELECT * FROM Scene WHERE story_id = :story_id AND first_scene = 1');
		$query->execute(array('story_id' => $story_id));
		$row = $query->fetch();

		if ($row){
			$scene = new Scene(array(
				'id' => $row['id'],
				'name' => $row['name'],
				'story_id' => $row['story_id'],
				'situation' => $row['situation'],
				'question' => $row['question'],
				'first_scene' => $row['first_scene']
				));

			return $scene;
		}

		return null;
	}

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Scene (name, story_id, situation, question, first_scene) VALUES (:name, :story_id, :situation, :question, :first_scene) RETURNING id');
		$query->execute(array('name' => $this->name, 'story_id' => $this->story_id, 'situation' => $this->situation, 'question' => $this->question, 'first_scene' => $this->first_scene));
		$row = $query->fetch();

		$this->id = $row['id'];
	}
}
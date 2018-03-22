<?php

class Scene extends BaseModel{
	public $id, $name, $story_id, $situation, $question, $first_scene;

	public function __construct($attributes){
		parent::__construct($attributes);
		$this->validators = array('validateName', 'validateSituation', 'validateQuestion');
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

	public static function existsWith($name, $story_id, $id){
		$query = DB::connection()->prepare('SELECT * FROM Scene Where story_id = :story_id AND name = :name AND NOT id = :id');
		$query->execute(array('story_id' => $story_id, 'name' => $name, 'id' => $id));
		$row = $query->fetch();

		if ($row){
			return true;
		} else return false;
	}

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Scene (name, story_id, situation, question, first_scene) VALUES (:name, :story_id, :situation, :question, :first_scene) RETURNING id');
		$query->execute(array('name' => $this->name, 'story_id' => $this->story_id, 'situation' => $this->situation, 'question' => $this->question, 'first_scene' => $this->first_scene));
		$row = $query->fetch();
		$this->id = $row['id'];
	}

	public function validateName(){
		$errors = array();
		if(Scene::validateNotEmpty($this->name)){
			$errors[] = 'Kohtauksen nimi ei saa olla tyhjä.';
		}
		if(Scene::existsWith($this->name, $this->story_id, $this->id)){
			$errors[] = 'Kohtauksen nimi tässä tarinassa on jo käytössä.';
		}
		if(Scene::validateStringhLengthMax($this->question, 64)){
			$errors[] = 'Kohtauksen nimi ei saa olla pitempi kuin 64 merkkiä.'
		}

		return $errors;
	}

	public function validateSituation(){
		$errors = array();
		if(Scene::validateNotEmpty($this->situation)){
			$errors[] = 'Kohtausen Tilanne ei saa olla tyhjä.';
		}
		if(Scene::validateStringhLengthMax($this->situation, 1024)){
			$errors[] = 'Kohtauksen tilanne ei saa olla pitempi kuin 1024 merkkiä.'
		}
		return $errors;
	}


	public function validateQuestion(){
		$errors = array();
		if(Scene::validateNotEmpty($this->question)){
			$errors[] = 'Kysymys ei saa olla tyhjä.';
		}
		if(Scene::validateStringhLengthMax($this->question, 128)){
			$errors[] = 'Kohtauksen kysymys ei saa olla pitempi kuin 128 merkkiä.'
		}
		return $errors;
	}

	public function delete(){
		$query = DB::connection()->prepare('DELETE FROM Scene WHERE id = :id');
		$query->execute(array('id' => $this->id));
	}

	public function update(){
		$query = DB::connection()->prepare('UPDATE Scene Set name = :name, situation = :situation, question = :question WHERE id = :id');
		$query->execute(array('name' => $this->name, 'situation' => $this->situation, 'question' => $this->question, 'id' => $this->id));
	}

}

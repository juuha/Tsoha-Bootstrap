<?php

class SceneLink extends BaseModel{
	public $id, $option_name, $parent_scene_id, $child_scene_id;

	public function __construct($attributes){
		parent::__construct($attributes);
		$this->validators = array('validateOptionName');
	}

	public static function findChildrenOf($parent_scene_id){
		$query = DB::connection()->prepare('SELECT * FROM SceneLink WHERE parent_scene_id = :parent_scene_id');
		$query->execute(array('parent_scene_id' => $parent_scene_id));
		$rows = $query->fetchAll();
		$links = Array();

		foreach ($rows as $row) {
			$links[] = new SceneLink(array(
				'id' => $row['id'],
				'option_name' => $row['option_name'],
				'parent_scene_id' => $row['parent_scene_id'],
				'child_scene_id' => $row['child_scene_id']
				));	
		}
		
		return $links;
	}

	public static function findFamilyOf($scene_id){
		$query = DB::connection()->prepare('SELECT * FROM SceneLink WHERE parent_scene_id = :scene_id OR child_scene_id = :scene_id');
		$query->execute(array('scene_id' => $scene_id));
		$rows = $query->fetchAll();
		$links = Array();

		foreach ($rows as $row){
			$links[] = new SceneLink(array(
				'id' => $row['id'],
				'option_name' => $row['option_name'],
				'parent_scene_id' => $row['parent_scene_id'],
				'child_scene_id' => $row['child_scene_id']
				));
		}
		return $links;
	}


	public function save(){
		$query = DB::connection()->prepare('INSERT INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES (:option_name, :parent_scene_id, :child_scene_id) RETURNING id');
		$query->execute(array('option_name' => $this->option_name, 'parent_scene_id' => $this->parent_scene_id, 'child_scene_id' => $this->child_scene_id));
		$row = $query->fetch();
		$this->id = $row['id'];
	}

	public function validateOptionName(){
		$errors = array();
		if(SceneLink::validateNotEmpty($this->option_name)){
			$errors[] = 'Valinnan nimi ei saa olla tyhjä.';
		}
		return $errors;
	}

	public function delete(){
		$query = DB::connection()->prepare('DELETE FROM SceneLink WHERE id = :id');
		$query->execute(array('id' => $this->id));
	}

	public static function findScenesAndLinksOf($parent_scene_id){
		$query = DB::connection()->prepare('SELECT *, SceneLink.id as scene_link_id FROM SceneLink INNER JOIN Scene ON SceneLink.child_scene_id = Scene.id AND SceneLink.parent_scene_id = :parent_scene_id');
		$query->execute(array('parent_scene_id' => $parent_scene_id));
		$rows = $query->fetchAll();
		$child_links = Array();

		foreach ($rows as $row) {
			$child_links[] = array(
				'id' => $row['id'],
				'name' => $row['name'],
				'situation' => $row['situation'],
				'question' => $row['question'],
				'scene_link_id' => $row['scene_link_id'],
				'option_name' => $row['option_name'],
				'child_scene_id' => $row['child_scene_id'],
				'parent_scene_id' => $row['parent_scene_id']
				);
		}

		return $child_links;
	}

	public static function find($id){
		$query = DB::connection()->prepare('SELECT * FROM SceneLink WHERE id = :id');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if($row){
			$scene_link = new SceneLink(array(
				'id' => $row['id'],
				'option_name' => $row['option_name'],
				'parent_scene_id' => $row['parent_scene_id'],
				'child_scene_id' => $row['child_scene_id']
				));
			return $scene_link;
		} else {
			return null;
		}
	}
}
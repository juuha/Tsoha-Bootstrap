<?php

class SceneLink extends BaseModel{
	public $id, $option_name, $parent_scene_id, $child_scene_id;

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

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES (:option_name, :parent_scene_id, :child_scene_id) RETURNING id');
		$query->execute(array('option_name' => $this->option_name, 'parent_scene_id' => $this->parent_scene_id, 'child_scene_id' => $this->child_scene_id));

		$row = $query->fetch();

		$this->id = $row['id'];
	}
}
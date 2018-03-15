<?php

class Story extends BaseModel{
	public $id, $name, $author_id, $genre, $synopsis, $last_edited;

	public function __construct($attributes){
		parent::__construct($attributes);
	}

	public static function all(){
		$query = DB::connection()->prepare('SELECT * FROM Story');
		$query->execute();
		$rows = $query->fetchAll();
		$stories = array();

		foreach ($rows as $row) {
			$stories[] = new Story(array(
				'id' => $row['id'],
				'name' => $row['name'],
				'author_id' => $row['author_id'],
				'genre' => $row['genre'],
				'synopsis' => $row['synopsis'],
				'last_edited' => $row['last_edited']
				));
		}

		return $stories;
	}

	public static function find($id){
		$query = DB::connection()->prepare('SELECT * FROM Story WHERE id = :id LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if ($row){
			$story = new Story(array(
				'id' => $row['id'],
				'name' => $row['name'],
				'author_id' => $row['author_id'],
				'genre' => $row['genre'],
				'synopsis' => $row['synopsis'],
				'last_edited' => $row['last_edited']
				));
			return $story;
		}

		return null;
	}

	public static function hasFirstScene($story_id){
		$query = DB::connection()->prepare('SELECT * FROM Scene WHERE story_id = :story_id AND first_scene = 1');
		$query->execute(array('story_id' => $story_id));
		$row = $query->fetch();
		if ($row){
			$truth = true;
		} else {
			$truth = false;
		}
		return $truth;
	}


	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Story (name, author_id, genre, synopsis, last_edited) VALUES (:name, :author_id, :genre, :synopsis, :last_edited) RETURNING id');
		$query->execute(array('name' => $this->name, 'author_id' => $this->author_id, 'genre' => $this->genre, 'synopsis' => $this->synopsis, 'last_edited' => date("Y-m-d")));
		$row = $query->fetch();
		$this->id = $row['id'];
	}

}
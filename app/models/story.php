<?php

class Story extends BaseModel{
	public $id, $name, $author_id, $genre, $synopsis, $last_edited;

	public function __construct($attributes){
		parent::__construct($attributes);
		$this->validators = array('validateName', 'validateGenre', 'validateSynopsis');
	}

	public static function all($options){
		$query_string = 'SELECT Story.name as name, Author.name as author_name, Story.genre, Story.synopsis, Story.last_edited, Author.id as author_id, Story.id FROM Story LEFT JOIN Author ON Story.author_id = Author.id';
		if(isset($options['search'])){
			$query_string .= ' WHERE UPPER(Story.name) LIKE UPPER(:like)';
			$vars['like'] = '%' . $options['search'] . '%';
			$query = DB::connection()->prepare($query_string);
			$query->execute($vars);
		} else {
			$query = DB::connection()->prepare($query_string);
			$query->execute();
		}

		
		$rows = $query->fetchAll();
		$stories = array();

		foreach ($rows as $row) {
			$stories[] = array(
				'id' => $row['id'],
				'name' => $row['name'],
				'author_name' => $row['author_name'],
				'author_id' => $row['author_id'],
				'genre' => $row['genre'],
				'synopsis' => $row['synopsis'],
				'last_edited' => $row['last_edited']
				);
		}

		return $stories;
	}

	public static function allFrom($options){
		$query_string = 'SELECT Story.name as name, Author.name as author_name, Story.genre, Story.synopsis, Story.last_edited, Author.id as author_id, Story.id FROM Story LEFT JOIN Author ON Story.author_id = Author.id WHERE author_id = :author_id';
		if(isset($options['search'])){
			$query_string .= ' AND UPPER(Story.name) LIKE UPPER(:like)';
			$vars['like'] = '%' . $options['search'] . '%';
			$vars['author_id'] = $options['author_id'];
			$query = DB::connection()->prepare($query_string);
			$query->execute($vars);
		}	else {	
			$query = DB::connection()->prepare($query_string);
			$query->execute(array('author_id' => $options['author_id']));
		}
		$rows = $query->fetchAll();
		$stories = Array();

		foreach ($rows as $row) {
			$stories[] = array(
				'id' => $row['id'],
				'name' => $row['name'],
				'author_name' => $row['author_name'],
				'author_id' => $row['author_id'],
				'genre' => $row['genre'],
				'synopsis' => $row['synopsis'],
				'last_edited' => $row['last_edited']
				);
		}

		return $stories;
	}

	public static function find($id){
		$query = DB::connection()->prepare('SELECT * FROM Story WHERE id = :id LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if ($row){
			$story = new Story($row);
			return $story;
		}

		return null;
	}

	public static function hasFirstScene($story_id){
		$query = DB::connection()->prepare('SELECT * FROM Scene WHERE story_id = :story_id AND first_scene = 1');
		$query->execute(array('story_id' => $story_id));
		$row = $query->fetch();
		if ($row){
			return true;
		} else return false;
	}

	public static function existsWith($name, $id){
		$query = DB::connection()->prepare('SELECT * FROM Story WHERE name = :name AND NOT id = :id');
		$query->execute(array('name' => $name, 'id' => $id));
		$row = $query->fetch();

		if($row){
			return true;
		} else return false;
	}

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Story (name, author_id, genre, synopsis, last_edited) VALUES (:name, :author_id, :genre, :synopsis, :last_edited) RETURNING id');
		$query->execute(array('name' => $this->name, 'author_id' => $this->author_id, 'genre' => $this->genre, 'synopsis' => $this->synopsis, 'last_edited' => date("Y-m-d")));
		$row = $query->fetch();
		$this->id = $row['id'];
	}

	public function update(){
		$query = DB::connection()->prepare('UPDATE Story SET name = :name, genre = :genre, synopsis = :synopsis, last_edited = :last_edited WHERE id = :id');
		$query->execute(array('name' => $this->name, 'genre' => $this->genre, 'synopsis' => $this->synopsis, 'id' => $this->id, 'last_edited' => date("Y-m-d")));
	}

	//kun jotain muutoksia tapahtuu tarinan kohtauksiin.
	public function edited(){
		$query = DB::connection()->prepare('UPDATE STORY Set last_edited = :last_edited');
		$query->execute(array('last_edited' => date("Y-m-d")));
	}

	public function delete(){
		$query = DB::connection()->prepare('DELETE FROM Story WHERE id = :id');
		$query->execute(array('id' => $this->id));
	}

	public function validateName(){
		$errors = array();
		if(Story::validateNotEmpty($this->name)){
			$errors[] = 'Tarinan nimi ei saa olla tyhjä';
		}
		if(Story::existsWith($this->name, $this->id)){
			$errors[] = 'Tarinan nimi on jo käytössä.';
		}
		if(Story::validateStringLengthMax($this->name, 64)){
			$errors[] = 'Tarinan nimi ei saa olla pitempi kuin 64 merkkiä.';
		}
		
		return $errors;
	}

	public function validateGenre(){
		$errors = array();
		if(Story::validateNotEmpty($this->genre)){
			$errors[] = 'Tarinalla on oltava genre.';
		}
		if(Story::validateStringLengthMax($this->genre, 32)){
			$errors[] = 'Tarinan genre ei saa olla pitempi kuin 32 merkkiä.';
		}

		return $errors;
	}

	public function validateSynopsis(){
		$errors = array();
		if(Story::validateNotEmpty($this->synopsis)){
			$errors[] = 'Tarinan kuvaus ei voi olla tyhjä';
		}
		if(Story::validateStringLengthMax($this->synopsis, 1024)){
			$errors[] = 'Tarinan kuvaus ei saa olla pitempi kuin 1024 merkkiä.';
		}

		return $errors;
	}

}

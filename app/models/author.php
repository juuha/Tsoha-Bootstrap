<?php

class Author extends BaseModel{
	public $id, $name, $password;

	public function __construct($attributes){
		parent::__construct($attributes);

	}

	public static function authenticate($name, $password){
		$query = DB::connection()->prepare('SELECT * FROM Author WHERE UPPER(name) = UPPER(:name) AND password = :password LIMIT 1');
		$query->execute(array('name' => $name, 'password' => $password));
		$row = $query->fetch();

		if ($row){
			$author = new Author(array(
				'id' => $row['id'],
				'name' => $row['name']
				));
			return $author;
		} else return null;
	}

	public static function find($id){
		$query = DB::connection()->prepare('SELECT * FROM Author WHERE id = :id LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if($row){
			$author = new Author(array(
				'id' => $row['id'],
				'name' => $row['name']
				));
			return $author;
		} else return null;
	}
}
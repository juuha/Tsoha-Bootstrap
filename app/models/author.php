<?php

class Author extends BaseModel{
	public $id, $name, $password;

	public function __construct($attributes){
		parent::__construct($attributes);
		$this->validators = array('validateName', 'validatePassword');
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

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Author (name, password) VALUES (:name, :password) RETURNING id');
		$query->execute(array('name' => $this->name, 'password' => $this->password));
	}

	public static function existsWith($name){
		$query = DB::connection()->prepare('SELECT * FROM Author WHERE UPPER(name) = UPPER(:name) LIMIT 1');
		$query->execute(array('name' => $name));
		$row = $query->fetch();
		if($row){
			return true;
		} else return false;
	}

	public function validateName(){
		$errors = array();
		if(Author::validateNotEmpty($this->name)){
			$errors[] = 'Nimi ei voi olla tyhjä.';
		}
		if(Author::existsWith($this->name)){
			$errors[] = 'Nimi on jo käytössä.';
		}
		if(Author::validateStringLengthMax($this->name, 50)){
			$errors[] = 'Nimi ei voi olla yli 50 merkkiä pitkä.';
		}

		return $errors;
	}

	public function validatePassword(){
		$errors = array();
		if(Author::validateNotEmpty($this->password)){
			$errors[] = 'Salasana ei voi olla tyhjä.';
		}
		if(Author::validateStringLengthMin($this->password, 5)){
			$errors[] = 'Salasana ei saa lyhyempi kuin 5 merkkiä.';
		}
		if(Author::validateStringLengthMax($this->password, 50)){
			$errors[] = 'Salasana ei voi olla yli 50 merkkiä pitkä.';
		}

		return $errors;
	}
}
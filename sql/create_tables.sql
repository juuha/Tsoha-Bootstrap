CREATE TABLE Author(
	id SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL,
	password varchar(50) NOT NULL 
);

CREATE TABLE Story(
	id SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL,
	author_id INTEGER REFERENCES Author(id),
	genre varchar(50),
	synopsis varchar(1000),
  last_edited DATE NOT NULL
);

CREATE TABLE Scene(
	id SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL,
	story_id INTEGER REFERENCES Story(id),
	situation varchar(1000) NOT NULL, --for actual story
	question varchar(250) NOT NULL, --question for choice
	first_scene INTEGER DEFAULT 0
);

CREATE TABLE SceneLink(
	id SERIAL PRIMARY KEY,
	option_name varchar(50) NOT NULL, --for choosing next scene
	parent_scene_id INTEGER REFERENCES Scene(id),
	child_scene_id INTEGER REFERENCES Scene(id)
);

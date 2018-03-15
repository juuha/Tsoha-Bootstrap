--Author-taulun testidata
INSERT INTO Author (name, password) VALUES ('J', 'eihyväsalis');


--Story-taulun testidata
INSERT INTO Story (name, author_id, genre, last_edited, synopsis) VALUES
('Maze', 1, 'Mysteeri', '08.08.2088', 'You wake up in a strange room, with no memory
	on how or why you are there. You only see 4 doors around you and a compass at the
	center of the room. You feel a sense of urgency to get out, something is coming.');


--Scene-taulun testidata
INSERT INTO Scene (name, story_id, question, situation, first_scene) VALUES
('Waking Up', 1, 'What are you going to do?', 'You wake up in a weird 
	room with 4 doors, 1 on each of the walls surrounding you. 
	You see a compass stuck on the floor in the middle of the room. 
	It points north towards the door in front of you. You feel a 
	sense of urgency, but aren''t sure why.', 1);

INSERT INTO Scene (name, story_id, question, situation)  VALUES 
('Door on the Left', 1, 'What will you do?', 'You enter the room and
	see a small wooden crate. It has a skull drawn onto it with, what you
	deem to be, blood. You see a crowbar chained to the ground next to 
	the crate');

INSERT INTO Scene (name, story_id, question, situation) VALUES 
('What''s in the crate (smash)', 1, 'You died from the burns', 'You grip the crowbar
in your hands and slam the crate as hard as you can. You didn''t expect it, 
but the crate exploded with shrapnels made of wood and glass, and splashes of 
glowing liquid. The strange liquid covers you almost entirely and you feel burning
pain. You pass out out from the pain');

INSERT INTO Scene (name, story_id, question, situation) VALUES 
('What''s in the crate (carefully)', 1, 'What do you want to do?', 'You creak open
	the crate and find a glowing orb. It fills the room with bright green light. You
	feel strange power from the orb.');


--SceneLink-taulun testidata
Insert INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES 
('Go through the left door.', 1, 2);

INSERT INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES 
('Smash the crate with the crowbar!', 2, 3);

INSERT INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES
('Pry open the crate carefully with the crowbar.', 2, 4);

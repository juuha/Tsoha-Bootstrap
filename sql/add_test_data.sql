--Author-taulun testidata
INSERT INTO Author (name, password) VALUES ('Testi', 'salis');

--Story-taulun testidata
INSERT INTO Story (name, author_id, genre, last_edited, synopsis) VALUES
('Maze', 1, 'Mysteeri', '08-08-2088', 'You wake up in a strange room, with no memory
	on how or why you are there. You only see 4 doors around you and a compass at the
	center of the room. You feel a sense of urgency to get out, something is coming.');

INSERT INTO Story (name, author_id, genre, last_edited, synopsis) VALUES 
('Example', 1, 'Truly Magnificent', '22-3-2018', 'This is an example story about what
	you can make with this website. It will contain forks, merges, a loop, a dead-end and 
	a hidden scene.');

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

INSERT INTO Scene (name, story_id, question, situation, first_scene) VALUES ('Start 
	of the journey', 2, 'Click Next to continue.', 'This is the start of the story. You will
	have a chance to return here at a later time.', 1);
INSERT INTO Scene (name, story_id, question, situation) VALUES ('The second part of the
	story', 2, 'Which way should we go?', 'This is what the 2nd scene of this story looks like, 
	neat huh? This is the first fork in the story, quite a scary choice we have. Seems like 
	we can visit the 4th part after, if we first go to the 3rd part. Or we could skip the 3rd part entirely.');
INSERT INTO Scene (name, story_id, situation, question) VALUES ('3rd part of the story', 2 ,'Cool, 
	you made the choice of not skipping this bit of the story. Unfortunately for you, there is no
	cool prize for not skipping this scene.', 'Click Continue to progress to scene 4.');
INSERT INTO Scene (name, story_id, situation, question) VALUES ('4th part of the story, loading screen', 
	2, 'Loading, please wait. This is what you get for skipping part 3 of the story. Seems like loading 
	should be done about now.', 'Click Finish loading to progress to part 4.');
INSERT INTO Scene (name, story_id, situation, question) VALUES ('4th part of the story', 2, 
	'Cool, you have arrived at the 4th part of the story, which is the first merge location in the 
	story. The next attraction you will see is the loop, WooOOOooOOO. Don''t be afraid though, 
	we have built an escape hatch in the loop, so you will not be stuck.', 'Go into the loop.');
INSERT INTO Scene (name, story_id, situation, question) VALUES ('The loop, part 1', 2, 
	'So this is a loop, imagined it would be scarier. It doesn''t look like we have much else to 
	do except continue forward in the loop. Or is it even forward if it''s a loop.', 'Continue 
	looping in the loop by clicking Next.');
INSERT INTO Scene (name, story_id, situation, question) VALUES ('The loop, part 2', 2, 
	'This is the 2nd part of the loop. Seems like we can return to the first part of the loop or we 
	can use the not-so-secret escape hatch, on which reads "Totally not an escape hatch".', 'Continue or escape?');
INSERT INTO Scene (name, story_id, situation, question) VALUES ('Seems like we got out of the loop just fine.', 
	2, 'Seems	like we got out of the loop just fine. Seems
	like we got out of the loop just fine. Seems
	like we got out of the loop just fine. Seems
	like we got out of the loop just fine. Seems
	like we got out of the loop just fine. Seems
	like we got out of the loop just fine. Seems
	like we got out of the loop just fine. Seems
	like we got out of the loop just fine. Seems
	like we got out of the loop just fine. Seems 
	like we got out of the loop just fine...', 'Seems like we got out of the loop just fine.');
INSERT INTO Scene (name, story_id, situation, question) VALUES ('Just kiddin'' ', 2, 'I was just
	joking, don''t worry. We''re getting close to the end of the story. You can either go back to the 
	start or go forward to the dead-end, your choice.', 'So, how about it?');
INSERT INTO Scene (name, story_id, situation, question) VALUES ('The end?', 2, 'This is the end of
	the story. Well, at least where I can guide you. If you kept your eye on the counter up top in the 
	URL bar, you might figure out where the "hidden" part of the story is.', 'There''s nowhere to 
	go, this is a dead-end.');
INSERT INTO Scene (name, story_id, situation, question) VALUES ('The Hidden part', 2, 'Congratulations, 
	you found the hidden part of the story. If you got here by accident, I suggest returning to the start 
	of the story by clicking START, or you can just chill here with me.', 'Thanks for reading.');

--SceneLink-taulun testidata
Insert INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES 
('Go through the left door.', 1, 2);

INSERT INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES 
('Smash the crate with the crowbar!', 2, 3);

INSERT INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES
('Pry open the crate carefully with the crowbar.', 2, 4);

INSERT INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES ('Next', 5, 6);
INSERT INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES ('3rd part', 6, 7);
INSERT INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES ('Continue', 7, 9);
INSERT INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES ('Finish loading', 8, 9);
INSERT INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES ('4th part', 6, 8);
INSERT INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES ('Enter the loop', 9, 10);
INSERT INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES ('Next', 10, 11);
INSERT INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES ('Continue',11 ,10);
INSERT INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES ('Escape', 11, 12);
INSERT INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES ('Seems like we got out of the loop just fine.', 12, 13);
INSERT INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES ('Start of the story', 13, 5);
INSERT INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES ('Dead-end', 13, 14);
INSERT INTO SceneLink (option_name, parent_scene_id, child_scene_id) VALUES ('START', 15, 5);

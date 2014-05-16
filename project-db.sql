use cmatulis_db;

drop table if exists likes;
drop table if exists comments;
drop table if exists follows;
drop table if exists profile;
drop table if exists image_posts;
drop table if exists blog_entry;
drop table if exists blog_user;
create table blog_user(
    user varchar(30) primary key,
    pass varchar(30),
    cryp char(41),
    email varchar(50),
    INDEX (user)
)
TYPE = InnoDB;
 
insert into blog_user(user,pass,cryp) values
 ('happy','happy',password('Happy')),
 ('Bashful','Bashful',password('Bashful')),
 ('Grumpy','Grumpy',password('Grumpy')),
 ('Sleepy','Sleepy',password('Sleepy')),
 ('Sneezy','Sneezy',password('Sneezy')),
 ('Dopey','Dopey',password('Dopey')),
 ('Doc','Doc',password('Doc')),
 ('Sleazy','Sleazy',password('Sleazy')),
 ('Gropey','Gropey',password('Gropey')),
 ('Dumpy','Dumpy',password('Dumpy'));
 

create table blog_entry(
       entered timestamp,
       user varchar(30),
       title text,
       entry blob,
       caption text,
       entry_id int not null auto_increment primary key,
       INDEX (entry_id),
       foreign key (user) references blog_user(user))
       TYPE = InnoDB;

create table image_posts(
       entered timestamp,
       user varchar(30),
       title text,
       entry blob,
       caption text,
       image_id int not null auto_increment primary key,
       INDEX (image_id),
       foreign key (user) references blog_user(user))
TYPE = InnoDB;

create table profile(
       user varchar(30),
       profile text,
	fullname text,
	birthdate text,
	city text,
	state text,
	country text,
	interests text,
       foreign key (user) references blog_user(user))
       TYPE = InnoDB;

create table follows(
       user varchar(30),
       following varchar(30),
       foreign key (user) references blog_user(user))
       TYPE = InnoDB;

create table comments(
       entry_id int,
       commenting_user varchar(30),
       comment_time timestamp,
       comment_text text)
	TYPE = InnoDB;

create table likes(
       entry_id int,
       liking_user varchar(30),
       like_time timestamp,
	primary key (entry_id, liking_user))
	TYPE = InnoDB;

INSERT into profile(user, profile, fullname, birthdate, city, state, country, interests) VALUES ('happy',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
('Bashful',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
('Grumpy',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
('Sleepy',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
('Sneezy',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
('Dopey',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
('Doc',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
('Sleazy',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
('Gropey',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
('Dumpy',NULL,NULL,NULL,NULL,NULL,NULL,NULL);

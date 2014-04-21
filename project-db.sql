use cmatulis_db;

drop table if exists follows;
drop table if exists profile;
drop table if exists blog_entry;
drop table if exists blog_user;
create table blog_user(
    user varchar(30) primary key,
    pass varchar(30),
    cryp char(41),
    INDEX (user)
)
TYPE = InnoDB;
 
insert into blog_user(user,pass,cryp) values
 ('Happy','Happy',password('Happy')),
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
       entry text,
       foreign key (user) references blog_user(user))
       TYPE = InnoDB;

create table profile(
       user varchar(30),
       profile text,
       foreign key (user) references blog_user(user))
       TYPE = InnoDB;

insert into profile(user, profile) values
('Happy', 'This is where the user''s profile will go');

create table follows(
       user varchar(30),
       following varchar(30),
       foreign key (user) references blog_user(user))
       TYPE = InnoDB;
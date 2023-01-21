-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 14 2021              
-- * Generation date: Fri Jan 20 19:44:47 2023 
-- * LUN file: \\Mac\Home\Desktop\Database Snapshot.lun 
-- * Schema: daImplementareNotifiche/1-1-1-1-1 
-- ********************************************* 


-- Database Section
-- ________________ 

create database daImplementareNotifiche;
use daImplementareNotifiche;


-- Tables Section
-- _____________ 

create table DEVICE (
     name varchar(20) not null,
     constraint IDDEVICE_ID primary key (name));

create table LOCATION (
     name varchar(20) not null,
     constraint IDLOCATION_ID primary key (name));

create table POST (
     username varchar(20) not null,
     id int not null,
     date date default 'CURRENT_TIMESTAMP' not null,
     description varchar(100) default '''' not null,
     n_loves int default 0 not null,
     n_comments int default 0 not null,
     device varchar(20),
     location varchar(20),
     constraint IDPOST primary key (username, id));

create table COMMENT1 (
     username_post varchar(20) not null,
     id_post int not null,
     id int not null,
     date date default 'CURRENT_TIMESTAMP' not null,
     comment varchar(100) not null,
     n_loves int default 0 not null,
     n_comments char(1) default '0' not null,
     username varchar(20) not null,
     constraint IDPRIMARY COMMENT primary key (username_post, id_post, id));

create table COMMENT2 (
     username_post varchar(20) not null,
     id_post int not null,
     id_comment int not null,
     id int not null,
     date date default 'CURRENT_TIMESTAMP' not null,
     comment char(100) not null,
     n_loves char(1) default '0' not null,
     username varchar(20) not null,
     constraint IDSECONDARY COMMENT primary key (username_post, id_post, id_comment, id));

create table ACCOUNT (
     username varchar(20) not null,
     password char(20) not null,
     icon varchar(20) default '''' not null,
     bio varchar(50) default '''' not null,
     n_posts int default 0 not null,
     n_followers int default 0 not null,
     n_following int default 0 not null,
     constraint IDUSER primary key (username));

create table FOLLOWER (
     follower varchar(20) not null,
     username varchar(20) not null,
     constraint IDFOLLOWER primary key (username, follower));

create table LOVE_COMMENT1 (
     username_post varchar(20) not null,
     id_post int not null,
     id_comment1 int not null,
     username varchar(20) not null,
     constraint IDLOVE_COMMENT1 primary key (username_post, id_post, id_comment1, username));

create table LOVE_COMMENT2 (
     username_post varchar(20) not null,
     id_post int not null,
     id_comment1 int not null,
     id_comment2 int not null,
     username varchar(20) not null,
     constraint IDLOVE_COMMENT2 primary key (username_post, id_post, id_comment1, id_comment2, username));

create table LOVE_POST (
     username_post varchar(20) not null,
     id_post int not null,
     username varchar(20) not null,
     constraint IDLOVE primary key (username_post, id_post, username));


-- Constraints Section
-- ___________________ 

-- Not implemented
-- alter table DEVICE add constraint IDDEVICE_CHK
--     check(exists(select * from POST
--                  where POST.device = name)); 

-- Not implemented
-- alter table LOCATION add constraint IDLOCATION_CHK
--     check(exists(select * from POST
--                  where POST.location = name)); 

alter table POST add constraint FKwith
     foreign key (device)
     references DEVICE (name);

alter table POST add constraint FKfrom
     foreign key (location)
     references LOCATION (name);

alter table POST add constraint FKposted
     foreign key (username)
     references ACCOUNT (username);

alter table COMMENT1 add constraint FKprim com
     foreign key (username)
     references ACCOUNT (username);

alter table COMMENT1 add constraint FKrelative post
     foreign key (username_post, id_post)
     references POST (username, id);

alter table COMMENT2 add constraint FKsecond com
     foreign key (username)
     references ACCOUNT (username);

alter table COMMENT2 add constraint FKrelative comment
     foreign key (username_post, id_post, id_comment)
     references COMMENT1 (username_post, id_post, id);

alter table FOLLOWER add constraint FKfollow
     foreign key (username)
     references ACCOUNT (username);

alter table FOLLOWER add constraint FKfollowed
     foreign key (follower)
     references ACCOUNT (username);

alter table LOVE_COMMENT1 add constraint FKLOV_ACC
     foreign key (username)
     references ACCOUNT (username);

alter table LOVE_COMMENT1 add constraint FKLOV_PRI
     foreign key (username_post, id_post, id_comment1)
     references COMMENT1 (username_post, id_post, id);

alter table LOVE_COMMENT2 add constraint FKR_1_ACC
     foreign key (username)
     references ACCOUNT (username);

alter table LOVE_COMMENT2 add constraint FKR_1_SEC
     foreign key (username_post, id_post, id_comment1, id_comment2)
     references COMMENT2 (username_post, id_post, id_comment, id);

alter table LOVE_POST add constraint FKlik_ACC
     foreign key (username)
     references ACCOUNT (username);

alter table LOVE_POST add constraint FKlik_POS
     foreign key (username_post, id_post)
     references POST (username, id);


-- Index Section
-- _____________ 


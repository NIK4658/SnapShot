-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 14 2021              
-- * Generation date: Fri Jan 13 03:14:39 2023 
-- * LUN file: \\Mac\Home\Desktop\Database Snapshot.lun 
-- * Schema: Snapshot/1-1-1 
-- ********************************************* 


-- Database Section
-- ________________ 

create database Snapshot;
use Snapshot;


-- Tables Section
-- _____________ 

create table POST (
     account int not null,
     id int not null,
     date date not null,
     image varchar(20) not null,
     description varchar(100) not null,
     n_loves int not null,
     n_comments int not null,
     device int,
     location int,
     constraint IDPOST primary key (account, id));

create table NOTIFICATION (
     receiver int not null,
     id int not null,
     account_post_comment int,
     post_comment int,
     id_comment int,
     account_post_comment2 int,
     post_comment2 int,
     comment_comment2 int,
     comment2 int,
     date date not null,
     type int not null,
     sender int not null,
     account_post int,
     id_post int,
     constraint IDNOTIFICATION primary key (receiver, id),
     constraint FKprim unique (account_post_comment, post_comment, id_comment),
     constraint FKsecond unique (account_post_comment2, post_comment2, comment_comment2, comment2));

create table DEVICE (
     id int not null auto_increment,
     name varchar(20) not null,
     constraint IDDEVICE_ID primary key (id),
     constraint IDDEVICE_1 unique (name));

create table LOCATION (
     id int not null auto_increment,
     name varchar(20) not null,
     constraint IDLOCATION_ID primary key (id),
     constraint IDLOCATION_1 unique (name));

create table PRIMARY_COMMENT (
     account_post int not null,
     post int not null,
     id int not null,
     date date not null,
     text varchar(50) not null,
     n_loves int not null,
     n_comments char(1) not null,
     account int not null,
     constraint IDPRIMARY primary key (account_post, post, id));

create table SECONDARY_COMMENT (
     account_post int not null,
     post int not null,
     comment1 int not null,
     id int not null,
     date date not null,
     text char(1) not null,
     n_loves char(1) not null,
     account int not null,
     constraint IDSECONDARY primary key (account_post, post, comment1, id));

create table FOLLOWER (
     following int not null,
     account int not null,
     constraint IDfollower primary key (account, following));

create table LOVE (
     account_post int not null,
     post int not null,
     account int not null,
     constraint IDLIKE primary key (account_post, post, account));

create table ACCOUNT (
     id int not null auto_increment,
     username varchar(20) not null,
     icon varchar(20) not null,
     bio varchar(50) not null,
     n_posts int not null,
     n_followers int not null,
     n_following int not null,
     constraint IDUSER primary key (id),
     constraint IDUSER_1 unique (username));


-- Constraints Section
-- ___________________ 

alter table POST add constraint FKwith
     foreign key (device)
     references DEVICE (id);

alter table POST add constraint FKfrom
     foreign key (location)
     references LOCATION (id);

alter table POST add constraint FKposted
     foreign key (account)
     references ACCOUNT (id);

alter table NOTIFICATION add constraint FKdo
     foreign key (sender)
     references ACCOUNT (id);

alter table NOTIFICATION add constraint FKhas
     foreign key (receiver)
     references ACCOUNT (id);

alter table NOTIFICATION add constraint FKon
     foreign key (account_post, id_post)
     references POST (account, id);

alter table NOTIFICATION add constraint FKprim
     foreign key (account_post_comment, post_comment, id_comment)
     references PRIMARY_COMMENT (account_post, post, id);

alter table NOTIFICATION add constraint FKsecond
     foreign key (account_post_comment2, post_comment2, comment_comment2, comment2)
     references SECONDARY_COMMENT (account_post, post, comment1, id);

-- Not implemented
-- alter table DEVICE add constraint IDDEVICE_CHK
--     check(exists(select * from POST
--                  where POST.device = id)); 

-- Not implemented
-- alter table LOCATION add constraint IDLOCATION_CHK
--     check(exists(select * from POST
--                  where POST.location = id)); 

-- Not implemented
-- alter table PRIMARY_COMMENT add constraint IDPRIMARY COMMENT_CHK
--     check(exists(select * from NOTIFICATION
--                  where NOTIFICATION.account_post_comment = account_post and NOTIFICATION.post_comment = post and NOTIFICATION.id_comment = id)); 

alter table PRIMARY_COMMENT add constraint FKrelative
     foreign key (account_post, post)
     references POST (account, id);

alter table PRIMARY_COMMENT add constraint FKprimm
     foreign key (account)
     references ACCOUNT (id);

-- Not implemented
-- alter table SECONDARY_COMMENT add constraint IDSECONDARY COMMENT_CHK
--     check(exists(select * from NOTIFICATION
--                  where NOTIFICATION.account_post_comment2 = account_post and NOTIFICATION.post_comment2 = post and NOTIFICATION.comment_comment2 = comment1 and NOTIFICATION.comment2 = id)); 

alter table SECONDARY_COMMENT add constraint FKsecondd
     foreign key (account)
     references ACCOUNT (id);

alter table SECONDARY_COMMENT add constraint FKrelativee
     foreign key (account_post, post, comment1)
     references PRIMARY_COMMENT (account_post, post, id);

alter table FOLLOWER add constraint FKfollow
     foreign key (account)
     references ACCOUNT (id);

alter table FOLLOWER add constraint FKfollowed
     foreign key (following)
     references ACCOUNT (id);

alter table LOVE add constraint FKlik_USE
     foreign key (account)
     references ACCOUNT (id);

alter table LOVE add constraint FKlik_POS
     foreign key (account_post, post)
     references POST (account, id);


-- Index Section
-- _____________ 


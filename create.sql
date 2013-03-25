create database bb;
use bb;
drop table  if exists book;
create table book(
	 id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     title NVARCHAR(100) NOT NULL,
     douban_id int ,
     author_id int,
     devote_id int
);

insert into book (title)values("当我们跑步时，我们谈些什么");
insert into book (title)values("悉尼");
insert into book (title)values("联想风云");

insert into book (title,devote_id)values("1000copy book",1);

drop table  if exists user;
create table user(
	 id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     fullname NVARCHAR(100) NOT NULL,
     email varchar(100) ,
     weibo varchar(100) 
);

insert into user (fullname)values("1000copy");
insert into user (fullname)values("良樵");

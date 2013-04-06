# export PATH=$PATH:/usr/local/mysql-5.6.10-osx10.7-x86_64/bin
create database bb;
use bb;
drop table  if exists book;
create table book(
	 id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     title NVARCHAR(100) NOT NULL,
     borrowed int ,
     douban_id int ,
     author_id int,
     devote_id int
);

insert into book (title,borrowed)values("当我们跑步时，我们谈些什么",0);
insert into book (title,borrowed)values("悉尼",0);
insert into book (title,borrowed)values("联想风云",0);

drop table  if exists user;
create table user(
	 id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     fullname NVARCHAR(100) ,
     password varchar(100),
     email varchar(100) ,
     weibo varchar(100) 
);
# password is space (md5..ed)
insert into user (email,password)values("1000copy@gmail.com",'d41d8cd98f00b204e9800998ecf8427e');
insert into user (email,password)values("lqiao@qq.com",'d41d8cd98f00b204e9800998ecf8427e');

drop table  if exists borrowed;
create table borrowed(
     id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     commited int not null default 0,
     user_id int not null,
     book_id int not null
);

drop table  if exists returned;
create table returned(
     id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     commited int not null default 0,
     user_id int not null,
     book_id int not null
);

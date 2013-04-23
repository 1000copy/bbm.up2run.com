
# export PATH=$PATH:/usr/local/mysql-5.6.10-osx10.7-x86_64/bin
# state =(normal,incart,commit,accept,returncommit) 0,1,2,3,4 ,共5种状态

create database bb;
use bb;



drop table  if exists borrow;
create table borrow(
     id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     borrow_user_id int not null,
     devote_user_id int not null,
     w date 
);
drop table  if exists borrow_detail;
create table borrow_detail(
     borrow_id int,
     book_id int not null
);

drop table  if exists book;
create table book(
	 id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     title NVARCHAR(100) NOT NULL,
     state int ,
     douban_id int ,
     author_id int,
     devote_id int,
     borrow_user_id int
);

-- insert into book (title,state)values("当我们跑步时，我们谈些什么",0);
-- insert into book (title,state)values("悉尼",0);
-- insert into book (title,state)values("联想风云",0);

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
insert into user (email,password)values("2392349@qq.com",'d41d8cd98f00b204e9800998ecf8427e');

INSERT INTO book VALUES 
     (1,'失控',0,0,0,1,NULL),
     (2,'追风筝的人',0,0,NULL,1,NULL),
--      (3,'灿烂千阳',0,0,NULL,1,NULL);

-- INSERT INTO book (title,state)VALUES ("some title",0);
-- INSERT INTO book (title,state)VALUES ("some title",0);
-- INSERT INTO book (title,state)VALUES ("some title",0);
-- INSERT INTO book (title,state)VALUES ("some title",0);
-- INSERT INTO book (title,state)VALUES ("some title",0);
-- INSERT INTO book (title,state)VALUES ("some title",0);
-- INSERT INTO book (title,state)VALUES ("some title",0);
-- INSERT INTO book (title,state)VALUES ("some title",0);
-- INSERT INTO book (title,state)VALUES ("some title",0);
-- INSERT INTO book (title,state)VALUES ("some title",0);
-- INSERT INTO book (title,state)VALUES ("some title",0);
-- INSERT INTO book (title,state)VALUES ("some title",0);
-- INSERT INTO book (title,state)VALUES ("some title",0);
-- INSERT INTO book (title,state)VALUES ("some title",0);
-- INSERT INTO book (title,state)VALUES ("some title",0);
-- INSERT INTO book (title,state)VALUES ("some title",0);
-- INSERT INTO book (title,state)VALUES ("some title",0);
-- INSERT INTO book (title,state)VALUES ("some title",0);
-- INSERT INTO book (title,state)VALUES ("some title",0);
-- INSERT INTO book (title,state)VALUES ("some title",0);





# export PATH=$PATH:/usr/local/mysql-5.6.10-osx10.7-x86_64/bin
# state =(normal,borrowing,returning) 0,1,3 ,共3种状态

SET character_set_database = utf8; 
SET character_set_results = utf8;/*这里要注意很有用*/ 
SET collation_database = utf8_bin;

create database bb;
use bb;



drop table  if exists borrow;
create table borrow(
     id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     borrow_user_id int not null,
     devote_user_id int not null,
     w datetime ,
     is_return int default 0 
)  default character set utf8 default COLLATE utf8_bin;;
drop table  if exists borrow_detail;
create table borrow_detail(
     borrow_id int,
     book_id int not null
)  default character set utf8 default COLLATE utf8_bin;;



drop table  if exists book;
create table book(
	 id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     title NVARCHAR(100) NOT NULL,
     state int ,
     douban_img NVARCHAR(100),
     author_id int,
     devote_id int,
     borrow_user_id int
) default character set utf8 default COLLATE utf8_bin;;

-- insert into book (title,state)values("当我们跑步时，我们谈些什么",0);
-- insert into book (title,state)values("悉尼",0);
-- insert into book (title,state)values("联想风云",0);

drop table  if exists user;
create table user(
	 id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     fullname NVARCHAR(100) ,
     password varchar(100),
     notify int ,
     email varchar(100) ,
     weibo varchar(100) 
) default character set utf8 default COLLATE utf8_bin;
# password is space (md5..ed)
insert into user (fullname,email,password,notify)values
("刘传君", "1000copy@gmail.com",'d41d8cd98f00b204e9800998ecf8427e',1),
("顾苏浩", "2392349@qq.com",'d41d8cd98f00b204e9800998ecf8427e',0),
("李亦飞", "2392349@qq.com",'d41d8cd98f00b204e9800998ecf8427e',0),
("梁桥", "2392349@qq.com",'d41d8cd98f00b204e9800998ecf8427e',0);
INSERT INTO book VALUES 
     (1,'失控',0,0,0,1,NULL),
     (2,'追风筝的人',0,0,NULL,1,NULL);

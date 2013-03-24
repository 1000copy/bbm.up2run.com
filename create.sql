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
insert into book (title)values("当我们跑步时，我们谈些什么");
insert into book (title)values("悉尼");
insert into book (title)values("联想风云");
insert into book (title)values("当我们跑步时，我们谈些什么");
insert into book (title)values("悉尼");
insert into book (title)values("联想风云");
insert into book (title)values("当我们跑步时，我们谈些什么");
insert into book (title)values("悉尼");
insert into book (title)values("联想风云");

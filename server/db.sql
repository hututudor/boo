drop table if exists books;

create table books (
  id int not null auto_increment,
  title varchar(256) not null,
  author varchar(256) not null,
  pages int not null,
  PRIMARY KEY (id)
);

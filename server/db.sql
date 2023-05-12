drop table if exists books;

create table books (
  id int not null auto_increment,
  image varchar(256),
  title varchar(256) not null,
  author varchar(256) not null,
  book_description varchar(5000) not null,
  pages int not null,
  isbn varchar(256) not null,
  genre varchar(256) not null,
  publisher varchar(256) not null,
  format varchar(256) not null,
  publication_date DATE,
  PRIMARY KEY (id)
);

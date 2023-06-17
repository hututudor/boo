drop table if exists books;
drop table if exists users;
drop table if exists reviews;

create table books (
  id int not null auto_increment,
  image varchar(256),
  title varchar(256) not null,
  author varchar(256) not null,
  description varchar(5000) not null,
  pages int not null,
  isbn varchar(256) not null,
  genre varchar(256) not null,
  publisher varchar(256) not null,
  format varchar(256) not null,
  publication_date varchar(256),
  PRIMARY KEY (id)
);

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
full_name VARCHAR(255) NOT NULL,
email VARCHAR(255) UNIQUE NOT NULL,
password VARCHAR(255) NOT NULL,
is_admin BOOLEAN DEFAULT FALSE
);

CREATE TABLE reviews (
  id INT AUTO_INCREMENT PRIMARY KEY,
  book_id INT,
  user_id INT,
  content VARCHAR(1000) NOT NULL,
  review_date varchar(256),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

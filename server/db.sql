drop table if exists books;
drop table if exists users;

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

CREATE OR REPLACE TABLE user_books
(
    id      INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    status  ENUM ('want to read', 'reading', 'read', 'didn''t read') NOT NULL,
    CONSTRAINT user_books_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id),
    CONSTRAINT user_books_ibfk_2 FOREIGN KEY (book_id) REFERENCES books (id),
    CONSTRAINT unique_user_book_pair UNIQUE (user_id, book_id)
);

CREATE INDEX book_id ON user_books (book_id);
CREATE INDEX user_id ON user_books (user_id);
drop table if exists books;
drop table if exists users;
drop table if exists user_books;
drop table if exists reviews;
drop table if exists user_books;
drop table if exists rss_books;
drop table if exists questions;
drop table if exists replies;

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

CREATE TABLE user_books
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    status ENUM ('want to read', 'reading', 'read', 'didn''t read') NOT NULL,
    last_seen_review_id INT,
    CONSTRAINT user_books_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT user_books_ibfk_2 FOREIGN KEY (book_id) REFERENCES books (id) ON DELETE CASCADE,
    CONSTRAINT user_books_ibfk_3 FOREIGN KEY (last_seen_review_id) REFERENCES reviews (id) ON DELETE CASCADE,
    CONSTRAINT unique_user_book_pair UNIQUE (user_id, book_id)
);

CREATE INDEX book_id ON user_books (book_id);
CREATE INDEX user_id ON user_books (user_id);


CREATE TABLE reviews (
  id INT AUTO_INCREMENT PRIMARY KEY,
  book_id INT,
  user_id INT,
  content VARCHAR(1000) NOT NULL,
  review_date varchar(256),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

CREATE TABLE rss_books
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,
    last_seen_book_id INT,
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT fk_book FOREIGN KEY (last_seen_book_id) REFERENCES books (id) ON DELETE CASCADE
);

CREATE TRIGGER user_added_trigger
    AFTER INSERT ON users
    FOR EACH ROW
BEGIN
    DECLARE last_book_id INT;

    SELECT MAX(id) INTO last_book_id FROM books;

    INSERT INTO rss_books (user_id, last_seen_book_id)
    VALUES (NEW.id, last_book_id);
END

CREATE TABLE questions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  title VARCHAR(250),
  content VARCHAR(1000),
  date VARCHAR(250),
  view_count INT,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE replies (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  question_id INT,
  content VARCHAR(1000),
  date VARCHAR(250),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
);

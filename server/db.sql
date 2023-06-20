drop table if exists books;
drop table if exists users;
drop table if exists reviews;
drop table if exists user_books;

create table books (
  id int not null auto_increment,
  updated_at timestamp default current_timestamp on update current_timestamp,
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
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
full_name VARCHAR(255) NOT NULL,
email VARCHAR(255) UNIQUE NOT NULL,
password VARCHAR(255) NOT NULL,
is_admin BOOLEAN DEFAULT FALSE
);

CREATE TABLE user_books
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    user_id INT,
    last_seen_book_id INT,
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT fk_book FOREIGN KEY (last_seen_book_id) REFERENCES books (id) ON DELETE CASCADE
);

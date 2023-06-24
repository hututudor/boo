DROP DATABASE IF EXISTS `boo`;
CREATE DATABASE `boo`;
USE `boo`;
DROP TABLE IF EXISTS books;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS rss_books;
DROP TABLE IF EXISTS questions;
DROP TABLE IF EXISTS replies;

CREATE TABLE books (
                       id INT NOT NULL AUTO_INCREMENT,
                       image VARCHAR(256),
                       title VARCHAR(256) NOT NULL,
                       author VARCHAR(256) NOT NULL,
                       description VARCHAR(5000) NOT NULL,
                       pages INT NOT NULL,
                       isbn VARCHAR(256) NOT NULL,
                       genre VARCHAR(256) NOT NULL,
                       publisher VARCHAR(256) NOT NULL,
                       format VARCHAR(256) NOT NULL,
                       publication_date VARCHAR(256),
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
                         review_date VARCHAR(256),
                         FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                         FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

CREATE TABLE rss_books (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           user_id INT UNIQUE,
                           last_seen_book_id INT,
                           CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                           CONSTRAINT fk_book FOREIGN KEY (last_seen_book_id) REFERENCES books(id) ON DELETE CASCADE
);

DELIMITER //
CREATE TRIGGER user_added_trigger
    AFTER INSERT ON users
    FOR EACH ROW
BEGIN
    DECLARE last_book_id INT;
    SELECT MAX(id) INTO last_book_id FROM books;
    INSERT INTO rss_books (user_id, last_seen_book_id)
    VALUES (NEW.id, last_book_id);
END//
DELIMITER ;

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

CREATE TABLE user_books (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            user_id INT NOT NULL,
                            book_id INT NOT NULL,
                            STATUS ENUM ('want to read', 'reading', 'read', 'didn''t read') NOT NULL,
                            last_seen_review_id INT,
                            CONSTRAINT user_books_ibfk_1 FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                            CONSTRAINT user_books_ibfk_2 FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
                            CONSTRAINT user_books_ibfk_3 FOREIGN KEY (last_seen_review_id) REFERENCES reviews(id) ON DELETE CASCADE,
                            CONSTRAINT unique_user_book_pair UNIQUE (user_id, book_id)
);

CREATE INDEX book_id ON user_books (book_id);
CREATE INDEX user_id ON user_books (user_id);

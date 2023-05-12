drop table if exists books;
drop table if exists users;

create table books (
  id int not null auto_increment,
  title varchar(256) not null,
  author varchar(256) not null,
  pages int not null,
  PRIMARY KEY (id)
);

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
full_name VARCHAR(255) NOT NULL,
email VARCHAR(255) UNIQUE NOT NULL,
password VARCHAR(255) NOT NULL,
is_admin BOOLEAN DEFAULT FALSE
);
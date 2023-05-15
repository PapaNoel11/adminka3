CREATE TABLE categories (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE products (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category_id INT(11) NOT NULL,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

ALTER TABLE users ADD COLUMN role VARCHAR(10) NOT NULL DEFAULT 'user';

ALTER TABLE products ADD COLUMN show_date DATE;

CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
 FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE cart ADD quantity INT NOT NULL DEFAULT 1 AFTER price;

CREATE TABLE user (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(30) NOT NULL,
  surname VARCHAR(30) NOT NULL,
  patronymic VARCHAR(30),
  login VARCHAR(30) NOT NULL,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL
);
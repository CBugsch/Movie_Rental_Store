DROP TABLE IF EXISTS `transaction_details`;
DROP TABLE IF EXISTS `rental_details`;
DROP TABLE IF EXISTS `rental`;
DROP TABLE IF EXISTS `inventory`;
DROP TABLE IF EXISTS `employee`;
DROP TABLE IF EXISTS `transaction`;
DROP TABLE IF EXISTS `dvd`;
DROP TABLE IF EXISTS `store`;
DROP TABLE IF EXISTS `customer`;

CREATE TABLE `dvd` (
  `id` INT AUTO_INCREMENT NOT NULL ,
  `title` VARCHAR(255) NOT NULL,
  `year` INT(4),
  `rating` VARCHAR(5) NOT NULL ,
  `genre` VARCHAR(255) NOT NULL ,
  `length`  INT,
  PRIMARY KEY (`id`)
)ENGINE = InnoDB;

CREATE TABLE `customer` (
  `id` INT AUTO_INCREMENT,
  `fname` VARCHAR(255) NOT NULL,
  `lname` VARCHAR(255) NOT NULL,
  `pnum`  VARCHAR(20),
  PRIMARY KEY (`id`),
  UNIQUE KEY (`fname`, `lname`)
)ENGINE = InnoDB;

CREATE TABLE `store` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `city` VARCHAR(255) NOT NULL,
  `pnum` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE  = InnoDB;

CREATE TABLE `rental` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `cost` INT NOT NULL,
  `length`  INT NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE = InnoDB;

CREATE TABLE `rental_details`(
  `id` INT AUTO_INCREMENT NOT NULL,
  `did` INT NOT NULL ,
  `rid` INT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`did`) REFERENCES `dvd` (`id`) ON UPDATE CASCADE ON DELETE CASCADE ,
  FOREIGN KEY (`rid`) REFERENCES `rental` (`id`)
)ENGINE  InnoDB;

CREATE TABLE `transaction` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `sid` INT NOT NULL,
  `cid` INT NOT NULL,
  `date` DATE NOT NULL,
  PRIMARY KEY  (`id`),
  FOREIGN KEY  (`cid`) REFERENCES  `customer` (`id`),
  FOREIGN KEY  (`sid`) REFERENCES  `store` (`id`)
) ENGINE InnoDB;

CREATE TABLE `transaction_details` (
  `tid` INT NOT NULL,
  `rid` INT NOT NULL,
  PRIMARY KEY (`tid`, `rid`),
  FOREIGN KEY (`tid`) REFERENCES `transaction` (`id`),
  FOREIGN KEY (`rid`) REFERENCES `rental_details` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE InnoDB;

CREATE TABLE `inventory` (
  `did`  INT NOT NULL,
  `quantity`  INT NOT NULL,
  `sid` INT NOT NULL,
  PRIMARY KEY (`did`, `sid`),
  FOREIGN KEY (`did`) REFERENCES `dvd` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (`sid`) REFERENCES `store` (`id`)
)ENGINE  = InnoDB;

CREATE TABLE `employee` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `fname` VARCHAR(20) NOT NULL,
  `lname` VARCHAR(20) NOT NULL ,
  `pnum` VARCHAR(20),
  `sid` INT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`sid`) REFERENCES `store` (`id`)
)ENGINE InnoDB;


INSERT INTO `dvd`(`title`, `year`, `rating`, `genre`, `length`)
VALUES

  ('The Godfather', '1972', 'R', 'Drama', '177'),

  ('The Shawshank Redemption', '1994', 'R', 'Drama', '142'),

  ('The Notebook', '2004', 'PG13', 'Romance', '124');

INSERT INTO `customer`(`fname`, `lname`, `pnum`)
VALUES

  ('Will', 'Smith', '(206)532-1952'),

  ('Bob', 'Jones', '(603)924-0989'),

  ('Rachel', 'McAdams', '(425)516-8764');

INSERT INTO `store` (city, pnum) VALUES
  ('Seattle', '(206)641-5723'),
  ('Tacoma', '(253)517-2310');

INSERT INTO `rental`(`cost`, `length`)
VALUES

  ('1', '1'),
  ('2', '3'),
  ('3', '4');

INSERT INTO `rental_details` (did, rid) VALUES
  ('1', '1'),
  ('1', '3'),
  ('2', '2'),
  ('3', '1'),
  ('3', '2');

INSERT INTO `transaction` (cid, sid, date) VALUES
  ('1', '1', '2016-11-02'),
  ('1', '2', '2016-11-05'),
  ('2', '1', '2016-11-05'),
  ('2', '2', '2016-11-07'),
  ('3', '1', '2017-11-07'),
  ('3', '2', '2016-11-09');

INSERT INTO `transaction_details` (tid, rid) VALUES
  ('1', '1'),
  ('1', '3'),
  ('2', '1'),
  ('3', '2'),
  ('4', '3'),
  ('5', '1'),
  ('6', '2');

INSERT INTO `inventory` (did, quantity, sid) VALUES
  ('1', '3', '1'),
  ('2', '2', '1'),
  ('3', '2', '1'),
  ('1', '2', '2'),
  ('2', '2', '2'),
  ('3', '3', '2');

INSERT INTO `employee` (fname, lname, sid) VALUES
  ('John', 'Smith', '1'),
  ('George', 'Washington', '1'),
  ('Mario', 'Kart', '1'),
  ('Chelsea', 'Morgan', '2'),
  ('Lily', 'Allen', '2'),
  ('Katie', 'Morris', '2');







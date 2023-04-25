-- BOOKLY OPARATIONS in database


-- --------------------- SQL DOCTOR TABLE ----------------------------

DROP TABLE IF EXISTS `mv_doctor`;

CREATE TABLE `mv_doctors` (
    `id` BIGINT(10) UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `first_name` VARCHAR(30) NOT NULL,
    `last_name` VARCHAR(40) NOT NULL,
    `gender` ENUM('Masculino', 'Femenino') NOT NULL,
    `email` VARCHAR(60) NOT NULL UNIQUE,
    `avatar` VARCHAR(100) NOT NULL,
    `position` VARCHAR(60) NOT NULL,
	`time_start` TIME NOT NULL,
	`time_end` TIME NOT NULL,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	`updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



-- --------------------- SQL CLIENT TABLE ----------------------------

DROP TABLE IF EXISTS `mv_customer`;

CREATE TABLE `mv_customers` (
    `id` BIGINT(10) UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT PRIMARY key,
    `name` VARCHAR(128) NOT null,
    `phone` VARCHAR(128) NOT null,
    `email` VARCHAR(135) NOT null,
    `address` VARCHAR(300) DEFAULT null,
    `note` MEDIUMTEXT default NULL,
    `paid` DECIMAL(15,2) not null,
	`created_from` ENUM('System', 'Website') NOT NULL DEFAULT 2,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------- SQL SCHEDULE TABLE ----------------------------

DROP TABLE IF EXISTS `mv_schedule`;

CREATE TABLE `mv_appointments` (
    `id` BIGINT(20) UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `from` TIMESTAMP NOT NULL,
    `to` TIMESTAMP NOT NULL,
    `doctor` BIGINT(10) UNSIGNED,
    `customer` BIGINT(10) UNSIGNED,
    `service` BIGINT(20) UNSIGNED,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (doctor) REFERENCES `mv_doctor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (customer) REFERENCES `mv_customer`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- BASIC OPERATIONS

-- --------------------- SQL DOCTOR ----------------------------

-- SHOW DATABASE ENTITIES 

describe mv_doctor;


-- FIND ALL

SELECT *, CONCAT(first_name, ' ', last_name) as fullname FROM mv_doctor;

-- FIND BY ID

SELECT *, CONCAT(first_name, ' ', last_name) as fullname FROM mv_doctor WHERE id = 2;

-- CREATE NEW DOCTOR 

INSERT INTO mv_doctor (first_name, last_name, gender, email, avatar, position, time_start, time_end) VALUES (?, ?, ?, ?, ?, ?, ?, ?);

-- UPDATE DOCTOR 

UPDATE mv_doctor SET fist_name = ?, last_name = ?, gender = ?, email = ?, avatar = ?, position = ?, time_start = ?, time_end = ? WHERE id = 2;



-- --------------------- SQL CUSTOMER ----------------------------

-- SHOW DATABASE ENTITIES 

describe mv_customer;


-- FIND ALL

SELECT * FROM mv_customer;

-- FIND BY ID

SELECT * FROM mv_cutomer WHERE id = ?;

-- CREATE NEW DOCTOR 

INSERT INTO mv_customer (phone, name, email, address, note, paid) VALUES (?, ?, ?, ?, ?, ?);

-- UPDATE DOCTOR 

UPDATE mv_customer SET phone = ?, name = ?, email = ?, address = ?, note = ?, paid = ?  WHERE id = ?;


-- --------------------- SQL SCHEDULE ----------------------------

-- SHOW DATABASE ENTITIES 

describe mv_schedule;

-- FIND ALL

SELECT * FROM mv_schedule;

-- FIND BY ID

SELECT * FROM mv_schedule WHERE id = ?;

-- CREATE NEW DOCTOR 

INSERT INTO mv_schedule (`from`, `to`, `doctor`, `customer`, `service`) VALUES (?, ?, ?, ?, ?);

-- UPDATE DOCTOR 

UPDATE mv_schedule SET `from` = ?, `to` = ?, `doctor` = ?, `customer` = ?, `service` = ?  WHERE id = ?;





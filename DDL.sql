DROP DATABASE IF EXISTS car_rental_system;
CREATE DATABASE car_rental_system;
USE car_rental_system;

CREATE TABLE office
(
    office_id   INT PRIMARY KEY AUTO_INCREMENT,
    country     VARCHAR(255) NOT NULL,
    city        VARCHAR(255)  NOT NULL,
    `location`        VARCHAR(255)  NOT NULL
);

CREATE TABLE car
(
    plate_id       VARCHAR(255) PRIMARY KEY,
    model          VARCHAR(255) NOT NULL,
    `year`         INT NOT NULL,
    price_per_day  FLOAT NOT NULL,
    `status`       VARCHAR(255) NOT NULL,
    colour         VARCHAR(255) NOT NULL,
    power          INT NOT NULL,
    `automatic`    CHAR(1) NOT NULL,
    tank_capacity  FLOAT NOT NULL,
    office_id      INT,
    img            TEXT NOT NULL,
    FOREIGN KEY (office_id) REFERENCES office (office_id) 
);

CREATE TABLE user
(
    ssn        INT PRIMARY KEY AUTO_INCREMENT,
    fname      VARCHAR(255) NOT NULL,
    lname      VARCHAR(255) NOT NULL,
    phone      VARCHAR(255) UNIQUE NOT NULL,
    email      VARCHAR(255) UNIQUE NOT NULL,
    pass       VARCHAR(255) NOT NULL,
    sex        CHAR(1) NOT NULL,
    DOB        DATE NOT NULL
);

CREATE TABLE admin
(
    ssn        INT PRIMARY KEY AUTO_INCREMENT,
    fname      VARCHAR(255) NOT NULL,
    Lname      VARCHAR(255) NOT NULL,
    email      VARCHAR(255) UNIQUE NOT NULL,
    pass       VARCHAR(255) NOT NULL
);

CREATE TABLE reservation
(
    plate_id            VARCHAR(255),
    ssn                 INT,
    reservation_number  INT  AUTO_INCREMENT,
    reservation_time    DATE NOT NULL,
    pickup_office_id    INT,
    return_office_id    INT,
    pickup_time         DATE NOT NULL,
    return_time         DATE NOT NULL,
    payment_date        DATE,
    payment_method      VARCHAR(255) NOT NULL,
    FOREIGN KEY (plate_id) REFERENCES car (plate_id) ON DELETE CASCADE ,
    FOREIGN KEY (ssn) REFERENCES `user` (ssn) ON DELETE CASCADE ,
    FOREIGN KEY (pickup_office_id) REFERENCES office (office_id),
    FOREIGN KEY (return_office_id) REFERENCES office (office_id),
    PRIMARY KEY (reservation_number)
);

CREATE TABLE payment_details
(
    card_number         VARCHAR(16) ,
    cardholder_name     VARCHAR(255) NOT NULL,
    expiration_date     DATE NOT NULL,
    cvv                 VARCHAR(3) NOT NULL,
    reservation_number  INT,
    PRIMARY KEY (card_number,reservation_number),
    FOREIGN KEY (reservation_number) REFERENCES reservation (reservation_number) ON DELETE CASCADE 
);

CREATE EVENT IF NOT EXISTS event_1
ON SCHEDULE EVERY 1 DAY
STARTS TIMESTAMP(CURRENT_DATE, '23:59:00')
DO
DELETE FROM reservation WHERE pickup_time<=CURRENT_DATE AND payment_date=NULL;


CREATE EVENT IF NOT EXISTS event_check_reservation_status
ON SCHEDULE EVERY 1 DAY
STARTS TIMESTAMP(CURRENT_DATE, '00:01:00')
DO
    DELETE FROM reservation
    WHERE plate_id IN (
        SELECT c.plate_id
        FROM car c
        JOIN reservation r ON c.plate_id = r.plate_id
        WHERE c.status = 'out_of_service'
          AND r.pickup_time = DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)
    );

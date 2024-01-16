

INSERT INTO office (country, city, `location`) VALUES
('France','Paris','Louvre'),
('France','Lyon','Arrondissement'),
('Egypt','Alexandria','Smouha'),
('Egypt','Alexandria','Loran'),
('Egypt','Alexandria','Sporting'),
('Egypt','Cairo','Madinty'),
('Egypt','Cairo','6th_Octoper'),
('Egypt','Cairo','Pyramids'),
('USA', 'New York', 'Times Square'),
('Germany', 'Berlin', 'Alexanderplatz'),
('Japan', 'Tokyo', 'Shinjuku'),
('Canada', 'Toronto', 'Downtown'),
('Australia', 'Sydney', 'Opera House');




INSERT INTO car (plate_id, model, `year`, price_per_day, `status`, colour, power, `automatic`, tank_capacity, office_id, img) VALUES
('H6HYU', 'BMW 3-Series G20', 2020, 200, 'active', 'blue', 140, 'T', 50, 1, 'blueBMW.jpg'),
('D7RKU', 'Hyundai i20', 2019, 280, 'active', 'blue', 140, 'T', 50, 1, 'blueHyundai.jpg'),
('A3SKD', 'Kia Rio', 2018, 100, 'out_of_service', 'white', 140, 'T', 50, 2, 'whiteKIA.jpg'),
('C9ASD', 'Nissan Sunny', 2017, 250, 'active', 'grey', 140, 'F', 50, 3, 'greyNissan.jpg'),
('X5R3P', 'Mercedes-Benz E-Class', 2022, 300, 'active', 'black', 180, 'T', 60, 2, 'product-4-720x480.jpg'),
('J8R4L', 'Toyota Camry', 2021, 250, 'active', 'silver', 150, 'F', 55, 1, 'offer-4-720x480.jpg'),
('U2R5Z', 'Ford Mustang', 2023, 350, 'active', 'red', 250, 'T', 70, 3, 'offer-2-720x480.jpg'),
('K1R7Q', 'Volkswagen Golf', 2020, 180, 'active', 'white', 120, 'F', 50, 4, 'product-6-720x480.jpg'),
('M3R9X', 'Audi Q5', 2022, 400, 'out_of_service', 'bink', 200, 'T', 65, 5, 'offer-5-720x480.jpg');





INSERT INTO user (fname, lname, phone, email, pass, sex, DOB) VALUES
('ali', 'mohamed', '015555555', 'a@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'M', '1998-03-05'),
('rana', 'Sameh', '01222222', 'rana@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'F', '2000-09-18'),
('menna', 'magdy', '0111111111', 'menna@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'F', '1996-11-03'),
('salma', 'Mohamed', '01000000000', 'salma@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'F', '2001-05-15'),
('rowan', 'reda', '01112706831', 'rowanreda34@gmail.com', '8b68f5378a9981eed4d14e4560b32613', 'F', '2003-03-10');





INSERT INTO admin (fname,Lname, email, pass) VALUES
('mohamed', 'ahmed','mohamed@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
('reem','mohamed','reem@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
('farid','ali','farid@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
('mariam','magdy', 'mariam@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055');


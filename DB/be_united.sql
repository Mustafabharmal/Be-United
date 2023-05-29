

USE be_united;

CREATE TABLE Login_form_user (
  U_id INT PRIMARY KEY auto_increment,
  Email VARCHAR(255),
  Password VARCHAR(255),
  Username VARCHAR(255),
  name varchar(255),
  status varchar(255)
);

CREATE TABLE Login_form_admin (
  A_id INT PRIMARY KEY auto_increment,
  Email VARCHAR(255),
  Password VARCHAR(255),
  Username VARCHAR(255),
  name varchar(255),
  status varchar(255)
);



CREATE TABLE Products (
  P_id INT PRIMARY KEY auto_increment,
  price FLOAT,
  p_name VARCHAR(255),
   p_photo LONGBLOB,
  description VARCHAR(255)
);

CREATE TABLE Sales (
  U_id INT,
  Fname VARCHAR(255),
  Quantity INT,
  lname VARCHAR(255),
  price FLOAT,
  O_id INT PRIMARY KEY,
  status VARCHAR(255),
  timestamp TIMESTAMP
);


INSERT INTO Sales (U_id, Fname, Quantity, lname, price, O_id, status, timestamp)
VALUES
(1, 'John', 10, 'Doe', 50.5, 1001, 'pending', NOW()),
(2, 'Jane', 5, 'Doe', 25.0, 1002, 'approved', NOW()),
(3, 'Alice', 3, 'Smith', 12.75, 1003, 'rejected', NOW()),
(4, 'Bob', 8, 'Johnson', 40.0, 1004, 'pending', NOW()),
(5, 'Mary', 2, 'Davis', 10.0, 1005, 'approved', NOW());

CREATE TABLE Cart (
  P_id INT,
  U_id INT,
  price FLOAT,
  p_name VARCHAR(255),
  p_photo LONGBLOB
);

CREATE TABLE Points (
  U_id INT ,
  available_points INT
);
insert into Points(U_id,available_points) values(1,200);
CREATE TABLE Balance (
  U_id INT,
  Available_balance FLOAT
);

insert into Balance (U_id, Available_balance)
values ( 1, 3000.00),
(2, 5000.00);

CREATE TABLE Redemption_history (
  P_id INT,
  U_id INT,
  Price FLOAT,
  Status VARCHAR(255),
  P_name VARCHAR(255),
  p_photo LONGBLOB,
  timestamp TIMESTAMP
);

use be_united;
select * from sales;
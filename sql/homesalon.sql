DROP DATABASE IF EXISTS HomeSalonApp_Practice;
CREATE DATABASE HomeSalonApp_Practice;

USE HomeSalonApp_Practice;

CREATE TABLE Users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    password VARCHAR(50) NOT NULL,
    role VARCHAR(10) NOT NULL,
    firstName VARCHAR(20) NOT NULL,
    lastName VARCHAR(20) NOT NULL,
    profilePic VARCHAR(100) DEFAULT '',
    signUpDate DATE NOT NULL,
    gender VARCHAR(10) NOT NULL,
    phoneNumber VARCHAR(20) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE Stylists (
    userID INT NOT NULL,
    professionalExperience INT DEFAULT 0,
    rating INT DEFAULT 0,
    serviceLocation VARCHAR(10) DEFAULT '',
    category VARCHAR(10) DEFAULT '',
    priceList VARCHAR(100) DEFAULT '',
    portfolio VARCHAR(100) DEFAULT '',
    FOREIGN KEY (userID) REFERENCES Users(userID)
    ON DELETE CASCADE
);

CREATE TABLE Customers (
    userID INT NOT NULL,
    address VARCHAR(50) DEFAULT '',
    FOREIGN KEY (userID) REFERENCES Users(userID)
    ON DELETE CASCADE
);

INSERT INTO Users (password, role, firstName, lastName, 
profilePic, signUpDate, gender, phoneNumber, email)
VALUES
("123", "stylist", "Popo", "Haung", "", "2020-11-12", "male", "123456789", "pokai@email.com"), 
("123", "stylist", "Harleen", "Jhamat", "", "2020-11-13", "female", "123456789", "harleen@email.com"),
("123", "customer", "Egg", "Coffee", "", "2020-11-13", "male", "123456789", "egg@email.com"),
("123", "customer", "Ben", "Wood", "", "2020-11-13", "male", "123456789", "ben@email.com");

INSERT INTO Stylists (userID, professionalExperience, rating, serviceLocation,
category, priceList, portfolio)
VALUES
(1, 10, 5.0, "vancouver", "hair", "hair - $100", ""),
(2, 10, 5.0, "surrey", "hair", "hair - $101", "");

INSERT INTO Customers (userID, address)
VALUES
(3, "1234 Victory Rd"),
(4,"2345 Deep Rd");

-- Create the database
CREATE DATABASE IF NOT EXISTS UniversityEventSite;
USE UniversityEventSite;

CREATE TABLE Universities (
    UniversityID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Location VARCHAR(255) NOT NULL,
    Description TEXT,
    StudentNum INT,
	SuperAdminID INT,
    ImageURL VARCHAR(255)
);
CREATE TABLE Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    FullName VARCHAR(255) NOT NULL,
    UniversityID INT,
    IsAdmin BOOLEAN,
    FOREIGN KEY (UniversityID) REFERENCES Universities(UniversityID)
);

ALTER TABLE Universities
ADD FOREIGN KEY (SuperAdminID) REFERENCES Users(UserID);

CREATE TABLE RSOs (
    RSOID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Description VARCHAR(512) NOT NULL,
    UniversityID INT,
    ImageURL VARCHAR(512),
    FOREIGN KEY (UniversityID) REFERENCES Universities(UniversityID)
);
CREATE TABLE RSOMembers (
    UserID INT,
    RSOID INT,
    PRIMARY KEY (UserID, RSOID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (RSOID) REFERENCES RSOs(RSOID)
);
CREATE TABLE Admin (
    UserID INT,
    RSOID INT,
    PRIMARY KEY (UserID, RSOID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (RSOID) REFERENCES RSOs(RSOID)
);
CREATE TABLE Locations (
    LocationID INT AUTO_INCREMENT PRIMARY KEY,
    Place VARCHAR(255) NOT NULL,
    Latitude DECIMAL(9,6) NOT NULL,
    Longitude DECIMAL(9,6) NOT NULL
);
CREATE TABLE Events (
    EventID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Category VARCHAR(255) NOT NULL,
    Description TEXT,
    Time TIME NOT NULL,
    Date DATE NOT NULL,
    LocationID INT,
    ContactPhone VARCHAR(20),
    ContactEmail VARCHAR(255),
    EventType ENUM('public', 'private', 'rso') NOT NULL,
    RSOID INT,
    UniversityID INT,
    Approved BOOLEAN,
    FOREIGN KEY (LocationID) REFERENCES Locations(LocationID),
    FOREIGN KEY (RSOID) REFERENCES RSOs(RSOID),
    FOREIGN KEY (UniversityID) REFERENCES Universities(UniversityID)
);
CREATE TABLE Comments (
    CommentID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    EventID INT,
    Context TEXT NOT NULL,
    Timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Rating INT,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (EventID) REFERENCES Events(EventID)
);
ALTER TABLE Comments
ADD CONSTRAINT check_rating_range CHECK (Rating BETWEEN 1 AND 5);

ALTER TABLE Universities
ADD CONSTRAINT unique_admin UNIQUE (SuperAdminID);

-- Create the database
CREATE DATABASE RandomNumberDatabase;

-- Use the database
USE RandomNumberDatabase;

-- Create the table
CREATE TABLE RandomNumbers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    value INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert a value into the table
INSERT INTO RandomNumbers (value) VALUES ();
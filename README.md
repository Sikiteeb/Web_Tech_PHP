# Web Technologies Coursework

This repository contains the exercises and homeworks for the ICD0007 Web Technologies course at TalTech

## Prerequisites 

- PHP
- MySQL database
- Composer

## Installing dependencies 
```
composer install
```
## Create the .env file at the root of the project
```
DB_HOST=your_database_host
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
DB_NAME=your_database_name

```

## Create the database
```
CREATE DATABASE IF NOT EXISTS your_database_name;
USE your_database_name;
```
### Create the *employees* table

```
CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255) NOT NULL,
    position VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255) DEFAULT 'missing.png'
);

```
### Create the *tasks* table
```
CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description TEXT NOT NULL,
    estimate INT NOT NULL,
    isCompleted BOOLEAN NOT NULL,
    employeeId INT,
    FOREIGN KEY (employeeId) REFERENCES employees(id) ON DELETE SET NULL
);

```


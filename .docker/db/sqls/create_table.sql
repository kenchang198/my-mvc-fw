DROP DATABASE IF EXISTS sample;

CREATE DATABASE sample;

USE sample;

CREATE TABLE test_tb(
    id INT AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    body VARCHAR(1000) ,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    PRIMARY KEY(id)
);
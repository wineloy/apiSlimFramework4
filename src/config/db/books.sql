CREATE DATABASE books;

USE books;

CREATE TABLE books(
    id_book int primary key auto_increment,
    Title varchar(150) not null,
    Author varchar(250) not null,
    Price decimal(10,0) not null
);
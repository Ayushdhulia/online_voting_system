-- SQL Script for Online Voting System

CREATE DATABASE IF NOT EXISTS voting_db;
USE voting_db;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    has_voted TINYINT(1) DEFAULT 0
);

-- Parties table
CREATE TABLE IF NOT EXISTS parties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    party_name VARCHAR(100) NOT NULL,
    vote_count INT DEFAULT 0
);

-- Seed parties
INSERT INTO parties (party_name) VALUES ('BJP');
INSERT INTO parties (party_name) VALUES ('Congress');
INSERT INTO parties (party_name) VALUES ('Aam Aadmi Party');
INSERT INTO parties (party_name) VALUES ('Bahujan Samaj Party');
INSERT INTO parties (party_name) VALUES ('Communist Party of India');

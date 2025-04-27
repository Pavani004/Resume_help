CREATE DATABASE IF NOT EXISTS resume_analyzer;

USE resume_analyzer;

CREATE TABLE resume_scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    resume_id VARCHAR(255) UNIQUE NOT NULL,
    score FLOAT NOT NULL,
    suggestions TEXT
);

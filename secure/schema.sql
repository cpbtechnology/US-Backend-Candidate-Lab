CREATE DATABASE IF NOT EXISTS cpNotes;

USE cpNotes;

DROP TABLE IF EXISTS notes;

CREATE TABLE notes
(
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(255),
    description BLOB,
    PRIMARY KEY (id)
);

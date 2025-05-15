-- Crea il database
CREATE DATABASE IF NOT EXISTS clinica;
USE clinica;
DROP TABLE medici;

-- Crea la tabella users
CREATE TABLE users (
	name VARCHAR(100) NOT NULL,
    surname VARCHAR(100) NOT NULL,
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefono VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Crea la tabella medici
CREATE TABLE medici (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    specializzazione VARCHAR(100) NOT NULL
);

-- Crea la tabella appuntamenti
CREATE TABLE prenotazioni (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    medico_id INT NOT NULL,
    data_prenotazione DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (medico_id) REFERENCES medici(id) ON DELETE CASCADE
);

-- Popola la tabella users
INSERT INTO users (name, surname, email, telefono, password) VALUES
('mario' , 'rossi' , 'mario.rossi@email.com', '3483759370' ,'1'),
('anna', 'bianchi' , 'anna.bianchi@email.com', '3702957305' , 'password456'),
('lucia', 'verdi' ,'lucia.verdi@email.com', '3295729175' , 'password789');

-- Popola la tabella medici
INSERT INTO medici (nome, specializzazione) VALUES
('Dr. Giovanni Smith', 'Cardiologo'),
('Dr. Lapo Giustini', 'Cardiologo'),
('Dr. Laura Bellini', 'Dermatologo'),
('Dr. Marco De Luca', 'Ortopedico');

-- Popola la tabella appuntamenti
INSERT INTO prenotazioni (user_id, medico_id, data_prenotazione) VALUES
(1, 2, '2025-04-10'),
(2, 1, '2025-04-12'),
(3, 3, '2025-04-15');

CREATE TABLE immagini (
id_immagine INT AUTO_INCREMENT PRIMARY KEY,
descrizione VARCHAR(100),
path VARCHAR(100) NOT NULL
);

INSERT INTO immagini (descrizione, path) VALUES
("", 'images/img1.jpg'),
("", 'images/img2.jpg'),
("", 'images/img3.jpg'),
("", 'images/img4.jpg'),
("", 'images/img5.jpg'),
("", 'images/img6.jpg'),
("", 'images/img7.jpg');
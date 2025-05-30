-- Crear base de datos
CREATE DATABASE IF NOT EXISTS diplomas_db;
USE diplomas_db;

-- Crear tabla para almacenar los diplomas
CREATE TABLE diplomas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_estudiante VARCHAR(100) NOT NULL,
    cedula_estudiante VARCHAR(20) NOT NULL,
    edad_estudiante INT NOT NULL,
    genero_estudiante ENUM('Masculino', 'Femenino', 'Otro') NOT NULL,
    carrera VARCHAR(100) NOT NULL,
    coordinador VARCHAR(100) NOT NULL,
    institucion VARCHAR(100) NOT NULL,
    fecha_terminacion DATE NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Script de base de datos en MySQL 8 para crear las tablas necesarias de la implementación a entregar
CREATE TABLE tema(
identificador VARCHAR(30) PRIMARY KEY,
titulo VARCHAR(50) NOT NULL
);

CREATE TABLE pregunta(
identificador VARCHAR(30) PRIMARY KEY,
enunciado VARCHAR(100) UNIQUE NOT NULL,
anio_creacion INTEGER NOT NULL CHECK (anio_creacion <= 2022),
nivel_dificultad INTEGER NOT NULL CHECK (nivel_dificultad BETWEEN 1 AND 5),
pregunta_madre VARCHAR(30),
FOREIGN KEY (pregunta_madre) REFERENCES pregunta(identificador) ON UPDATE CASCADE ON DELETE RESTRICT,
CONSTRAINT jerarquia CHECK (identificador <> pregunta_madre)
);

CREATE TABLE conocimiento_evaluado(
tema_evaluado VARCHAR(30) NOT NULL,
pregunta_asignada VARCHAR(30) NOT NULL,
peso INTEGER NOT NULL CHECK (peso BETWEEN 1 AND 50),
FOREIGN KEY (tema_evaluado) REFERENCES tema(identificador) ON UPDATE CASCADE ON DELETE RESTRICT,
FOREIGN KEY (pregunta_asignada) REFERENCES pregunta(identificador) ON UPDATE CASCADE ON DELETE RESTRICT,
PRIMARY KEY(tema_evaluado, pregunta_asignada)
);

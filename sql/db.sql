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

-- Datos por defecto para ser insertados luego de la creación de las tablas

INSERT INTO tema(identificador, titulo) 
VALUES('T01', 'Termodinámica'),
	  ('T02', 'Series y sucesiones'),
      ('T03', 'Máquinas de estado'),
      ('T04', 'Mapas de Karnaugh'),
      ('T05', 'Área entre curvas');
      
INSERT INTO pregunta(identificador, enunciado, anio_creacion, nivel_dificultad, pregunta_madre)
VALUES('P01', '¿Qué es entropía?', 2020, 2, NULL),
	  ('P02', '¿Qué es una serie o sucesión?', 2005, 2, NULL),
      ('P03', 'Defina y demuestre la serie de Taylor', 2006, 5, 'P02'),
      ('P04', 'Brinde un ejemplo de la serie Fibonacci', 2006, 2, 'P02'),
      ('P05', '¿Cuál es el objetivo de un mapa de Karnaugh?', 2019, 1, NULL),
      ('P06', 'Resuelva el siguiente mapa de Karnaugh', 2021, 3, 'P05'),
      ('P07', 'Calcule el área de la figura y explique', 2022, 3, NULL),
      ('P08', '¿Para qué sirve una máquina de estado?', 2017, 1, NULL),
      ('P09', 'Resuelva la siguiente tabla de verdad', 2021, 3, 'P08'),
      ('P10', 'Calcule la ecuación de mintérminos para la anterior tabla de verdad', 2021, 3, 'P09');
      
INSERT INTO conocimiento_evaluado(tema_evaluado, pregunta_asignada, peso)
VALUES('T01', 'P01', 10),
	  ('T02', 'P02', 5),
      ('T02', 'P03', 20),
      ('T02', 'P04', 15),
      ('T03', 'P08', 10),
      ('T03', 'P09', 15),
      ('T03', 'P10', 25),
      ('T04', 'P05', 8),
      ('T04', 'P06', 20),
      ('T05', 'P07', 30),
      ('T05', 'P10', 15),
      ('T02', 'P07', 45);

-- Consultas

-- Primera consulta
SELECT p.identificador, p.enunciado
FROM pregunta p
WHERE p.identificador IN (
    SELECT ce.pregunta_asignada 
    FROM conocimiento_evaluado ce
    GROUP BY ce.pregunta_asignada
    HAVING COUNT(ce.pregunta_asignada) >= 2
)
AND p.nivel_dificultad > 2
AND p.anio_creacion > 2020;

-- Segunda consulta
SELECT t.identificador, t.titulo
FROM tema t
WHERE t.identificador IN (
    SELECT ce.tema_evaluado
    FROM conocimiento_evaluado ce
    GROUP BY ce.tema_evaluado
    HAVING COUNT(ce.tema_evaluado) >= 3 AND SUM(ce.peso) > 50
);

-- Búsquedas

-- Primera búsqueda
SET @anio_1 = 2010;
SET @anio_2 = 2021;

SELECT p.identificador, p.enunciado
FROM pregunta p
WHERE p.anio_creacion > @anio_1 AND p.anio_creacion < @anio_2;

-- Segunda búsqueda

-- Primeros 2 puntos
SELECT p.identificador, p.enunciado, p.anio_creacion, p.pregunta_madre, madre.enunciado
FROM pregunta p
INNER JOIN pregunta madre
ON p.pregunta_madre = madre.identificador
WHERE p.identificador = @id;

-- Tercer punto
SELECT p.identificador, p.enunciado
FROM pregunta p
WHERE p.pregunta_madre = @id;

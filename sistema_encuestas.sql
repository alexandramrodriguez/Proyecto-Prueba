CREATE DATABASE IF NOT EXISTS sistema_encuestas;
USE sistema_encuestas;

CREATE TABLE encuestas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado BOOLEAN DEFAULT TRUE
);

CREATE TABLE preguntas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_encuesta INT NOT NULL,
    texto TEXT NOT NULL,
    tipo VARCHAR(50) NOT NULL, -- Ej: 'opcion_multiple', 'texto'
    orden INT DEFAULT 0,
    FOREIGN KEY (id_encuesta) REFERENCES encuestas(id) ON DELETE CASCADE
);

CREATE TABLE opciones_respuesta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pregunta INT NOT NULL,
    texto_opcion VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_pregunta) REFERENCES preguntas(id) ON DELETE CASCADE
);

CREATE TABLE respuestas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pregunta INT NOT NULL,
    id_opcion INT DEFAULT NULL,
    texto_respuesta TEXT DEFAULT NULL,
    fecha_respuesta DATETIME DEFAULT CURRENT_TIMESTAMP,
    token_anonimo VARCHAR(100),
    FOREIGN KEY (id_pregunta) REFERENCES preguntas(id) ON DELETE CASCADE,
    FOREIGN KEY (id_opcion) REFERENCES opciones_respuesta(id) ON DELETE SET NULL
);

-- Ejemplos

INSERT INTO encuestas (titulo, descripcion) VALUES 
('Encuesta de Satisfacción', 'Queremos conocer tu opinión sobre nuestro servicio.');

INSERT INTO preguntas (id_encuesta, texto, tipo, orden) VALUES
(1, '¿Qué tan satisfecho estás con el servicio?', 'opcion_multiple', 1),
(1, '¿Qué mejorarías?', 'texto', 2);

INSERT INTO opciones_respuesta (id_pregunta, texto_opcion) VALUES
(1, 'Muy satisfecho'),
(1, 'Satisfecho'),
(1, 'Neutral'),
(1, 'Insatisfecho'),
(1, 'Muy insatisfecho');

INSERT INTO respuestas (id_pregunta, id_opcion, token_anonimo) VALUES 
(1, 2, 'abc123xyz');

INSERT INTO respuestas (id_pregunta, texto_respuesta, token_anonimo) VALUES 
(2, 'Podrían mejorar el tiempo de atención.', 'abc123xyz');

-- Para ver todas las respuestas de una encuesta:

SELECT 
    e.titulo AS encuesta,
    p.texto AS pregunta,
    o.texto_opcion AS opcion,
    r.texto_respuesta,
    r.fecha_respuesta
FROM respuestas r
JOIN preguntas p ON r.id_pregunta = p.id
LEFT JOIN opciones_respuesta o ON r.id_opcion = o.id
JOIN encuestas e ON p.id_encuesta = e.id;


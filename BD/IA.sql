-- Crear la base de datos para el sistema experto
CREATE DATABASE sistema_experto;
USE sistema_experto;

-- Crear tabla para usuarios expertos
CREATE TABLE experto (
    UsuarioE VARCHAR(100) NOT NULL,   -- Nombre del usuario experto
    ContrasenaAE VARCHAR(255) NOT NULL  -- Contraseña asociada al usuario
);

-- Insertar un usuario experto por defecto
INSERT INTO experto (UsuarioE, ContrasenaAE)
VALUES ('EXPERTO', '12345678A');

-- Crear tabla para almacenar razas
CREATE TABLE raza (
    id INT AUTO_INCREMENT PRIMARY KEY,    -- ID único para la raza
    nombre VARCHAR(100) NOT NULL,     -- Nombre de la raza
    descripcion TEXT NOT NULL,        -- Descripción detallada de la raza
    imagen LONGBLOB NOT NULL,              -- Imagen relacionada con la raza (almacenada en formato binario)
    peso_total INT DEFAULT 0               -- Campo para almacenar el peso total de las características asociadas
);
-- Crear tabla para almacenar características
CREATE TABLE caracteristicas (
    id INT AUTO_INCREMENT PRIMARY KEY,    -- ID único para la característica
    nombre VARCHAR(100) NOT NULL,   -- Nombre de la característica
    imagen LONGBLOB NOT NULL          -- Imagen relacionada con la característica (almacenada en formato binario)
);

-- Crear tabla de relación entre razas y características
CREATE TABLE raza_caracteristica (
    id INT AUTO_INCREMENT PRIMARY KEY,    -- ID único para la relación
    raza_id INT,                          -- ID de la raza asociada (referencia a la tabla raza)
    caracteristica_id INT,                -- ID de la característica asociada (referencia a la tabla caracteristicas)
    peso INT,                             -- Peso que indica la relevancia de la característica para la raza
    bandera BOOLEAN DEFAULT 0,            -- Estado de la característica (indicador booleano)
    FOREIGN KEY (raza_id) REFERENCES raza(id),           -- Clave externa para asegurar la relación con la tabla raza
    FOREIGN KEY (caracteristica_id) REFERENCES caracteristicas(id)  -- Clave externa para asegurar la relación con la tabla caracteristicas
);

select * from raza_caracteristica;

-- Trigger para actualizar el peso total de las características cuando se actualiza una relación
DELIMITER $$
CREATE TRIGGER actualizar_peso_total_update
AFTER UPDATE ON raza_caracteristica
FOR EACH ROW
BEGIN
    DECLARE total INT;

    -- Calcular la nueva sumatoria de pesos de las características asociadas a la raza
    SELECT SUM(peso)
    INTO total
    FROM raza_caracteristica
    WHERE raza_id = NEW.raza_id;

    -- Actualizar el peso total en la tabla raza
    UPDATE raza
    SET peso_total = total
    WHERE id = NEW.raza_id;
END$$
DELIMITER ;

-- Trigger para actualizar el peso total de las características cuando se elimina una relación
DELIMITER $$
CREATE TRIGGER actualizar_peso_total_delete
AFTER DELETE ON raza_caracteristica
FOR EACH ROW
BEGIN
    DECLARE total INT;

    -- Calcular la nueva sumatoria de pesos de las características restantes asociadas a la raza
    SELECT SUM(peso)
    INTO total
    FROM raza_caracteristica
    WHERE raza_id = OLD.raza_id;

    -- Actualizar el peso total en la tabla raza (si no quedan características, peso total será 0)
    UPDATE raza
    SET peso_total = IFNULL(total, 0)
    WHERE id = OLD.raza_id;
END$$
DELIMITER ;

-- Trigger para actualizar el peso total de las características cuando se inserta una nueva relación
DELIMITER $$
CREATE TRIGGER actualizar_peso_total_insert
AFTER INSERT ON raza_caracteristica
FOR EACH ROW
BEGIN
    DECLARE total INT;

    -- Calcular la nueva sumatoria de pesos de las características asociadas a la raza
    SELECT SUM(peso)
    INTO total
    FROM raza_caracteristica
    WHERE raza_id = NEW.raza_id;

    -- Actualizar el peso total en la tabla raza
    UPDATE raza
    SET peso_total = total
    WHERE id = NEW.raza_id;
END$$
DELIMITER ;
-- Insertar 20 razas de perros
INSERT INTO raza (nombre, descripcion, imagen) VALUES
('Labrador Retriever', 'Origen: Canadá, conocido por su amabilidad y energía.', NULL),
('Golden Retriever', 'Origen: Escocia, famoso por su inteligencia y confiabilidad.', NULL),
('Pastor Alemán', 'Origen: Alemania, reconocido por su lealtad y habilidades de protección.', NULL),
('Bulldog Francés', 'Origen: Francia, popular por su sociabilidad y afecto.', NULL),
('Poodle (Caniche)', 'Origen: Francia, valorado por su inteligencia y pelaje hipoalergénico.', NULL),
('Shih Tzu', 'Origen: China, apreciado por su naturaleza cariñosa y alerta.', NULL),
('Chihuahua', 'Origen: México, conocido por su valentía y energía.', NULL),
('Husky Siberiano', 'Origen: Siberia, famoso por su resistencia al frío y naturaleza independiente.', NULL),
('Boxer', 'Origen: Alemania, reconocido por su energía y lealtad.', NULL),
('Dálmata', 'Origen: Croacia, conocido por su pelaje único y naturaleza activa.', NULL),
('Beagle', 'Origen: Inglaterra, famoso por su curiosidad y lealtad.', NULL),
('Rottweiler', 'Origen: Alemania, valorado por su protección y seguridad.', NULL),
('Akita Inu', 'Origen: Japón, conocido por su dignidad e independencia.', NULL),
('Border Collie', 'Origen: Escocia, famoso por su inteligencia y obediencia.', NULL),
('Dachshund (Perro Salchicha)', 'Origen: Alemania, reconocido por su valentía y tenacidad.', NULL),
('Bulldog Inglés', 'Origen: Inglaterra, conocido por su tranquilidad y lealtad.', NULL),
('Cocker Spaniel', 'Origen: Inglaterra, famoso por su alegría y afecto.', NULL),
('Bichón Frisé', 'Origen: Francia, valorado por su naturaleza juguetona y pelaje hipoalergénico.', NULL),
('San Bernardo', 'Origen: Suiza, conocido por su calma y lealtad.', NULL),
('Pastor Australiano', 'Origen: Estados Unidos, famoso por su inteligencia y energía.', NULL);
-- Insertar 100 características
INSERT INTO caracteristicas (nombre, imagen, bandera) VALUES
('pequeño', NULL, 0),
('grande', NULL, 0),
('amigable', NULL, 0),
('energético', NULL, 0),
('leal', NULL, 0),
('pelaje corto', NULL, 0),
('pelaje denso', NULL, 0),
('pelaje resistente al agua', NULL, 0),
('inteligente', NULL, 0),
('confiable', NULL, 0),
('pelaje largo', NULL, 0),
('pelaje ondulado', NULL, 0),
('protector', NULL, 0),
('pelaje medio', NULL, 0),
('pelaje doble capa', NULL, 0),
('sociable', NULL, 0),
('juguetón', NULL, 0),
('afectuoso', NULL, 0),
('pelaje suave', NULL, 0),
('entrenable', NULL, 0),
('alerta', NULL, 0),
('muy pequeño', NULL, 0),
('valiente', NULL, 0),
('independiente', NULL, 0),
('pelaje grueso', NULL, 0),
('pelaje resistente al frío', NULL, 0),
('pelaje blanco con manchas', NULL, 0),
('curioso', NULL, 0),
('obediente', NULL, 0),
('arrugado', NULL, 0),
('pelaje liso', NULL, 0),
('calmado', NULL, 0),
('territorial', NULL, 0),
('resistencia al calor', NULL, 0),
('resistencia al frío', NULL, 0),
('nivel de ladrido', NULL, 0),
('necesidad de ejercicio', NULL, 0),
('facilidad de entrenamiento', NULL, 0),
('nivel de socialización', NULL, 0),
('expectativa de vida', NULL, 0),
('nivel de inteligencia', NULL, 0),
('alergias comunes', NULL, 0),
('capacidad de aprendizaje', NULL, 0),
('comportamiento hacia extraños', NULL, 0),
('pelaje rizado', NULL, 0),
('hipoalergénico', NULL, 0),
('requiere cepillado', NULL, 0),
('activo', NULL, 0),
('seguro', NULL, 0),
('digno', NULL, 0),
('tenaz', NULL, 0),
('tranquilo', NULL, 0),
('alegre', NULL, 0),
('amable', NULL, 0),
('enérgico', NULL, 0),
('marcas de color', NULL, 0),
('mediano', NULL, 0),
('muy grande', NULL, 0),
('fácil de cuidar', NULL, 0),
('requiere ejercicio', NULL, 0),
('requiere entrenamiento', NULL, 0),
('sociable con otros perros', NULL, 0),
('sociable con personas', NULL, 0),
('larga vida', NULL, 0),
('vida media', NULL, 0),
('vida corta', NULL, 0),
('alta inteligencia', NULL, 0),
('inteligencia media', NULL, 0),
('inteligencia baja', NULL, 0),
('alergias a alimentos', NULL, 0),
('alergias ambientales', NULL, 0),
('alta capacidad de aprendizaje', NULL, 0),
('capacidad de aprendizaje media', NULL, 0),
('capacidad de aprendizaje baja', NULL, 0),
('amigable con extraños', NULL, 0),
('reservado con extraños', NULL, 0),
('desconfiado con extraños', NULL, 0),
('resistencia al calor extremo', NULL, 0),
('resistencia al frío extremo', NULL, 0),
('poco ladrador', NULL, 0),
('ladrador', NULL, 0),
('baja necesidad de ejercicio', NULL, 0),
('media necesidad de ejercicio', NULL, 0),
('alta necesidad de ejercicio', NULL, 0),
('fácil entrenamiento', NULL, 0),
('entrenamiento moderado', NULL, 0),
('entrenamiento difícil', NULL, 0),
('sociable con otros perros', NULL, 0),
('sociable con personas', NULL, 0),
('territorial', NULL, 0),
('larga expectativa de vida', NULL, 0),
('media expectativa de vida', NULL, 0),
('corta expectativa de vida', NULL, 0),
('alta inteligencia', NULL, 0),
('inteligencia media', NULL, 0),
('inteligencia baja', NULL, 0),
('alergias a alimentos específicos', NULL, 0),
('alergias ambientales', NULL, 0),
('alta capacidad de aprendizaje', NULL, 0),
('capacidad de aprendizaje media', NULL, 0),
('capacidad de aprendizaje baja', NULL, 0),
('amigable con extraños', NULL, 0),
('reservado con extraños', NULL, 0),
('desconfiado con extraños', NULL, 0);

select * from raza_caracteristica;
-- Insertar relaciones entre razas y características con porcentajes
INSERT INTO raza_caracteristica (raza_id, caracteristica_id, peso) VALUES
-- Relaciones para Labrador Retriever
(1, 2, 100), (1, 3, 90), (1, 4, 80), (1, 5, 70), (1, 6, 60),

-- Relaciones para Golden Retriever
(2, 2, 100), (2, 3, 90), (2, 9, 80), (2, 10, 70), (2, 11, 60),

-- Relaciones para Pastor Alemán
(3, 2, 100), (3, 13, 90), (3, 5, 80), (3, 14, 70), (3, 15, 60),

-- Relaciones para Bulldog Francés
(4, 1, 100), (4, 16, 90), (4, 17, 80), (4, 18, 70), (4, 6, 60),

-- Relaciones para Poodle (Caniche)
(5, 1, 100), (5, 9, 90), (5, 20, 80), (5, 3, 70), (5, 19, 60),

-- Relaciones para Shih Tzu
(6, 1, 100), (6, 21, 90), (6, 3, 80), (6, 11, 70), (6, 22, 60),

-- Relaciones para Chihuahua
(7, 1, 100), (7, 23, 90), (7, 4, 80), (7, 5, 70), (7, 6, 60),

-- Relaciones para Husky Siberiano
(8, 2, 100), (8, 24, 90), (8, 3, 80), (8, 25, 70), (8, 26, 60),

-- Relaciones para Boxer
(9, 2, 100), (9, 17, 90), (9, 4, 80), (9, 5, 70), (9, 6, 60),

-- Relaciones para Dálmata
(10, 2, 100), (10, 27, 90), (10, 3, 80), (10, 28, 70), (10, 6, 60),

-- Relaciones para Beagle
(11, 1, 100), (11, 29, 90), (11, 3, 80), (11, 30, 70), (11, 6, 60),

-- Relaciones para Rottweiler
(12, 2, 100), (12, 13, 90), (12, 5, 80), (12, 6, 70), (12, 31, 60),

-- Relaciones para Akita Inu
(13, 2, 100), (13, 32, 90), (13, 5, 80), (13, 14, 70), (13, 15, 60),

-- Relaciones para Border Collie
(14, 2, 100), (14, 33, 90), (14, 5, 80), (14, 34, 70), (14, 35, 60),

-- Relaciones para Dachshund (Perro Salchicha)
(15, 1, 100), (15, 36, 90), (15, 5, 80), (15, 37, 70), (15, 38, 60),

-- Relaciones para Bulldog Inglés
(16, 2, 100), (16, 39, 90), (16, 5, 80), (16, 40, 70), (16, 41, 60),

-- Relaciones para Cocker Spaniel
(17, 1, 100), (17, 42, 90), (17, 5, 80), (17, 43, 70), (17, 44, 60),

-- Relaciones para Bichón Frisé
(18, 1, 100), (18, 45, 90), (18, 5, 80), (18, 46, 70), (18, 47, 60),

-- Relaciones para San Bernardo
(19, 2, 100), (19, 48, 90), (19, 5, 80), (19, 49, 70), (19, 50, 60),

-- Relaciones para Pastor Australiano
(20, 2, 100), (20, 51, 90), (20, 5, 80), (20, 52, 70), (20, 53, 60),
-- Relaciones adicionales para Labrador Retriever
(1, 7, 50), (1, 8, 40), (1, 9, 30),

-- Relaciones adicionales para Golden Retriever
(2, 12, 50), (2, 13, 40), (2, 14, 30),

-- Relaciones adicionales para Pastor Alemán
(3, 16, 50), (3, 17, 40), (3, 18, 30),

-- Relaciones adicionales para Bulldog Francés
(4, 19, 50), (4, 20, 40), (4, 21, 30),

-- Relaciones adicionales para Poodle (Caniche)
(5, 22, 50), (5, 23, 40), (5, 24, 30),

-- Relaciones adicionales para Shih Tzu
(6, 25, 50), (6, 26, 40), (6, 27, 30),

-- Relaciones adicionales para Chihuahua
(7, 28, 50), (7, 29, 40), (7, 30, 30),

-- Relaciones adicionales para Husky Siberiano
(8, 31, 50), (8, 32, 40), (8, 33, 30),

-- Relaciones adicionales para Boxer
(9, 34, 50), (9, 35, 40), (9, 36, 30),

-- Relaciones adicionales para Dálmata
(10, 37, 50), (10, 38, 40), (10, 39, 30),

-- Relaciones adicionales para Beagle
(11, 40, 50), (11, 41, 40), (11, 42, 30),

-- Relaciones adicionales para Rottweiler
(12, 43, 50), (12, 44, 40), (12, 45, 30),

-- Relaciones adicionales para Akita Inu
(13, 46, 50), (13, 47, 40), (13, 48, 30),

-- Relaciones adicionales para Border Collie
(14, 49, 50), (14, 50, 40), (14, 51, 30),

-- Relaciones adicionales para Dachshund (Perro Salchicha)
(15, 52, 50), (15, 53, 40), (15, 54, 30),

-- Relaciones adicionales para Bulldog Inglés
(16, 55, 50), (16, 56, 40), (16, 57, 30),

-- Relaciones adicionales para Cocker Spaniel
(17, 58, 50), (17, 59, 40), (17, 60, 30),

-- Relaciones adicionales para Bichón Frisé
(18, 61, 50), (18, 62, 40), (18, 63, 30),

-- Relaciones adicionales para San Bernardo
(19, 64, 50), (19, 65, 40), (19, 66, 30),

-- Relaciones adicionales para Pastor Australiano
(20, 67, 50), (20, 68, 40), (20, 69, 30);
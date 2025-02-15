

-- DROP DATABASE IF EXISTS trastopopdb;

CREATE DATABASE IF NOT EXISTS trastopopdb DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;

USE trastopopdb;

-- Crear tabla de usuarios
CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    city VARCHAR(45) NULL,
    state VARCHAR(45) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Crear tabla de trastos
CREATE TABLE IF NOT EXISTS trastos (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    details MEDIUMTEXT,
    price FLOAT(10, 2),
    `condition` VARCHAR(50),
    category VARCHAR(100),
    tags VARCHAR(255),
    seller VARCHAR(100),
    address VARCHAR(255),
    city VARCHAR(100) NOT NULL,
    `state` VARCHAR(100),
    phone VARCHAR(20),
    email VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Insertar datos de ejemplo en la tabla de usuarios
INSERT INTO users (name, email, password, city, state)
VALUES
    ('Juan Pérez', 'juan.perez@example.com', '$2y$10$uNiCDGrbx.7gSomnLmFPL.A.eyUN6F8y5qeY9oML9MYCL.s2JtZcW', 'Madrid', 'Madrid'),
    ('María García', 'maria.garcia@example.com', '$2y$10$uNiCDGrbx.7gSomnLmFPL.A.eyUN6F8y5qeY9oML9MYCL.s2JtZcW', 'Barcelona', 'Cataluña'),
    ('Carlos López', 'carlos.lopez@example.com', '$2y$10$uNiCDGrbx.7gSomnLmFPL.A.eyUN6F8y5qeY9oML9MYCL.s2JtZcW', 'Valencia', 'Valencia'),
    ('Ana Martínez', 'ana.martinez@example.com', '$2y$10$uNiCDGrbx.7gSomnLmFPL.A.eyUN6F8y5qeY9oML9MYCL.s2JtZcW', 'Sevilla', 'Andalucía'),
    ('Laura González', 'laura.gonzalez@example.com', '$2y$10$uNiCDGrbx.7gSomnLmFPL.A.eyUN6F8y5qeY9oML9MYCL.s2JtZcW', 'Zaragoza', 'Aragón');

-- Insertar datos de ejemplo en la tabla de trastos
INSERT INTO trastos (
    user_id,
    title,
    description,
    details,
    price,
    `condition`,
    category,
    tags,
    seller,
    address,
    city,
    `state`,
    phone,
    email
) VALUES
    (1, 'Bicicleta de montaña', 'Bicicleta de montaña en buen estado, poco uso.',
     'Marca: Trek, Modelo: Marlin 7, Año: 2020, Talla: M, Color: Negro y Azul, Frenos de disco hidráulicos, Suspensión delantera',
     150.00, 'Usado', 'Deportes', 'bicicleta, montaña, deporte', 'Juan Pérez', 'Calle Mayor, 5', 'Madrid', 'Madrid', '612345678', 'juan.perez@example.com'),
    (2, 'Sofá de tres plazas', 'Sofá cómodo de tres plazas, color gris.',
     'Material: Tela, Color: Gris, Dimensiones: 200x90x85 cm, Incluye cojines, Estructura de madera, Fácil de limpiar',
     250.00, 'Usado', 'Muebles', 'sofá, muebles, hogar', 'María García', 'Avenida Diagonal, 23', 'Barcelona', 'Cataluña', '622345678', 'maria.garcia@example.com'),
    (3, 'Portátil HP', 'Portátil HP, 8GB RAM, 256GB SSD.',
     'Marca: HP, Modelo: Pavilion 15, Procesador: Intel Core i5, Pantalla: 15.6 pulgadas, Resolución: Full HD, Sistema Operativo: Windows 10',
     500.00, 'Nuevo', 'Electrónica', 'portátil, hp, electrónica', 'Carlos López', 'Calle de la Paz, 10', 'Valencia', 'Valencia', '632345678', 'carlos.lopez@example.com'),
    (4, 'Mesa de comedor', 'Mesa de comedor de madera, capacidad para 6 personas.',
     'Material: Madera de roble, Dimensiones: 180x90x75 cm, Color: Natural, Incluye 6 sillas a juego, Acabado lacado resistente a manchas',
     300.00, 'Usado', 'Muebles', 'mesa, comedor, madera', 'Ana Martínez', 'Calle Real, 15', 'Sevilla', 'Andalucía', '642345678', 'ana.martinez@example.com'),
    (5, 'Cámara fotográfica', 'Cámara réflex Nikon, 24MP.',
     'Marca: Nikon, Modelo: D5600, Resolución: 24MP, Incluye lente 18-55mm, Pantalla táctil abatible, Conectividad Wi-Fi y Bluetooth',
     450.00, 'Nuevo', 'Fotografía', 'cámara, nikon, fotografía', 'Laura González', 'Plaza España, 2', 'Zaragoza', 'Aragón', '652345678', 'laura.gonzalez@example.com');

CREATE DATABASE sistema_inventario;

USE sistema_inventario;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(20) NOT NULL
);

-- 2. Tabla categorias
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(50) NOT NULL UNIQUE
);

-- 3. Tabla productos con llave foránea
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_producto VARCHAR(100) NOT NULL,
    categoria_id INT NOT NULL,
    stock INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,

    FOREIGN KEY (categoria_id)
    REFERENCES categorias(id)
);

-- 4. Insertar categorías
INSERT INTO categorias (nombre_categoria) VALUES
('Computadoras'),
('Accesorios'),
('Oficina');

-- 5. Insertar productos
INSERT INTO productos
(nombre_producto, categoria_id, stock, precio)
VALUES
('Laptop Dell Inspiron 15', 1, 15, 720.00),
('Mouse Inalambrico Logitech', 2, 25, 12.00);
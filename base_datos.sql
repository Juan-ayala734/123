CREATE DATABASE sistema_inventario;

USE sistema_inventario;

CREATE TABLE categorias (
id INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(50) NOT NULL
);

CREATE TABLE productos (
id INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(100) NOT NULL,
precio DECIMAL(10,2) NOT NULL,
stock INT NOT NULL,
id_categoria INT,
FOREIGN KEY (id_categoria) REFERENCES categorias(id)
);
CREATE DATABASE transacciones_web;
USE transacciones_web;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) UNIQUE,
    clave VARCHAR(100),
    rol ENUM('cliente','empleado'),
    cuenta_id INT NULL
);

CREATE TABLE cuentas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    saldo DECIMAL(10,2)
);

INSERT INTO cuentas (nombre, saldo) VALUES
('Fabricio', 1000),
('Gema', 1500),
('Emiliano', 2500),
('Rachell', 2000),
('Chelsea', 3000),
('MaJo', 5000),
('Henry', 3000),
('Manuel Francisco', 1200),
('Luis Enrique', 7000),
('Larissa', 5000);

INSERT INTO usuarios (usuario, clave, rol, cuenta_id) VALUES
('fabricio', '123', 'cliente', 1),
('gema', '123', 'cliente', 2),
('Emiliano', '123', 'cliente', 3),
('Rachell', '123', 'cliente', 4),
('chelsea', '123', 'cliente', 5),
('MaJo', '123', 'cliente', 6),
('Henry', '123', 'cliente', 7),
('Manuel Francisco', '123', 'cliente', 8),
('Luis Enrique', '123', 'cliente', 9),
('Larissa', '123', 'cliente', 10),
('admin', '123', 'empleado', NULL);

CREATE TABLE auditoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50),
    rol VARCHAR(20),
    proceso VARCHAR(100),
    tabla_afectada VARCHAR(50),
    registro_id INT,
    datos_antes JSON,
    datos_despues JSON,
    resultado VARCHAR(20),
    mensaje TEXT,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP
);
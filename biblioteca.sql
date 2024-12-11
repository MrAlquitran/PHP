CREATE DATABASE IF NOT EXISTS biblioteca;
SET NAMES utf8mb4;
USE biblioteca;

DROP TABLE IF EXISTS Usuarios;
CREATE TABLE Usuarios (
    UsuarioID INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(50) NOT NULL,
    Apellido1 VARCHAR(50) NOT NULL,
    Apellido2 VARCHAR(50),
    Email VARCHAR(100) UNIQUE NOT NULL,
    Contraseña VARCHAR(255) NOT NULL,
    EsBibliotecario TINYINT(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
ALTER TABLE Usuarios
MODIFY EsBibliotecario BOOLEAN NOT NULL DEFAULT FALSE;

DROP TABLE IF EXISTS Socios;
CREATE TABLE Socios (
    SocioID INT PRIMARY KEY KEY AUTO_INCREMENT,
    UsuarioID INT UNIQUE NOT NULL,
    NumeroSocio VARCHAR(20) UNIQUE NOT NULL,
    Direccion VARCHAR(255) NOT NULL,
    Telefono VARCHAR(20) NOT NULL,
    DNIConfirmado BIT NOT NULL DEFAULT 0,
    FOREIGN KEY (UsuarioID) REFERENCES Usuarios(UsuarioID)
)ENGINE=InnoDb DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

DROP TABLE IF EXISTS Libros;
CREATE TABLE Libros (
    LibroID INT PRIMARY KEY KEY AUTO_INCREMENT,
    Titulo VARCHAR(255) NOT NULL,
    Editorial VARCHAR(100) NOT NULL,
    ISBN VARCHAR(13) UNIQUE NOT NULL,
    FechaPublicacion DATE NOT NULL
)ENGINE=InnoDb DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

DROP TABLE IF EXISTS Autores;
CREATE TABLE Autores (
    AutorID INT PRIMARY KEY KEY AUTO_INCREMENT,
    Nombre VARCHAR(100) NOT NULL
)ENGINE=InnoDb DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

DROP TABLE IF EXISTS LibrosAutores;
CREATE TABLE LibrosAutores (
    LibroID INT,
    AutorID INT,
    PRIMARY KEY (LibroID, AutorID),
    FOREIGN KEY (LibroID) REFERENCES Libros(LibroID),
    FOREIGN KEY (AutorID) REFERENCES Autores(AutorID)
)ENGINE=InnoDb DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

DROP TABLE IF EXISTS Ejemplares;
CREATE TABLE Ejemplares (
    EjemplarID INT PRIMARY KEY KEY AUTO_INCREMENT,
    LibroID INT NOT NULL,
    Codigo VARCHAR(50) UNIQUE NOT NULL,
    Estado VARCHAR(50) NOT NULL,
    FOREIGN KEY (LibroID) REFERENCES Libros(LibroID)
)ENGINE=InnoDb DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

DROP TABLE IF EXISTS Prestamos;
CREATE TABLE Prestamos (
    PrestamoID INT PRIMARY KEY KEY AUTO_INCREMENT,
    SocioID INT NOT NULL,
    EjemplarID INT NOT NULL,
    FechaPrestamo DATE NOT NULL,
    FechaDevolucion DATE NOT NULL,
    EstadoPrestamo VARCHAR(50) NOT NULL,
    FOREIGN KEY (SocioID) REFERENCES Socios(SocioID),
    FOREIGN KEY (EjemplarID) REFERENCES Ejemplares(EjemplarID)
)ENGINE=InnoDb DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

DROP TABLE IF EXISTS Penalizaciones;
CREATE TABLE Penalizaciones (
    PenalizacionID INT PRIMARY KEY KEY AUTO_INCREMENT,
    SocioID INT NOT NULL,
    TipoPenalizacion VARCHAR(50) NOT NULL,
    FechaInicio DATE NOT NULL,
    FechaFin DATE,
    FOREIGN KEY (SocioID) REFERENCES Socios(SocioID)
)ENGINE=InnoDb DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;


-- Inserts de tablas
-- Usuarios
INSERT INTO Usuarios (Nombre, Apellido1, Apellido2, Email, Contraseña, EsBibliotecario)
VALUES 
('María', 'García', 'López', 'maria.garcia@email.com', 'contraseña123', 1),
('Juan', 'Martínez', 'Sánchez', 'juan.martinez@email.com', 'clave456', 0),
('Ana', 'Fernández', 'Ruiz', 'ana.fernandez@email.com', 'secreto789', 0);

--Socios
INSERT INTO Socios (UsuarioID, NumeroSocio, Direccion, Telefono, DNIConfirmado)
VALUES 
(2, 'SOC001', 'Calle Mayor 123, Madrid', '612345678', 1),
(3, 'SOC002', 'Avenida Principal 45, Barcelona', '698765432', 0);

--Libros
INSERT INTO Libros (Titulo, Editorial, ISBN, FechaPublicacion)
VALUES 
('Cien años de soledad', 'Editorial Sudamericana', '9780307474728', '1967-05-30'),
('El Quijote', 'Francisco de Robles', '9788424922498', '1605-01-16'),
('1984', 'Secker & Warburg', '9780451524935', '1949-06-08');

--Autores
INSERT INTO Autores (Nombre)
VALUES 
('Gabriel García Márquez'),
('Miguel de Cervantes'),
('George Orwell');

--LibrosAutores
INSERT INTO LibrosAutores (LibroID, AutorID)
VALUES 
(1, 1),
(2, 2),
(3, 3);

--Ejemplares
INSERT INTO Ejemplares (LibroID, Codigo, Estado)
VALUES 
(1, 'EJ001', 'Bueno'),
(1, 'EJ002', 'Regular'),
(2, 'EJ003', 'Excelente'),
(3, 'EJ004', 'Bueno');

--Prestamos
INSERT INTO Prestamos (SocioID, EjemplarID, FechaPrestamo, FechaDevolucion, EstadoPrestamo)
VALUES 
(1, 1, '2024-12-01', '2024-12-21', 'En préstamo'),
(2, 3, '2024-12-05', '2024-12-25', 'En préstamo');

--Penalizaciones
INSERT INTO Penalizaciones (SocioID, TipoPenalizacion, FechaInicio, FechaFin)
VALUES 
(1, 'Retraso', '2024-11-15', '2024-11-22'),
(2, 'No devolución', '2024-12-01', NULL);

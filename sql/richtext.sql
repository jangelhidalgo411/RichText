/*
 * phpMyAdmin SQL Dump
 * version 5.2.0
 * Servidor: 127.0.0.1
 * Tiempo de generación: 15-09-2024 a las 13:31:36
 * Versión del servidor: 10.4.24-MariaDB
 * Versión de PHP: 8.1.6
*/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*
 * Crear Tabla Roles
*/
CREATE TABLE Roles (
  Role_Id int(11) NOT NULL,
  Role_Name varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*
 * Volvado de datos en tabla roles
*/
INSERT INTO roles (Role_Id, Role_Name) VALUES
(1, 'User'),
(2, 'Super User'),
(3, 'Admin'),
(4, 'Master');

/*
 * Crear Tabla Users
*/
CREATE TABLE Users (
  Id int(11) NOT NULL,
  Name varchar(255) NOT NULL,
  Email varchar(150) NOT NULL,
  Password varchar(255) NOT NULL,
  Role int(11) NOT NULL DEFAULT 1,
  Active tinyint(1) NOT NULL DEFAULT 1,
  CreatedAt datetime NOT NULL,
  UpdatedAt datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*
 * Indices de la tabla Roles
*/
ALTER TABLE Roles ADD PRIMARY KEY (Role_Id);

/*
 * Indices de la tabla Users
*/
ALTER TABLE Users ADD PRIMARY KEY (Id),  ADD KEY FK_Users_Role (Role);

/*
 * AUTO_INCREMENT de la tabla Users
*/
ALTER TABLE Users MODIFY Id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

/*
 * Filtros para la tabla Users
*/
ALTER TABLE Users ADD CONSTRAINT FK_Users_Role FOREIGN KEY (Role) REFERENCES roles (Role_Id);


/*
 * Volvado de datos en tabla Users
*/
INSERT INTO Users (Name, Email, Password, Role, Active, CreatedAt, UpdatedAt) VALUES
('Admin', 'admin@admin.com', '30fdf15fd513fd69085f9344ff2d5d716254aa367bcac88e78ee60ad0298d606', 4, 1, '2024-09-14 21:14:06', '2024-09-14 21:14:06');
COMMIT;
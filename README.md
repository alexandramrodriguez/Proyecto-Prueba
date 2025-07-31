//El primer ejercicio del modelado de una base de datos para encuestas anonimas están en el archivo que dice sistema_encuestas.sql

//Primero instalar Xampp

//Ejecutar el archivo desde Visual Studio Code (en la carpeta vip2cars se encuentra el proyecto)

//Luego en el navegador para visualizar el sistema colocar: http://localhost/vip2cars/

//Base de datos ingresado en phpMyAdmin previamente:

CREATE DATABASE vip2cars_db;

USE vip2cars_db;

CREATE TABLE vehiculos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  placa VARCHAR(6) NOT NULL UNIQUE, 
  marca VARCHAR(50),
  modelo VARCHAR(50),
  anio_fabricacion YEAR,
  nombre_cliente VARCHAR(100),
  apellidos_cliente VARCHAR(100),
  nro_documento VARCHAR(20),
  correo_cliente VARCHAR(100),
  telefono_cliente VARCHAR(20)
);


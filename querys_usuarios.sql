create database projeto_repositorio;

use projeto_repositorio;

create table usuarios(
	id int not null primary key AUTO_INCREMENT,
	matricula_uniritter int not null,
	nome varchar(50) not null,
	email varchar(50) not null,
	senha varchar(32) not null
);
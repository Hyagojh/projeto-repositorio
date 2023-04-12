use projeto_repositorio;

create table arquivos(
	id int not null PRIMARY KEY AUTO_INCREMENT,
	id_usuario int not null,
	nome_arquivo varchar(50) not null,
	descricao varchar(220) not null,
	tipo varchar(30) not null,
	tamanho int(11) not null,
	conteudo mediumblob not null,
	data datetime default current_timestamp
);
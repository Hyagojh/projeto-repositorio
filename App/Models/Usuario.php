<?php

namespace App\Models;

use MF\Model\Model;

class Usuario extends Model {

	private $id;
	private $matricula_uniritter;
	private $nome;
	private $email;
	private $senha;

	public function __get($atributo) {
		return $this->$atributo;
	}

	public function __set($atributo, $valor) {
		$this->$atributo = $valor;
	}

	public function salvar() {

		$query = "insert into usuarios(matricula_uniritter, nome, email, senha)values(:matricula_uniritter, :nome, :email, :senha)";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':matricula_uniritter', $this->__get('matricula_uniritter'));
		$stmt->bindValue(':nome', $this->__get('nome'));
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->bindValue(':senha', $this->__get('senha')); //md5() -> hash 32 caracteres
		$stmt->execute();

		return $this;
	}

	public function validarCadastro() {
		$valido = true;

		if(strlen($this->__get('matricula_uniritter')) < 3) {
			$valido = false;
		}

		if(strlen($this->__get('nome')) < 3) {
			$valido = false;
		}

		if(strlen($this->__get('email')) < 3) {
			$valido = false;
		}

		if(strlen($this->__get('senha')) < 3) {
			$valido = false;
		}


		return $valido;
	}

	public function getUsuarioPorEmail() {

		$query = "select nome, email from usuarios where email = :email";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);

	}

	public function autenticarUsuario() {

		$query = 'select id, matricula_uniritter, nome, email from usuarios where email = :email and senha = :senha';

		$stmt = $this->db->prepare($query);

		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->bindValue(':senha', $this->__get('senha'));

		$stmt->execute();

		$usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

		if($usuario['id'] != '' && $usuario['nome'] != '') {

			$this->__set('id', $usuario['id']);
			$this->__set('nome', $usuario['nome']);

		}

		return $usuario;

	}

	public function listarDadosConta() {

        $query = "select nome, email from usuarios where id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

	public function alterarDadosConta() {

        $query = "update usuarios set nome = :nome, email = :email, senha = :senha where id = :id";

        $stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
        $stmt->bindValue(':nome', $this->__get('nome'));
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->execute();

    }
}

?>
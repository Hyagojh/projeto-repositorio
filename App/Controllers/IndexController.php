<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {

		$this->view->login = isset($_GET['login']) ? $_GET['login']: '';
		 
		$this->render('index', 'indexLayout');

	}

	public function inscreverse() {

		$this->view->usuario = array(
			'matricula_uniritter' => '',
			'nome' => '',
			'email' => '',
			'senha' => '',
		);

		$this->view->erroCadastro = false;

		$this->render('inscreverse', 'indexLayout');
	}

	public function registrar() {

		$usuario = Container::getModel('Usuario');

		$usuario->__set('matricula_uniritter', $_POST['matricula_uniritter']);
		$usuario->__set('nome', $_POST['nome']);
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', md5($_POST['senha']));

		if($usuario->validarCadastro() && count($usuario->getUsuarioPorEmail()) == 0) {

			$usuario->salvar();

			$this->render('cadastro', 'indexLayout');

		} else {

			$this->view->erroCadastro = true;

			$this->render('inscreverse', 'indexLayout');

		}
	}

}


?>
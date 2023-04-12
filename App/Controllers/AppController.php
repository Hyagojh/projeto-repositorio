<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {

    public function validaAutenticacao() {

		session_start();

		if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {
			header('Location: /?login=erro');
		}	

	}

    public function pagina_inicial() {

        $this->validaAutenticacao();
        
        $this->render('home', 'appLayout');
    }

    public function minha_conta() {        

        $this->validaAutenticacao();
        
        $usuario = Container::getModel('Usuario');

        $usuario->__set('id', $_SESSION['id']);

        $dados = $usuario->listarDadosConta();

        $this->view->dados = $dados;
        
        $this->render('minha_conta', 'appLayout');

    }

    public function alterar_dados() {

        $this->validaAutenticacao();
        
        $usuario = Container::getModel('Usuario');

        $usuario->__set('id', $_SESSION['id']);
        $usuario->__set('nome', $_POST['nome']);
        $usuario->__set('email', $_POST['email']);
        $usuario->__set('senha', md5(($_POST['senha'])));

        $usuario->alterarDadosConta();
            
        $this->render('alterar_conta', 'appLayout');

    }

    public function upload() {
    
        $this->validaAutenticacao();

        $this->render('upload', 'appLayout');

    }

    public function enviar_arquivo() {

        $this->validaAutenticacao();
        
        if(isset($_POST['enviar_arquivo']) && $_FILES['arquivo']['size'] > 0) {
            
            $fileName = $_FILES['arquivo']['name'];
            $tmpName  = $_FILES['arquivo']['tmp_name'];
            $fileSize = $_FILES['arquivo']['size'];
            $fileType = $_FILES['arquivo']['type'];

            $fp      = fopen($tmpName, 'r');
            $content = fread($fp, filesize($tmpName));
            $content = addslashes($content);
            fclose($fp);

            $arquivos = Container::getModel('Arquivo');

            $arquivos->__set('id_usuario', $_SESSION['id']);
            $arquivos->__set('nome_arquivo', $fileName);
            $arquivos->__set('descricao', $_POST['descricao']);
            $arquivos->__set('tipo', $fileType);
            $arquivos->__set('tamanho', $fileSize);
            $arquivos->__set('conteudo', $content);        
            
            $arquivos->salvar();

            header('Location: /home');

        }
    }

    public function pesquisar() {

        $this->validaAutenticacao();

        $arquivos = Container::getModel('Arquivo');

        if(!isset($_GET['nome_usuario']) || $_GET['nome_usuario'] == ''){

            $total_registros_pagina = 5;
            $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
            $deslocamento = ($pagina - 1) * $total_registros_pagina;

            $totalRegistros = $arquivos->contaTodosRegistros();

            $this->view->paginacao = ceil(($totalRegistros[0]['total']) / $total_registros_pagina);

            $this->view->pagina_ativa = $pagina;

            $resultado = $arquivos->listarTodos($total_registros_pagina, $deslocamento);           

            $this->view->arquivos = $resultado;

            $this->render('resultado_pesquisa', 'appLayout');
            
        } else {        
            
            $arquivos->__set('nome_arquivo', '%'.trim($_GET['nome_usuario']).'%');

            $total_registros_pagina = 5;
            $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
            $deslocamento = ($pagina - 1) * $total_registros_pagina;

            $totalRegistros = $arquivos->contaTodosRegistrosPesquisa();

            $this->view->paginacao = $totalRegistros[0]['total'] > 0 ? ceil(($totalRegistros[0]['total']) / $total_registros_pagina) : 1;

            $this->view->pagina_ativa = $pagina;

            $resultado = $arquivos->pesquisarArquivos($total_registros_pagina, $deslocamento);

            $this->view->arquivos = $resultado;

            $this->render('resultado_pesquisa', 'appLayout');

        }
    }

    public function ver_arquivo() {

        $this->validaAutenticacao();

        $arquivos = Container::getModel('Arquivo');

        $arquivos->__set('id', $_GET['id']);

        $arquivos->verArquivo();

    }

    public function baixar_arquivo() {

        $this->validaAutenticacao();

        $arquivos = Container::getModel('Arquivo');

        $arquivos->__set('id', $_GET['id']);

        $arquivos->baixarArquivo();

    }

}


?>
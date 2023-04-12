<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['index'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['inscreverse'] = array(
			'route' => '/inscreverse',
			'controller' => 'indexController',
			'action' => 'inscreverse'
		);

		$routes['registrar'] = array(
			'route' => '/registrar',
			'controller' => 'indexController',
			'action' => 'registrar'
		);
		
		$routes['autenticar'] = array(
			'route' => '/autenticar',
			'controller' => 'AuthController',
			'action' => 'autenticar'
		);

		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);

		$routes['home'] = array(
			'route' => '/home',
			'controller' => 'AppController',
			'action' => 'pagina_inicial'
		);

		$routes['upload'] = array(
			'route' => '/upload',
			'controller' => 'AppController',
			'action' => 'upload'
		);

		$routes['enviar_arquivo'] = array(
			'route' => '/enviar_arquivo',
			'controller' => 'AppController',
			'action' => 'enviar_arquivo'
		);

		$routes['minha_conta'] = array(
			'route' => '/minha_conta',
			'controller' => 'AppController',
			'action' => 'minha_conta'
		);

		$routes['alterar_dados'] = array(
			'route' => '/alterar_dados',
			'controller' => 'AppController',
			'action' => 'alterar_dados'
		);

		$routes['pesquisar'] = array(
			'route' => '/pesquisar',
			'controller' => 'AppController',
			'action' => 'pesquisar'
		);

		$routes['ver_arquivo'] = array(
			'route' => '/ver_arquivo',
			'controller' => 'AppController',
			'action' => 'ver_arquivo'
		);

		$routes['baixar_arquivo'] = array(
			'route' => '/baixar_arquivo',
			'controller' => 'AppController',
			'action' => 'baixar_arquivo'
		);

		$this->setRoutes($routes);
	}

}

?>
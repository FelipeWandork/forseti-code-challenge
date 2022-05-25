<?php
namespace app\interfaces;

interface INavController {

	public function URLController( $host, $url ); // verifica validade da url
	public function PageController( $page ); // direciona para a rota requisitada

}

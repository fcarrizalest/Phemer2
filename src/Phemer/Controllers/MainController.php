<?php
namespace Phemer\Controllers;


class MainController{


	public function DashBoard(){

		return function(){
			$app = \Slim\Slim::getInstance();

		echo "aaaa";
			
		};

	}


	public function doLogin(){

		return function(){
			$app = \Slim\Slim::getInstance();


			echo json_encode( array( "ticket"=> "estesunticket" ) );
			
		};

	}

}
?>
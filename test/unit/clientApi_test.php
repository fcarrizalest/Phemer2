<?php
use Symfony\Component\Yaml\Parser;

require_once(dirname(__FILE__).'/../../vendor/lastcraft/simpletest/web_tester.php');


class TestOfclienApi extends WebTestCase{


	public function __construct(){

		$yaml = new Parser();

		$config = $yaml->parse(file_get_contents( dirname(__FILE__).'/../../config.yml'));

		

		$this->INETROOT =  $config['INETROOT'];
		$this->LOCALURL_ROOT = $config['LOCALURL_ROOT'];



	}
	public function TestOfABCA(){

		//$this->assertTrue( false ) ;

		$Client = file_get_contents($this->LOCALURL_ROOT. $this->INETROOT. "/install?unittest=1" );

		$Client = file_get_contents( $this->LOCALURL_ROOT. $this->INETROOT. "/api/client?unittest=1" );

		$jsonParse = json_decode(  $Client , true );

		$this->assertTrue (   ( $jsonParse['recordsTotal'] ==  "0" ) , "Nuestra Base de datos deberia estar vacia ") ;

		
		// Prueba de Agregar nuevo Cliente.

		$newClien = array( 
						"firstname" => "Cliente1",
						"title" => "Titulo1",
						"lastname" => "LasName",
					); 

		$newClientJson =  json_encode($newClien);

		$this->post($this->LOCALURL_ROOT. $this->INETROOT. "/api/client?unittest=1",$newClientJson );


		//Comprobamos que Existe nuestro nuevo cliente 

		$Client = file_get_contents( $this->LOCALURL_ROOT. $this->INETROOT. "/api/client?unittest=1" );

		$jsonParse = json_decode(  $Client , true );

		$this->assertTrue (   ( $jsonParse['recordsTotal'] ==  "1" ) , "Nuestra Base de datos deberia tener 1 registro") ;



		// Prueba de Editar Cliente.
		$clientToEdit = $jsonParse['data'][0] ;

		$clientToEdit['title'] = "Editado";


		$this->put($this->LOCALURL_ROOT. $this->INETROOT. "/api/client/".$clientToEdit['id']."?unittest=1", json_encode( $clientToEdit) );



		//Comprobamos Si se modifico nuestro  cliente 

		$Client = file_get_contents( $this->LOCALURL_ROOT. $this->INETROOT. "/api/client?unittest=1" );

		$jsonParse = json_decode(  $Client , true );

		$this->assertTrue (   ( $jsonParse['recordsTotal'] ==  "1" ) , "Nuestra Base de datos deberia tener 1 registro") ;

		
		$clientEdited = $jsonParse['data'][0] ;

		$this->assertTrue(  ( $clientEdited['title'] == "Editado" ) , "Nuestro Cliente no fue editado."  ) ;


		// Pruebas de Eliminación

		$this->delete($this->LOCALURL_ROOT. $this->INETROOT. "/api/client/".$clientEdited['id']."?unittest=1", json_encode( $clientToEdit) );

		//Comprobamos que se a eliminado.

		$Client = file_get_contents( $this->LOCALURL_ROOT. $this->INETROOT. "/api/client?unittest=1" );

		$jsonParse = json_decode(  $Client , true );

		$this->assertTrue (   ( $jsonParse['recordsTotal'] ==  "0" ) , "Nuestra Base de datos deberia tener 0 registros") ;





	}

}
?>
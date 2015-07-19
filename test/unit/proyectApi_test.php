<?php
use Symfony\Component\Yaml\Parser;

require_once(dirname(__FILE__).'/../../vendor/lastcraft/simpletest/web_tester.php');


class TestOfproyectApi extends WebTestCase{


	public function __construct(){

		$yaml = new Parser();

		$config = $yaml->parse(file_get_contents( dirname(__FILE__).'/../../config.yml'));


		$this->INETROOT =  $config['INETROOT'];
		$this->LOCALURL_ROOT = $config['LOCALURL_ROOT'];



	}
	public function TestOfABCA(){

		//$this->assertTrue( false ) ;

		$proyect = file_get_contents($this->LOCALURL_ROOT. $this->INETROOT. "/install?unittest=1" );

		$proyect = file_get_contents( $this->LOCALURL_ROOT. $this->INETROOT. "/api/proyect?unittest=1" );

		$jsonParse = json_decode(  $proyect , true );

		$this->assertTrue (   ( $jsonParse['recordsTotal'] ==  "0" ) , "Nuestra Base de datos deberia estar vacia ") ;

		
		// Prueba de Agregar nuevo Cliente.

		$newProyect = array( 
						"name" => "proyecto1",
						"description" => "description",
						"active" => "1",
					); 

		$newProyectJson =  json_encode($newProyect);

		$this->post($this->LOCALURL_ROOT. $this->INETROOT. "/api/proyect?unittest=1",$newProyectJson );


		//Comprobamos que Existe nuestro nuevo cliente 

		$proyect = file_get_contents( $this->LOCALURL_ROOT. $this->INETROOT. "/api/proyect?unittest=1" );

		$jsonParse = json_decode(  $proyect , true );

		$this->assertTrue (   ( $jsonParse['recordsTotal'] ==  "1" ) , "Nuestra Base de datos deberia tener 1 registro") ;



		// Prueba de Editar Cliente.
		$clientToEdit = $jsonParse['data'][0] ;

		$clientToEdit['name'] = "Editado";


		$this->put($this->LOCALURL_ROOT. $this->INETROOT. "/api/proyect/".$clientToEdit['id']."?unittest=1", json_encode( $clientToEdit) );



		//Comprobamos Si se modifico nuestro  cliente 

		$Client = file_get_contents( $this->LOCALURL_ROOT. $this->INETROOT. "/api/proyect?unittest=1" );

		$jsonParse = json_decode(  $Client , true );

		$this->assertTrue (   ( $jsonParse['recordsTotal'] ==  "1" ) , "Nuestra Base de datos deberia tener 1 registro") ;

		
		$clientEdited = $jsonParse['data'][0] ;

		$this->assertTrue(  ( $clientEdited['name'] == "Editado" ) , "Nuestro Proyect no fue editado."  ) ;


		// Pruebas de Eliminación

		$this->delete($this->LOCALURL_ROOT. $this->INETROOT. "/api/proyect/".$clientEdited['id']."?unittest=1", json_encode( $clientToEdit) );

		//Comprobamos que se a eliminado.

		$Client = file_get_contents( $this->LOCALURL_ROOT. $this->INETROOT. "/api/proyect?unittest=1" );

		$jsonParse = json_decode(  $Client , true );

		$this->assertTrue (   ( $jsonParse['recordsTotal'] ==  "0" ) , "Nuestra Base de datos deberia tener 0 registros") ;





	}

}
?>
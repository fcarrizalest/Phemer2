<?php
use Symfony\Component\Yaml\Parser;

class TestOfclienApi extends UnitTestCase{


	public function __construct(){

		$yaml = new Parser();

		$config = $yaml->parse(file_get_contents( dirname(__FILE__).'/../../config.yml'));

		

		$this->INETROOT =  $config['INETROOT'];
		$this->LOCALURL_ROOT = $config['LOCALURL_ROOT'];



	}
	public function TestOfABCA(){

		$this->assertTrue( false ) ;

		$Client = file_get_contents($this->LOCALURL_ROOT. $this->INETROOT. "/install?unittest=1" );

		$Client = file_get_contents( $this->LOCALURL_ROOT. $this->INETROOT. "/api/client?unittest=1" );

		echo $Client;



	}

}
?>
<?php
require_once(dirname(__FILE__).'/../vendor/lastcraft/simpletest/autorun.php');
//require_once(dirname(__FILE__).'/../vendor/lastcraft/simpletest/web_tester.php');


require dirname(__FILE__).'/../vendor/autoload.php';

class AllFileTests extends TestSuite {
    function __construct() {
        parent::__construct();
        $this->collect(dirname(__FILE__) . '/unit',
                       new SimplePatternCollector('/_test.php/'));
    }
}

?>
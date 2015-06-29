<?php
namespace Phemer\Utils;


class PhemerLog extends \Slim\Log{



	public function __construct( $path , $level  )
    {	
    	$app = \Slim\Slim::getInstance();	

        $nameLog = date( "Ymd" );


    	if( !file_exists($path . $nameLog.".html") ){
    		$handle = fopen($path . $nameLog.".html" , 'a+');
    		$header = '<html><head><style>		table {border-collapse: collapse;}		body, td, th, h1, h2 {font-family: sans-serif;}		th { border: 1px solid #000000; vertical-align: baseline; font-weight: bold; background-color: #4B3BD8; color: #ffffff; }		td { border: 1px solid #000000; vertical-align: baseline; }		.d {background-color: #eeeeee; color: #000000; }		.h {background-color: #dddddd; font-weight: bold; color: #000000;}	</style></head><body>' ;
			$header .= '<table><tr><th>Time</th><th>Level</th><th>Message</th></tr>'.PHP_EOL;
		
    		fwrite( $handle, $header );
    	}else{
    		$handle = fopen( $path . $nameLog.".html" , 'a+');
    	}


        $this->writer = new \Slim\LogWriter( $handle  ) ;
        $this->enabled = true;
        $this->level = $level ;
    }

	/**
     * Log message
     * @param  mixed       $level
     * @param  mixed       $object
     * @param  array       $context
     * @return mixed|bool What the Logger returns, or false if Logger not set or not enabled
     * @throws \InvalidArgumentException If invalid log level
     */
    public function log($level, $object, $context = array())
    {	


        if (!isset(self::$levels[$level])) {
            throw new \InvalidArgumentException('Invalid log level supplied to function');
        } else if ($this->enabled && $this->writer && $level <= $this->level) {
            $message = (string)$object;
            if (count($context) > 0) {
                if (isset($context['exception']) && $context['exception'] instanceof \Exception) {
                    $message .= ' - ' . $context['exception'];
                    unset($context['exception']);
                }
                $message = $this->interpolate($message, $context);
            }

            $table = '<tr>


            		<td> '.date("Y-m-d H:i:s").'  </td>
            		<td> '.\Slim\Log::$levels[$level].' </td>
            		<td>  '.$message.' </td>

            	</tr>';
            return $this->writer->write($table, $level);
        } else {
            return false;
        }
    }


}
?>
<?php
class Client extends \Illuminate\Database\Eloquent\Model
{

	public function __construct(array $attributes = array())
	{

		$fillable = array(  "firstname", "lastname", "title" );
		$this->fillable( $fillable);
		parent::__construct($attributes);


	}


	

}
?>
<?php
class Contact extends \Illuminate\Database\Eloquent\Model
{

	public function __construct(array $attributes = array())
	{

		$fillable = array(  "phone", "email", "website","location" );
		$this->fillable( $fillable);
		parent::__construct($attributes);


	}


	

}
?>
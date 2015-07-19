<?php
class Proyect extends \Illuminate\Database\Eloquent\Model
{

	public function __construct(array $attributes = array())
	{

		$fillable = array(  "name", "description", "active"  );
		$this->fillable( $fillable);
		parent::__construct($attributes);


	}


	

}
?>
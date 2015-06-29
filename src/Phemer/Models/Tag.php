<?php
class Tag extends \Illuminate\Database\Eloquent\Model
{

	public function __construct(array $attributes = array())
	{

		$fillable = array(  "name", "order"  );
		$this->fillable( $fillable);
		parent::__construct($attributes);


	}


	

}
?>
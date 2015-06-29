<?php
class Note extends \Illuminate\Database\Eloquent\Model
{

	public function __construct(array $attributes = array())
	{

		$fillable = array(  "title", "note"  );
		$this->fillable( $fillable);
		parent::__construct($attributes);


	}


	

}
?>
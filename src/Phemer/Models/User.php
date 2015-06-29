<?php

class User extends \Illuminate\Database\Eloquent\Model
{

    

	public function __construct(array $attributes = array())
	{

		$fillable = array( "username", "password", "email", 'active');
		$this->fillable( $fillable);
		parent::__construct($attributes);


	}

	public function roles()
    {
        return $this->belongsToMany('Role','users_roles','uid','rid');
    }


    public function getPermissionArray(){
    	$permissionArray = array();

    	$roles = $this->roles;
    	if (count( $roles  ) > 0 ) {
    	 		
    	 	foreach ($roles as $rol ) {
    	 		$permission = $rol->permission;
    	 		$tmp = array();
    	 		foreach ($permission as $perm ) {
    	 			$tmp[] = $perm->permission;
    	 		}
    	 			$permissionArray = array_merge( $permissionArray , $tmp ); 	
    	 	}
    	}

    	return $permissionArray;

    }

}
?>
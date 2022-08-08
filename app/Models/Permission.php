<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    public $guarded = [];

    public function menus()
    {
    	return $this->belongsToMany('App\Models\Menu');
    }
}

<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Pktharindu\NovaPermissions\Nova\Role as RoleResource;

class Role extends RoleResource
{
    /**
    * The side nav menu order.
    *
    * @var int
    */
    public static $priority = 101;
    
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Role::class;
}

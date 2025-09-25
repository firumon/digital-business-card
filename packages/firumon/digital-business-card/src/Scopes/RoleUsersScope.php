<?php

namespace Firumon\DigitalBusinessCard\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class RoleUsersScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $userRole = auth()->check() ? auth()->user()->role : "Individual";
        $appRoles = ['Developer','Administrator','Reseller','Manager','Individual'];
        $userRoleIdx = array_search($userRole,$appRoles);
        $allowedRoles = array_slice($appRoles,$userRoleIdx);
        $builder->whereIn('role',$allowedRoles);
    }
}

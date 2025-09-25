<?php

namespace Firumon\DigitalBusinessCard\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UserManageableIndividualScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if(auth()->hasUser()){
            if(auth()->user()->role === 'Individual'){
                $userId = auth()->user()->id; $sUserId = "%-".($userId)."-%";
                $builder->whereLike('users',$sUserId);
            }
        }
    }
}

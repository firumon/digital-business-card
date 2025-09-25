<?php

namespace Firumon\DigitalBusinessCard\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UserManageableCompanyScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if(auth()->hasUser()){
            if(auth()->user()->role === 'Individual'){
                $builder->has('Individuals');
            } else if(auth()->user()->role !== 'Developer'){
                $userId = auth()->user()->id; $sUserId = "%-".($userId)."-%";
                $builder->where('created_by',$userId)
                    ->orWhere(function ($query) use($sUserId) { $query->whereLike('users',$sUserId); })
                    ->orWhere(function ($query) {
                        $resellers = auth()->user()->Resellers->map->id->toArray();
                        $query->whereIn('created_by',$resellers);
                    });
            }
        }
    }
}

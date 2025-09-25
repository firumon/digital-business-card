<?php

namespace Firumon\DigitalBusinessCard\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UserAccessibleLayoutScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if(auth()->hasUser()){
            if(auth()->user()->role === 'Administrator'){
                $userId = auth()->user()->id; $sUserId = "%-".($userId)."-%";
                $builder->whereNull('admins')->orWhere('admins','like',$sUserId);
            } elseif (auth()->user()->role === 'Reseller') {
                $builder->whereNull('admins')->orWhere(function ($query){
                    $adminId = auth()->user()->Administrator->id; $sAUserId = "%-".($adminId)."-%";
                    $userId = auth()->user()->id; $sUserId = "%-".($userId)."-%";
                    $query->whereLike('admins',$sAUserId)->where(function($query) use($adminId,$sUserId){
                        $query->whereDoesntHave('Users',function ($query) use($adminId){ $query->where('user_id',$adminId); })
                            ->orWhereHas('Users',function ($query) use($adminId,$sUserId){ $query->where('user_id',$adminId)->whereLike('resellers',$sUserId); });
                    });
                });
            } elseif (auth()->user()->role === 'Manager') {
                $builder->whereHas('Companies');
            }
        }
    }
}

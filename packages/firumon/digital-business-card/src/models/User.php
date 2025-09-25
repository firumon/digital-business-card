<?php

namespace Firumon\DigitalBusinessCard\Models;

use App\Models\User as BaseUser;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends BaseUser
{
    protected $hidden = ['password','created_at','updated_at'];
    protected $casts = ['password' => 'hashed'];
    protected $with = [];
    protected $fillable = ['name','email','role','password','created_by'];
    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if(auth()->hasUser()){
                $user->created_by = auth()->id();
            }
        });
    }

    public function Resellers(): HasMany { return $this->hasMany(User::class,'created_by','id'); }
    public function Administrator(): BelongsTo { return $this->belongsTo(User::class,'created_by','id'); }

    public function Managers(): HasMany { return $this->hasMany(User::class,'created_by','id'); }
    public function Reseller(): BelongsTo { return $this->belongsTo(User::class,'created_by','id'); }

    public function Individuals(): HasMany { return $this->hasMany(User::class,'created_by','id'); }
    public function Manager(): BelongsTo { return $this->belongsTo(User::class,'created_by','id'); }
}

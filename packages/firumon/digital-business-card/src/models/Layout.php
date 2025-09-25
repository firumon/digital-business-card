<?php

namespace Firumon\DigitalBusinessCard\Models;

use Firumon\DigitalBusinessCard\Casts\AsHyphenSeperatedArray;
use Firumon\DigitalBusinessCard\Models\Scopes\UserAccessibleLayoutScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ScopedBy([UserAccessibleLayoutScope::class])]
class Layout extends Model
{
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
    protected $with = ['Properties','Users'];
    protected function casts(): array {
        return [
            "admins" => AsHyphenSeperatedArray::class,
        ];
    }

    protected static function booted(){
        static::deleting(function($Layout){ $Layout->Users()->delete(); });
    }

    public function Properties(): HasMany { return $this->hasMany(LayoutProperty::class); }
    public function Companies(): HasMany { return $this->hasMany(Company::class); }
    public function Users(): HasMany { return $this->hasMany(LayoutAdminReseller::class); }
}

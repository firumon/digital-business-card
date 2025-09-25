<?php

namespace Firumon\DigitalBusinessCard\Models;

use Firumon\DigitalBusinessCard\Casts\AsHyphenSeperatedArray;
use Firumon\DigitalBusinessCard\Models\Scopes\OwnLayoutAdminResellersScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([OwnLayoutAdminResellersScope::class])]
class LayoutAdminReseller extends Model
{
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
    protected function casts(): array {
        return [
            "resellers" => AsHyphenSeperatedArray::class
        ];
    }

    protected static function booted(){
        static::saved(function($LayoutAdminUser){
            if(is_null($LayoutAdminUser->resellers) || count($LayoutAdminUser->resellers) === 0) $LayoutAdminUser->delete();
        });
    }
}

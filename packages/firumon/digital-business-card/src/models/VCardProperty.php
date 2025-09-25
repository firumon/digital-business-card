<?php

namespace Firumon\DigitalBusinessCard\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class VCardProperty extends Model
{
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];

    protected function parameters(): Attribute {
        return Attribute::make(
            get: fn (string $value) => $value ? array_map("trim",explode(",",$value)) : [],
        );
    }

    public static function jsData(){
        return Cache::rememberForever('vCardPropertyJsData',function(){
            $jsonData = static::all()->toJson();
            return "const VCardProperty = " . $jsonData;
        });
    }
}

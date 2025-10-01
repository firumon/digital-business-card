<?php

namespace Firumon\DigitalBusinessCard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
    protected $casts = ['params' => 'json'];

    public function VCardProperty(): BelongsTo{ return $this->belongsTo(VCardProperty::class); }
    public function Layouts(): HasMany { return $this->hasMany(LayoutProperty::class,'property_name','name'); }
    public function Companies(): HasMany { return $this->hasMany(CompanyProperty::class,'property_name','name'); }
    public function Individuals(): HasMany { return $this->hasMany(CompanyIndividual::class,'property_name','name'); }
}

<?php

namespace Firumon\DigitalBusinessCard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndividualProperty extends Model
{
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];

    public function Property(): BelongsTo { return $this->belongsTo(LayoutProperty::class,'property_name','name'); }
}

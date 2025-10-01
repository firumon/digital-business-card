<?php

namespace Firumon\DigitalBusinessCard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LayoutProperty extends Model
{
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
    protected $casts = ['image' => 'bool','mandatory' => 'bool','params' => 'json'];
    protected $touches = ['Layout'];

    public function Layout(): BelongsTo { return $this->belongsTo(Layout::class); }
    public function Property(): BelongsTo { return $this->belongsTo(Property::class,'property_name','name'); }
}

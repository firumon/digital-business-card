<?php

namespace Firumon\DigitalBusinessCard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CompanyProperty extends Model
{
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];

    public function Layout(): BelongsTo { return $this->belongsTo(Layout::class); }
    public function Company(): BelongsTo { return $this->belongsTo(Company::class); }
    public function Property(): BelongsTo { return $this->belongsTo(LayoutProperty::class,'property_name','name'); }
}

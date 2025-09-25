<?php

namespace Firumon\DigitalBusinessCard\Models;

use Firumon\DigitalBusinessCard\Casts\AsHyphenSeperatedArray;
use Firumon\DigitalBusinessCard\Models\Scopes\UserManageableCompanyScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ScopedBy([UserManageableCompanyScope::class])]
class Company extends Model
{
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
    protected $casts = ['users' => AsHyphenSeperatedArray::class,'logo_width' => 'integer','logo_height' => 'integer'];

    protected static function booted(): void
    {
        static::creating(function (Company $company) {
            if(auth()->hasUser()){
                $company->created_by = auth()->id();
            }
        });
    }

    public function Layout(): BelongsTo { return $this->belongsTo(Layout::class); }
    public function Properties(): HasMany { return $this->hasMany(CompanyProperty::class); }
    public function Individuals(): HasMany { return $this->hasMany(CompanyIndividual::class); }
    public function Creator(): BelongsTo { return $this->belongsTo(User::class,'created_by','id'); }

    public static function CompanyId($company_code): int {
        if(!$company_code) abort(403);
        return self::where('code',$company_code)->first()->id;
    }
}

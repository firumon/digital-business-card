<?php

namespace Firumon\DigitalBusinessCard\Models;

use Firumon\DigitalBusinessCard\Casts\AsHyphenSeperatedArray;
use Firumon\DigitalBusinessCard\Models\Scopes\UserManageableIndividualScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[ScopedBy([UserManageableIndividualScope::class])]
class CompanyIndividual extends Model
{
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
    protected static $digits = 4;
    public static $fields = ['code','name'];
    protected $casts = ['users' => AsHyphenSeperatedArray::class];

    protected static function booted() {
        static::creating(function($individual){ $individual->code = self::NextIndividualCode($individual->company_id); });
    }

    public function Company(): BelongsTo { return $this->belongsTo(Company::class); }
    public function Properties(): HasMany { return $this->hasMany(IndividualProperty::class); }

    public static function NextIndividualCode($company_id): string {
        $company_code = Company::find($company_id)->code; $code_length = strlen($company_code);
        $max_num = self::where('code', 'like', "{$company_code}%")->selectRaw("MAX(CAST(SUBSTRING(code, ".($code_length+1).", ".(self::$digits).") AS UNSIGNED)) as max_num")->value('max_num') ?? 0;
        return Str::of(intval($max_num)+1)->padLeft(self::$digits,'0')->prepend($company_code)->value();
    }
}

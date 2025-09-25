<?php

namespace Firumon\DigitalBusinessCard\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\isNull;

class AsHyphenSeperatedArray implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): null|array
    {
        $value = is_null($value) ? '' : substr(trim($value),1,-1);
        return trim($value) === "" ? [] : array_map(fn($item) => $this->toNumberIfNumeric($item),explode("-",$value));
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): null|string
    {
        $value = is_array($value) ? (count($value) === 0 ? null : $value) : (trim($value) === "" ? null : trim($value));
        return is_null($value) ? null : "-" . (((is_array($value)) ? implode("-",array_map(fn($text) => $this->toNumberIfNumeric($text),$value)) : ($this->isComaSeperatedString($value) ? implode("-",array_map(fn($text) => $this->toNumberIfNumeric($text),explode(",",$value))) : $this->toNumberIfNumeric($value)))) . "-";
    }

    public function toNumberIfNumeric($text):int|string { return is_numeric($text) ? intval($text) : trim($text); }
    public function isComaSeperatedString($text):bool { return str_contains($text,","); }
}

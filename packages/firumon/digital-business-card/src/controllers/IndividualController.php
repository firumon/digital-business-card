<?php

namespace Firumon\DigitalBusinessCard\Controllers;

use App\Http\Controllers\Controller;
use Firumon\DigitalBusinessCard\Models\CompanyIndividual;
use Firumon\DigitalBusinessCard\Models\IndividualProperty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class IndividualController extends Controller
{
    public static function individual_data($code): Model {
        return CompanyIndividual::with(['Attrs','Company'])->where('code',$code)->firstOrFail();
    }

    public static function flatten($individual): array {
        $flatten = $individual->only(['code','name','designation']);
        $individual->Attrs->each(function($attr)use(&$flatten){ $flatten[$attr->attr] = $attr->value; });
        return $flatten;
    }

    public function individual(Request $request){
        return ($request->filled('code') && $request->input('code') !== 'NEW')
            ? $this->update_individual($request->input('individual'))
            : $this->create_individual($request->input('individual'));
    }

    public function update_individual($individual): array {
        $code = $individual['code']; $name = $individual['name'];// $designation = $individual['designation'];
        $Individual = CompanyIndividual::where('code',$code)->first(); $company_individual_id = $Individual->id;
        $Individual->update(compact('name'));
        foreach ($individual as $attr => $value){
            if(in_array($attr,CompanyIndividual::$fields)) continue;
            IndividualProperty::updateOrCreate(compact('company_individual_id','attr'),compact('value'));
        }
        return self::flatten($Individual->fresh(['Attrs']));
    }

    public function create_individual($individual): array {
        $company_code = request()->user()->Company->code; $company_id = request()->user()->Company->id;
        $code = $company_code . CompanyIndividual::NextIndividualNumber($company_id);
        $name = $individual['name']; $designation = $individual['designation'];
        $Individual = CompanyIndividual::create(compact('code','name','designation','company_id'));
        $Properties = [];
        foreach ($individual as $property_name => $value){
            if(in_array($property_name,CompanyIndividual::$fields)) continue;
            $Properties[] = new IndividualProperty(compact('property_name','value'));
        }
        if(!empty($Properties)) $Individual->Properties()->saveMany($Properties);
        return self::flatten($Individual->fresh(['Properties']));
    }
}

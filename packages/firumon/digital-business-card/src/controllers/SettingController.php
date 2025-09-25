<?php

namespace Firumon\DigitalBusinessCard\Controllers;

use App\Http\Controllers\Controller;
use Firumon\DigitalBusinessCard\Models\Company;
use Firumon\DigitalBusinessCard\Models\IndividualProperty;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function setting(Request $request) {
        $method = $request->setting;
        return $this->$method($request);
    }

    public function BC(Request $request) {
        $company_id = request()->user()->Company->id;
        $Layout = Company::find($company_id)->Layout;
        $Layout->{ $request->input('item') } = $request->input('colors');
        $Layout->save(); $Layout->fresh(); return $Layout;
    }

    public function APR(Request $request) {
        $company_id = request()->user()->Company->id;
        $Company = Company::with(['Layout.Master.Attrs','Params'])->find($company_id); $layout_master_id = $Company->Layout->layout_master_id;
        $params = $Company->Layout->Master->Attrs->reject(fn($Attr) => $Attr->individual)->map->attr->toArray();
        $param = $request->input('param'); $value = $request->input('value');
        if(in_array($param,$params)){
            if($value === "" || $value === null) IndividualProperty::where(compact('company_id','layout_master_id','param'))->delete();
            else IndividualProperty::updateOrCreate(compact('layout_master_id','company_id','param'),compact('value'));
        }
        return $Company->Params->fresh();
    }

    public function LGO(Request $request) {
        $company_id = request()->user()->Company->id;
        $Company = Company::with(['Logo'])->find($company_id);
        $Company->Logo->{$request->input('field')} = $request->input('value');
        $Company->Logo->save();
        return $Company->Logo->fresh();
    }

    public function ACT(Request $request) {
        $company_id = request()->user()->Company->id;
        $Company = Company::with(['Actions'])->find($company_id);
        $idIndex = $Company->Actions->mapWithKeys(fn($Action,$idx) => [$Action->id => $idx])->toArray();
        switch ($request->input('method')){
            case 'delete':
                $id = $request->input('id');
                $Company->Actions[$idIndex[$id]]->delete();
                break;
            case 'update':
                $id = $request->input('id');
                $Company->Actions[$idIndex[$id]]->{$request->input('field')} = $request->input('value');
                $Company->push();
                break;
            case 'create':
                $Company->Actions()->save(new Action($request->only(['label','type','extra'])));
                $Company->load('Actions');
                break;
        }
        return $Company->Actions->fresh();
    }
}

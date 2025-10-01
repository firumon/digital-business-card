<?php

namespace Firumon\DigitalBusinessCard\Controllers;

use App\Http\Controllers\Controller;
use Firumon\DigitalBusinessCard\Models\CompanyIndividual;
use Firumon\DigitalBusinessCard\Models\Property;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ScriptController extends Controller
{

    public function returnWithScriptHeader($responseText) {
        return response($responseText,200,["content-type" => "text/javascript"]);
    }
    public function VCardProperty(){
        return $this->returnWithScriptHeader(\Firumon\DigitalBusinessCard\Models\VCardProperty::jsData());
    }
    public function Layout($code){
        $Layout = CompanyIndividual::withoutGlobalScopes()->where('code',$code)->with(['Company.Layout.Properties'])->first()->Company->Layout;
        return $this->returnWithScriptHeader("const __Layout__ = " . $Layout->toJson());
    }
    public function Company($code){
        $Company = CompanyIndividual::withoutGlobalScopes()->where('code',$code)->with(['Company.Properties'])->first()->Company;
        return $this->returnWithScriptHeader("const __Company__ = " . $Company->toJson());
    }
    public function Individual($code){
        $Individual = CompanyIndividual::withoutGlobalScopes()->where('code',$code)->with(['Properties'])->first();
        return $this->returnWithScriptHeader("const __Individual__ = " . $Individual->toJson());
    }
    public function Property(){
        $Properties = Property::withoutGlobalScopes()->get();
        return $this->returnWithScriptHeader("const __Properties__ = " . $Properties->toJson());
    }
}

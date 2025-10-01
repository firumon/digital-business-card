<?php

namespace Firumon\DigitalBusinessCard\Controllers;

use App\Http\Controllers\Controller;
use Firumon\DigitalBusinessCard\Models\Company;
use Firumon\DigitalBusinessCard\Models\CompanyIndividual;
use Firumon\DigitalBusinessCard\Models\Layout;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicController extends Controller
{

    public function app($code){
        $Individual = CompanyIndividual::withoutGlobalScopes()->where('code',$code)->first();
        $Company = Company::withoutGlobalScopes()->find($Individual->company_id);
        $Layout = Layout::withoutGlobalScopes()->find($Company->layout_id);
        return view('dbc::app')->with(compact('Layout','Company','Individual','code'));
    }
}

<?php

namespace Firumon\DigitalBusinessCard\Controllers;

use App\Http\Controllers\Controller;
use Firumon\DigitalBusinessCard\Models\Company;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RouteController extends Controller
{

    public function app_view_company(): View {
        $code = session()->get('company_code',null);
        if(!$code) abort('404');
        return view('dbc::app')->with('data',$this->company_data($code));
    }

    public function app_view_individual($code): View {
        $data = $this->company_data_individual($code);
        session(['company_code' => $data['company']['code']]);
        return view('dbc::app')->with('data',$data);
    }

    private function company_data_individual($code): array {
        $individual_data = IndividualController::individual_data($code);
        $company_code = $individual_data->Company->code;
        return array_merge($this->company_data($company_code),['individual' => IndividualController::flatten($individual_data)]);
    }
    private function company_data($code): array {
        $company_data = CompanyController::company_data($code);
        return $this->app_view_rearrange_data($company_data);
    }

    private function app_view_rearrange_data($company_data): array {
        $theme = CompanyController::theme_from_company_layout($company_data->layout);
        $company_params = $company_data->Params->mapWithKeys(fn($param) => [$param->param => $param->value])->toArray();
        /*$individuals_array = $company_data->Individuals->map->code->toArray();*/
        $logo = $company_data->Logo->only(['url','width','height']);
        $params = $company_data->Params->mapWithKeys(fn($param) => [$param->param => $param->value])->toArray();
        $actions = $company_data->Actions->map(fn($action) => $action->only(['label','type','url']))->toArray();
        $individual_attrs = $company_data->Layout->Master->Attrs->filter->individual->map->attr->values()->toArray();
        $mandatory_attrs = $company_data->Layout->Master->Attrs->filter->mandatory->map->attr->values()->toArray();
        $contact_attrs = $company_data->Layout->Master->Attrs->filter->contact->map->attr->values()->toArray();
        /*$individuals = $company_data->Individuals->mapWithKeys(fn($individual) => [$individual->code => IndividualController::flatten($individual)])->toArray();*/
        $company = ['code' => $company_data->code,'name' => $company_data->name,'layout' => $company_data->Layout->Master->name/*, 'individuals' => $individuals_array*/, 'logo' => $logo, 'params' => $company_params];
        $layout = array_merge($params,['actions' => $actions],['individual' => $individual_attrs],['mandatory' => $mandatory_attrs],['contacts' => $contact_attrs]);
        return compact('theme','company','layout');
    }

    public function company_admin(Request $request): View {
        $company_code = $request->user()->Company->code;
        $company = Company::where('code',$company_code)->with(['Layout.Master.Attrs','Logo','Params','Actions'])->first();
        $individuals = Company::where('code',$company_code)->with('Individuals.Attrs')->first()->Individuals->mapWithKeys(fn($individual) => [$individual->code => IndividualController::flatten($individual)]);
        return view('dbc::company_admin')->with(compact('company','individuals'));
    }

    private function handleCompanyAdminPost(): void {

    }
}

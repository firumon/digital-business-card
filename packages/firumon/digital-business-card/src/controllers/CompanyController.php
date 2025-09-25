<?php

namespace Firumon\DigitalBusinessCard\Controllers;

use App\Http\Controllers\Controller;
use Firumon\DigitalBusinessCard\Models\Company;
use Firumon\DigitalBusinessCard\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public static function company_data($code): Model {
        return Company::where('code',$code)->with(['Layout.Properties','Properties'])->firstOrFail();
    }

    public static function theme_from_company_layout($layout): array {
        return $layout->only(['brand','color']);
    }

    public function all(): Collection {
        if(!auth()->hasUser()) return new Collection();
        if(auth()->user()->role === 'Individual') return Company::with('Individuals.Properties','Properties')->get();
        if(auth()->user()->role === 'Manager') return Company::with('Individuals.Properties','Properties')->where('users','like',"%-".(auth()->id())."-%")->get();
        if(auth()->user()->role === 'Reseller') return Company::with('Individuals.Properties','Properties')->where('created_by',auth()->id())->get();
        return Company::where('created_by',auth()->id())->orWhere(function ($query){
            $adminResellers = auth()->user()->Resellers->map->id->toArray();
            $query->whereIn('created_by',$adminResellers);
        })->with(['Individuals.Properties','Properties'])->get();
    }
    public function save(Request $request): Collection {
        if($request->isNotFilled(['code','name'])) return $this->all();
        $code = $request->input('code');
        if(Company::where('code',$code)->exists()) return $this->all();
        Company::create($request->all());
        return $this->all();
    }
    public function update(Request $request): Collection {
        $request->whenFilled('id',function ($id) use($request){
            Company::find($id)->update($request->all());
        });
        return $this->all();
    }

    public function addIndividual(Request $request){
        $company_id = $request->input('company_id'); $name = $request->input('individual_name');
        $Company = Company::find($company_id); $Company->Individuals()->create(compact('name'));
        return $this->all();
    }

    public function syncProperties(Request $request){
        $company_id = $request->input('company_id');
        $Company = Company::with('Properties')->find($company_id);
        $cPropsByName = $Company->Properties->keyBy->property_name;
        $data = $request->except('company_id');
        foreach ($data as $property_name => $value) {
            if(is_null($value)) { if($cPropsByName->has($property_name)) $cPropsByName[$property_name]->delete(); }
            else $Company->Properties()->updateOrCreate(compact('property_name'),compact('value'));
        };
        return $this->all();
    }

    public function updateIndividualName(Request $request){
        $company_id = $request->input('company_id');
        $individual_id = $request->input('individual_id'); $name = $request->input('name');
        Company::find($company_id)->Individuals()->find($individual_id)->update(compact('name'));
        return $this->all();
    }
    public function updateIndividualProperties(Request $request){
        $company_id = $request->input('company_id'); $individual_id = $request->input('individual_id');
        $Individual = Company::find($company_id)->Individuals()->with('Properties')->find($individual_id);
        $keyedProperties = $Individual->Properties->keyBy->property_name;
        $properties = $request->except(['company_id','individual_id']);
        foreach ($properties as $property_name => $value){
            if(is_null($value) || trim($value) === '') { if($keyedProperties->has($property_name)) $keyedProperties[$property_name]->delete(); }
            else $Individual->Properties()->updateOrCreate(compact('property_name'),compact('value'));
        }
        return $this->all();
    }

    public function addUser(Request $request){
        $company_id = $request->input('company_id');
        $user_details = $request->input('user'); $user_details['role'] = 'Manager';
        $user = new User($user_details); $user->save();
        $company = Company::find($company_id);
        $company->users = array_values(array_merge($company->users,[$user->id]));
        $company->save();
        return $this->all();
    }
    public function syncUsers(Request $request){
        $company_id = $request->input('company_id');
        $users = $request->input('user_ids');
        $company = Company::find($company_id);
        $company->users = $users; $company->save();
        return $this->all();
    }
    public function addIndividualUser(Request $request){
        $company_id = $request->input('company_id'); $individual_id = $request->input('individual_id');
        $company = Company::find($company_id);
        if($company){
            $individual = $company->Individuals()->find($individual_id);
            if($individual){
                $user_details = $request->input('user'); $user_details['role'] = 'Individual';
                $user = new User($user_details); $user->save();
                $individual->users = array_values(array_merge($individual->users,[$user->id]));
                $individual->save();
            }
        }
        return $this->all();
    }

    public function addIndividualUserLogin(Request $request){
        $company_id = $request->input('company_id'); $individual_id = $request->input('individual_id'); $user_id = $request->input('user_id');
        $company = Company::find($company_id);
        if($company){
            $individual = $company->Individuals()->find($individual_id);
            if($individual){
                $individual->users = array_values(array_merge($individual->users,[$user_id]));
                $individual->save();
            }
        }
        return $this->all();
    }
    public function removeIndividualUserLogin(Request $request){
        $company_id = $request->input('company_id'); $individual_id = $request->input('individual_id'); $user_id = $request->input('user_id');
        $company = Company::find($company_id);
        if($company){
            $individual = $company->Individuals()->find($individual_id);
            if($individual){
                $individual->users = array_values(array_diff($individual->users,[$user_id]));
                $individual->save();
            }
        }
        return $this->all();
    }
}

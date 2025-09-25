<?php

namespace Firumon\DigitalBusinessCard\Controllers;

use App\Http\Controllers\Controller;
use Firumon\DigitalBusinessCard\Models\User;
use Firumon\DigitalBusinessCard\Scopes\RoleUsersScope;
use Illuminate\Contracts\Auth\Authenticatable;
use \Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    private static array $addUserAllowedRolesForRole = ['Developer' => ['Administrator'],'Administrator' => ['Reseller','Manager','Individual'],'Reseller' => ['Manager','Individual'],'Manager' => ['Individual']];

    public function getAll():Collection {
        if(!auth()->hasUser()) return new Collection();
        if(auth()->user()->role === 'Developer') return User::whereIn('role',['Administrator'])->get();
        if(auth()->user()->role === 'Manager') return User::where('created_by',auth()->id())->get();
        if(auth()->user()->role === 'Reseller') {
            $IAmCreated = User::where('created_by',auth()->id())->with('Managers.Individuals')->get();
            $Managers = $IAmCreated->flatMap->Managers; $Individuals = $Managers->flatMap->Individuals;
            return $IAmCreated->merge($Managers)->merge($Individuals);
        }
        if(auth()->user()->role === 'Administrator') {
            $IAmCreated = User::where('created_by',auth()->id())->with('Resellers.Managers.Individuals')->get();
            $Resellers = $IAmCreated->flatMap->Resellers; $Managers = $Resellers->flatMap->Managers; $Individuals = $Managers->flatMap->Individuals;
            return $IAmCreated->merge($Resellers)->merge($Managers)->merge($Individuals);
        }
        return User::where('created_by',auth()->id())->get();
    }

    public function profileUpdate(Request $request):Authenticatable {
        $data = [];
        if($request->filled('name')) $data['name'] = $request->input('name');
        if($request->filled('email')) $data['email'] = $request->input('email');
        Auth::user()->update($data);
        return Auth::user();
    }
    public function profilePasswordUpdate(Request $request):Authenticatable {
        if($request->whenFilled('password',function($password){
            Auth::user()->password = $password;
            Auth::user()->save();
        }));
        return Auth::user();
    }

    public function add(Request $request): Collection {
        $role = $request->input('role');
        if(in_array($role,self::$addUserAllowedRolesForRole[$request->user()->role])){
            $data = $request->all(['name','email','password','role']);
            User::create($data);
        }
        return $this->getAll();
    }

    public function userUpdate(Request $request):Collection {
        $id = $request->input('id'); $data = [];
        if($id){
            if($request->filled('name')) $data['name'] = $request->input('name');
            if($request->filled('email')) $data['email'] = $request->input('email');
            $User = User::find($id); $User->update($data);
        }
        return $this->getAll();
    }
    public function userPasswordUpdate(Request $request):Collection {
        $id = $request->input('id');
        if($request->whenFilled('password',function($password)use($id){
            $User = User::find($id); $User->password = $password;
            $User->save();
        }));
        return $this->getAll();
    }

    public function adminResellers(){
        if(auth()->hasUser() && auth()->user()->role === 'Administrator') return auth()->user()->Resellers;
        return collect([]);
    }
}

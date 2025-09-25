<?php

namespace Firumon\DigitalBusinessCard\Controllers;

use App\Http\Controllers\Controller;
use Firumon\DigitalBusinessCard\Models\Layout;
use Firumon\DigitalBusinessCard\Models\LayoutProperty;
use \Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;


class LayoutController extends Controller
{
    public function getAllWithProperties():Collection {
        return Layout::with('Properties','Users')->get();
    }
    public function save(Request $request):Collection {
        $data = $request->all();
        Layout::create($data);
        return $this->getAllWithProperties();
    }
    public function delete(Request $request):Collection {
        $layout_id = $request->input('id');
        Layout::destroy($layout_id);
        $this->deleteLayoutPropertiesOfLayout($layout_id);
        return $this->getAllWithProperties();
    }
    public function deleteLayoutPropertiesOfLayout($layout_id):bool|null {
        return LayoutProperty::where(compact('layout_id'))->delete();
    }
    public function update(Request $request):Collection {
        $layout_id = $request->input('id');
        $update_data = $request->except(['id']);
        Layout::where('id',$layout_id)->update($update_data);
        return $this->getAllWithProperties();
    }

    public function addProperty(Request $request){
        $layout_id = $request->input('layout_id');
        $data = $request->except(['layout_id']);
        Layout::find($layout_id)->Properties()->create($data);
        return $this->getAllWithProperties();
    }
    public function updateProperty(Request $request){
        $layout_id = $request->input('layout_id');
        $Layout = Layout::find($layout_id);
        $layout_property_id = $request->input('layout_property_id');
        $data = $request->except(['layout_id','layout_property_id']);
        $Layout->Properties()->find($layout_property_id)->delete();
        $Layout->Properties()->create($data);
        return $this->getAllWithProperties();
    }
    public function deleteProperty(Request $request){
        $layout_id = $request->input('layout_id');
        $Layout = Layout::find($layout_id);
        $layout_property_id = $request->input('layout_property_id');
        $Layout->Properties()->find($layout_property_id)->delete();
        return $this->getAllWithProperties();
    }
    public function updateUsers(Request $request){
        $layout_id = $request->input('layout_id');
        $Layout = Layout::find($layout_id);
        $role_name = $request->input('role_name');
        $users = $request->input('access_users');
        if($role_name === 'Administrator'){
            $Layout->admins = $users; $Layout->save();
        } elseif ($role_name === 'Reseller') {
            $user_id = auth()->id();
            $Layout->Users()->updateOrCreate(['user_id' => $user_id],['resellers' => $request->input('access_users')]);
        }
        return $this->getAllWithProperties();
    }
}

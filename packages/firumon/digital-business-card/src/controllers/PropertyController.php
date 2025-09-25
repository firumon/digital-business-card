<?php

namespace Firumon\DigitalBusinessCard\Controllers;

use App\Http\Controllers\Controller;
use Firumon\DigitalBusinessCard\Models\Layout;
use Firumon\DigitalBusinessCard\Models\LayoutProperty;
use Firumon\DigitalBusinessCard\Models\Property;
use \Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;


class PropertyController extends Controller
{
    public function all(){ return Property::all(); }
    public function save(Request $request){
        $data = $request->all(['name','v_card_property_id','value','params','description','example']);
        Property::create($data);
        return $this->all();
    }
    public function delete(Request $request) {
        Property::destroy($request->input('id'));
        return $this->all();
    }

}

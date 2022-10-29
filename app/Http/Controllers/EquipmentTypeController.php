<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentTypeCollection;
use App\Models\EquipmentType;
use Illuminate\Http\Request;

class EquipmentTypeController extends Controller
{
    public function index(Request $request){

        if ($request->get('q')){
            return new EquipmentTypeCollection(EquipmentType::where('name','LIKE','%'.$request->get('q').'%')->get());
        }

        return new EquipmentTypeCollection(EquipmentType::paginate(5));
    }
}

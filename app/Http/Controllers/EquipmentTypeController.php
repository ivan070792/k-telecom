<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentTypeCollection;
use App\Http\Resources\EquipmentTypeResource;
use App\Models\EquipmentType;
use Illuminate\Http\Request;

class EquipmentTypeController extends Controller
{
    public function index(){
        return new EquipmentTypeCollection(EquipmentType::paginate(5));
    }
}

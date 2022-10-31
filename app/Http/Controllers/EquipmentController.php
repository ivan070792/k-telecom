<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentCollection;
use App\Http\Resources\EquipmentResource;
use App\Http\Resources\EquipmentStoreCollection;
use App\Http\Resources\ErrorResource;
use App\Models\Equipment;
use App\Rules\SerialNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EquipmentController extends Controller
{
    //
    public function index(Request $request){

        if ($request->get('q')){
            return new EquipmentCollection(Equipment::where('serial_number','LIKE','%'.$request->get('q').'%')->get());
        }

        return new EquipmentCollection(Equipment::paginate(50));
    }

    public function show($id){
        return new EquipmentResource(Equipment::findOrFail($id));
    }

    public function destroy($id){
        $equipment = Equipment::findOrFail($id);
            $equipment->delete();
            return response([
                'status' => 'success',
                'message' => 'Deleted',
            ]);
    }



    public function store(Request $request){

        
        $data = $request->data;
        
        $result = (object) [
            'errors' => [],
            'success' => []
        ];
        
        foreach($data as $key=>$equipment){
            $validator = Validator::make($equipment, [
                'equipment_type_id' => 'required|exists:equipment_types,id',
                'serial_number' => ['bail', 'required', 'string', 'size:10', 'unique:equipment,serial_number' , new SerialNumber],
                'desc' => 'string'
            ]);
            if ($validator->fails()) {
                $error = (object) (
                    [
                        'status' => 'Bad Request',
                        'code' => 400,
                        'message' => $validator->errors()->first()
                    ]
                );
                $result->errors[$key] = new ErrorResource($error);
            }else{
                $newEquipment = Equipment::create($equipment);
                $result->success[$key] = new EquipmentResource($newEquipment);
            }
        }
        return $result;
    }

    public function update($id, Request $request){

        $equipment = Equipment::findOrFail($id);

        if(!isset($request->all()['equipment_type_id'])){
            $request->merge(['equipment_type_id' => $equipment->equipment_type_id]);
        }
        $validator = Validator::make($request->all(), [
            'equipment_type_id' => 'exists:equipment_types,id',
            'serial_number' => ['bail', 'required' ,'string', 'size:10', new SerialNumber,],
            'desc' => 'string'
        ]);

        if ($validator->fails()) {
           return response([
                'status' => 'error',
                'message' => $validator->errors()->first()
           ], 400);
        }else{
            $equipment->update($request->all());
            return new EquipmentResource($equipment);
        }

    }
}

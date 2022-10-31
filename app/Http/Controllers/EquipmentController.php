<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentCollection;
use App\Http\Resources\EquipmentResource;
use App\Http\Resources\ErrorCollection;
use App\Http\Resources\ErrorResource;
use App\Models\Equipment;
use App\Rules\SerialNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EquipmentController extends Controller
{
    /**
     * Display a listing equipment.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return EquipmentCollection
     */
    public function index(Request $request){

        if ($request->get('q')){
            return new EquipmentCollection(Equipment::where('serial_number','LIKE','%'.$request->get('q').'%')->get());
        }

        return new EquipmentCollection(Equipment::paginate(50));
    }

    /**
     * Display the specified equipment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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


    /**
     * Store equipment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array \Illuminate\Http\Response
     */
    public function store(Request $request){

        
        $data = $request->data;
        $errors = [];
        $success = [];
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
                $errors[$key] = new ErrorResource($error);
            }else{
                $newEquipment = Equipment::create($equipment);
                $success[$key] = new EquipmentResource($newEquipment);
            }
        }
        $result->errors = new ErrorCollection($errors);
        $result->success = new EquipmentCollection($success);
        return response((array)$result, 200);
    }

    /**
     * Update equipment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return array \Illuminate\Http\Response or EquipmentResource
     */
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

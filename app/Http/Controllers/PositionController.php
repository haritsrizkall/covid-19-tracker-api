<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
    public function getByUserId(Request $request, $person_id = null){
        $person_id = (int)$person_id;
       if ($person_id == null || $person_id == 0) {
           # code...
           $response = createFailedResponse(400, "error", "Wrong type param", null);
           return $response;
       }
        if ($person_id == null) {
            # code...
            $position = Position::all();
            $response = createSuccessResponse(200, "success", "Get all position success", $position);
            return $response;
        }
        $position = Position::where('person_id', $person_id)->get();
        $response = createSuccessResponse(200, "success", "Get position by user id success", $position);
        return $response;
    }

    public function create(Request $request, $person_id = null){
        $personId = (int)$person_id;
        if ($personId == 0) {
            # code...
            $response = createFailedResponse(400, "error", "Wrong param type", null);
            return $response;
        }
        $validator = Validator::make($request->all(), [
            'longitude' => 'required',
            'latitude' => 'required',
            'date_time' => 'required'
        ]);
        if ($validator->fails()) {
            # code...
            $response = createFailedResponse(400, "error", "Failed to create person position ", $validator->errors());
            return $response;
        }
        $position = Position::create([
            'person_id' => $personId,
            'longitude' => $request->input('longitude'),
            'latitude' => $request->input('latitude'),
            'date_time' => $request->input('date_time')
        ]);
        $dataRepsonse = [
            'person_id' => $personId,
            'longitude' => $request->input('longitude'),
            'latitude' => $request->input('latitude'),
            'date_time' => $request->input('date_time')
        ];
        $response = createSuccessResponse(200, "success", "Position has been created to that person", $dataRepsonse);
        return $response;
    }
   
    public function delete(Request $request, $person_id, $position_id){
        $person_id = (int)$person_id;
        $position_id = (int)$position_id;
        if ($person_id == 0 || $position_id == 0) {
            # code...
            $response = createFailedResponse(400, "error", "Wrong param type", null);
            return $response;
        }
        $deletedPosition = Position::where('person_id', $person_id)
                                        ->where('id', $position_id)
                                        ->delete();
        if ($deletedPosition == 0) {
           # code...
           $response = createFailedResponse(400, "error", "Person or position not found", null);
           return $response;
        }
        $response = createSuccessResponse(200, "success", "Success to delete position person", null);
        return $response;
    }

    public function getById(Request $request, $person_id, $position_id){
        $person_id = (int)$person_id;
        $position_id = (int)$position_id;
        if ($person_id == 0 || $position_id == 0) {
            # code...
            $response = createFailedResponse(400, "error", "Wrong param type", null);
            return $response;
        }
        $position = Position::where('person_id', $person_id)
                                ->where('id', $position_id)
                                ->first();
        if ($position == null) {
           # code...
           $response = createFailedResponse(400, "error", "Person or position not found", null);
           return $response;
        }
        $response = createSuccessResponse(200, "success", "Success to get position person", $position);
        return $response;
    }   
}

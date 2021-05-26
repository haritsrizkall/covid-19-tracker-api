<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function getByUserId(Request $request, $person_id = null){
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

   
    
}

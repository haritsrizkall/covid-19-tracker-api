<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function getByUserId(Request $request, $user_id = null){
        if ($user_id == null) {
            # code...
            $position = Position::all();
            $response = createSuccessResponse(200, "success", "Get all position success", $position);
            return $response;
        }
        $position = Position::Where('user_id', $user_id);
        $response = createSuccessResponse(200, "success", "Get position by user id success", $position);
        return $response;
    }

    
}

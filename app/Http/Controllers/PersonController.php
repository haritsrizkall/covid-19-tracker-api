<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    //
    public function get(Request $request, $id = null){
        if ($id == null) {
            # code...
            $person = Person::all();
            $response = createSuccessResponse(200, "success", "Get all user success", $person);
            return $response;
            
        }
        $person = Person::Where('id', $id)->first();
        $response = createSuccessResponse(200, "success", "Get user by id success", $person);
        return $response;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

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

    public function getPersonByName(Request $request, $query = null){
        if ($query == null) {
            # code...
            $person = Person::all();
            $response = createSuccessResponse(200, "success", "Get all user success", $person);
            return $response;
        }
        $person = DB::table('persons')->where('name', 'LIKE', '%' . $query . '%')->get();
        $response = createSuccessResponse(200, "success", "Get user by name query success", $person);
        return $response;
    }

    public function getPersonDetail(Request $request, $user_id){
        $person = Person::with('position')
                    ->where('id', $user_id)
                    ->first();
        $response = createSuccessResponse(200, "success", "success to get person detail", $person);
        return $response;
    }
}

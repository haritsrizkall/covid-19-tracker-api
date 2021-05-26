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

    public function getSickPerson(Request $request){
        $persons = Person::with('position')
                    ->where('person_condition', 'Sakit')
                    ->get();
        $response = createSuccessResponse(200, "success", "success to get sick person", $persons);
        return $response;

    }

    public function personTracing(Request $request, $user_id){
        $personSick = Person::with('position')
                        ->where('person_condition', 'Sakit')
                        ->get();
        $person = Person::with('position')
                    ->where('id', $user_id)
                    ->first();
        $sickPositions = array();
        foreach ($personSick as $key => $valPersonSick) {
            # code...
            foreach ($valPersonSick->position as $key => $valPosition) {
                # code...
                array_push($sickPositions, $valPosition);

            }
        }
        
        foreach ($person->position as $key => $valPersonPosition) {
            foreach ($sickPositions as $key => $valSickPosition) {
               $distance = $this->_distance($valPersonPosition->latitude, $valPersonPosition->longitude, $valSickPosition->latitude, $valSickPosition->longitude);
               if ($distance <= 100) {
                   # code...
                    $valPersonPosition->distance = $distance;
                    $valPersonPosition->kondisi = 'terpapar';
                    break;
               }else{
                    $valPersonPosition->distance = $distance;
                    $valPersonPosition->kondisi = 'aman';
               }

            }
            
        }
        $response = createSuccessResponse(200, "success", "tacing success", $person);
        return $response;
    }

    private function _distance($lat1, $lon1, $lat2, $lon2) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
          return 0;
        }
        else {
          $theta = $lon1 - $lon2;
          $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
          $dist = acos($dist);
          $dist = rad2deg($dist);
          $miles = $dist * 60 * 1.1515;
      
            return ($miles * 1.609344 *1000) ;        
        }
      }
}

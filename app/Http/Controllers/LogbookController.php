<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Technician;

class LogbookController extends Controller
{
    public function index() {
        $data['technicians'] = Technician::get(["id_technician", "name"]);
        return view('logbook', $data);
    }

    public function addLogbook(Request $request) {
        $visit_date = $request->visit_date;
        $action_input = $request->action_input;
        $remark_input = $request->remark_input;
        $id_technician = $request->id_technician;

        $insert_log_maintenance = DB::table('logbook')->insert(
            [
                'visit_date' => $visit_date,
                'action' => $action_input,
                'remark' => $remark_input,
                'id_technician' => $id_technician
            ]
        );

        if ($insert_log_maintenance) {
            return response()->json($insert_log_maintenance, 200);
        } else {
            return response()->json($insert_log_maintenance, 500);
        }
    }
}

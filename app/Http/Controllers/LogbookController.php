<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Technician;

class LogbookController extends Controller
{
    public function index() {
        $data['logbook_data'] = DB::table('logbook')
                                ->join('technician', 'logbook.id_technician', '=', 'technician.id_technician')
                                ->select('logbook.id_logbook', 'logbook.visit_date', 'logbook.action', 'technician.name')
                                ->orderBy('logbook.visit_date', 'desc')
                                ->paginate(15);
        return view('logbook.logbook', $data);
    }

    public function preview(Request $request) {
        $data['logbook_data'] = DB::table('logbook')
                                ->join('technician', 'logbook.id_technician', '=', 'technician.id_technician')
                                ->select('logbook.id_logbook', 'logbook.visit_date', 'logbook.action', 'logbook.remark', 'technician.name')
                                ->where('logbook.id_logbook', $request->id_logbook)
                                ->get();

        return view('logbook.preview-logbook', $data);
    }

    public function logbookForm() {
        $data['technicians'] = Technician::get(["id_technician", "name"]);

        return view('logbook.logbook-form', $data);
    }

    public function logbookList(Request $request) {
        $data['logbook_data'] = DB::table('logbook')
                                ->join('technician', 'logbook.id_technician', '=', 'technician.id_technician')
                                ->select('logbook.id_logbook', 'logbook.visit_date', 'logbook.action', 'technician.name')
                                ->whereDate('logbook.visit_date', '>=', $request->start_date)
                                ->whereDate('logbook.visit_date', '<=', $request->end_date)
                                ->orderBy('logbook.visit_date', 'desc')
                                ->get();    
        
        return response()->json($data);
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

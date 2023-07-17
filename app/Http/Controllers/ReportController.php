<?php

namespace App\Http\Controllers;
use DB;
use App\Models\EquipmentType;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index() {
        $data['equipment_type'] = EquipmentType::get(["id_equipment_type", "equipment_type"]);
                                        
        return view('report', $data);
    }

    public function reportList(Request $request) {
        if ($request->id_equipment_type == null) {
            $data['maintenance_data'] = DB::table('log_maintenance_fire')
                                            ->join('equipment_metadata', 'log_maintenance_fire.id_equipment_metadata', '=', 'equipment_metadata.id_equipment_metadata')
                                            ->join('technician', 'log_maintenance_fire.id_technician', '=', 'technician.id_technician')
                                            ->join('equipment_type', 'equipment_metadata.id_equipment_type', '=', 'equipment_type.id_equipment_type')
                                            ->select('log_maintenance_fire.id_log_maintenance', 'log_maintenance_fire.id_equipment_metadata', 'log_maintenance_fire.maintenance_date', 'equipment_type.id_equipment_type', 'equipment_type.equipment_type', 'equipment_metadata.equipment', 'technician.name')
                                            ->whereDate('log_maintenance_fire.maintenance_date', '>=', $request->start_date)
                                            ->whereDate('log_maintenance_fire.maintenance_date', '<=', $request->end_date)
                                            ->get();
        } else {
            $data['maintenance_data'] = DB::table('log_maintenance_fire')
                                            ->join('equipment_metadata', 'log_maintenance_fire.id_equipment_metadata', '=', 'equipment_metadata.id_equipment_metadata')
                                            ->join('technician', 'log_maintenance_fire.id_technician', '=', 'technician.id_technician')
                                            ->join('equipment_type', 'equipment_metadata.id_equipment_type', '=', 'equipment_type.id_equipment_type')
                                            ->select('log_maintenance_fire.id_log_maintenance', 'log_maintenance_fire.id_equipment_metadata','log_maintenance_fire.maintenance_date', 'equipment_type.id_equipment_type', 'equipment_type.equipment_type', 'equipment_metadata.equipment', 'technician.name')
                                            ->whereDate('log_maintenance_fire.maintenance_date', '>=', $request->start_date)
                                            ->whereDate('log_maintenance_fire.maintenance_date', '<=', $request->end_date)
                                            ->where('equipment_type.id_equipment_type', $request->id_equipment_type)
                                            ->get();
            
        }
        return response()->json($data);
    }
}

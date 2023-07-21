<?php

namespace App\Http\Controllers;
use DB;
use App\Models\EquipmentType;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function indexDc() {
        $data['equipment_type'] = EquipmentType::get(["id_equipment_type", "equipment_type"]);
        $data['maintenance_data_index'] = DB::table('log_maintenance_dc')
                                            ->join('equipment_metadata', 'log_maintenance_dc.id_equipment_metadata', '=', 'equipment_metadata.id_equipment_metadata')
                                            ->join('technician', 'log_maintenance_dc.id_technician', '=', 'technician.id_technician')
                                            ->join('equipment_type', 'equipment_metadata.id_equipment_type', '=', 'equipment_type.id_equipment_type')
                                            ->select('log_maintenance_dc.id_log_maintenance', 'log_maintenance_dc.id_equipment_metadata', 'log_maintenance_dc.maintenance_date', 'equipment_type.id_equipment_type', 'equipment_type.equipment_type', 'equipment_metadata.equipment', 'technician.name')
                                            ->orderBy('log_maintenance_dc.maintenance_date', 'desc')
                                            ->paginate(15);
                                        
        return view('report.report-dc', $data);
    }

    public function reportList(Request $request) {
        if ($request->id_equipment_type == null) {
            $data['maintenance_data'] = DB::table('log_maintenance_dc')
                                            ->join('equipment_metadata', 'log_maintenance_dc.id_equipment_metadata', '=', 'equipment_metadata.id_equipment_metadata')
                                            ->join('technician', 'log_maintenance_dc.id_technician', '=', 'technician.id_technician')
                                            ->join('equipment_type', 'equipment_metadata.id_equipment_type', '=', 'equipment_type.id_equipment_type')
                                            ->select('log_maintenance_dc.id_log_maintenance', 'log_maintenance_dc.id_equipment_metadata', 'log_maintenance_dc.maintenance_date', 'equipment_type.id_equipment_type', 'equipment_type.equipment_type', 'equipment_metadata.equipment', 'technician.name')
                                            ->whereDate('log_maintenance_dc.maintenance_date', '>=', $request->start_date)
                                            ->whereDate('log_maintenance_dc.maintenance_date', '<=', $request->end_date)
                                            ->get();
        } else {
            $data['maintenance_data'] = DB::table('log_maintenance_dc')
                                            ->join('equipment_metadata', 'log_maintenance_dc.id_equipment_metadata', '=', 'equipment_metadata.id_equipment_metadata')
                                            ->join('technician', 'log_maintenance_dc.id_technician', '=', 'technician.id_technician')
                                            ->join('equipment_type', 'equipment_metadata.id_equipment_type', '=', 'equipment_type.id_equipment_type')
                                            ->select('log_maintenance_dc.id_log_maintenance', 'log_maintenance_dc.id_equipment_metadata','log_maintenance_dc.maintenance_date', 'equipment_type.id_equipment_type', 'equipment_type.equipment_type', 'equipment_metadata.equipment', 'technician.name')
                                            ->whereDate('log_maintenance_dc.maintenance_date', '>=', $request->start_date)
                                            ->whereDate('log_maintenance_dc.maintenance_date', '<=', $request->end_date)
                                            ->where('equipment_type.id_equipment_type', $request->id_equipment_type)
                                            ->get();
            
        }
        return response()->json($data);
    }

    public function previewDc(Request $request) {
        $data['equipment_form'] = DB::table('log_maintenance_dc')
                                    ->join('equipment_metadata', 'log_maintenance_dc.id_equipment_metadata', '=', 'equipment_metadata.id_equipment_metadata')
                                    ->join('technician', 'log_maintenance_dc.id_technician', '=', 'technician.id_technician')
                                    ->join('equipment_type', 'equipment_metadata.id_equipment_type', '=', 'equipment_type.id_equipment_type')
                                    ->select('log_maintenance_dc.id_log_maintenance', 'log_maintenance_dc.maintenance_date', 'log_maintenance_dc.arrival_time','log_maintenance_dc.finish_time', 'equipment_type.id_equipment_type', 'equipment_type.equipment_type', 'equipment_metadata.id_equipment_metadata', 'equipment_metadata.equipment', 'equipment_metadata.model', 'technician.id_technician', 'technician.name')
                                    ->where('log_maintenance_dc.id_log_maintenance', $request->id_log_maintenance)
                                    ->get();

        $data['maintenance_data'] = DB::table('log_data_dc')
                                    ->join('params', 'log_data_dc.id_param', '=', 'params.id_param')
                                    ->join('items', 'params.id_item', '=', 'items.id_item')
                                    ->join('equipment_metadata', 'items.id_equipment_metadata', '=', 'equipment_metadata.id_equipment_metadata')
                                    ->select('log_data_dc.*', 'items.id_item', 'items.item', 'params.id_param', 'params.param')
                                    ->where('log_data_dc.maintenance_date', $request->maintenance_date)
                                    ->where('equipment_metadata.id_equipment_metadata', $request->id_equipment_metadata)
                                    ->get();

        $id_item = [];
        $lookup = [];
        $data['item_length'] = [];

        for ($i=0; $i<count($data['maintenance_data']); $i++) {
            array_push($id_item, $data['maintenance_data'][$i]->id_item);
        }

        for ($i=0; $i<count($data['maintenance_data']); $i++) {
            if (in_array($id_item[$i], $lookup) == false) {
                array_push($lookup, $id_item[$i]);
                $counts = array_count_values($id_item);
                array_push($data['item_length'], [
                    'id_item' => $data['maintenance_data'][$i]->id_item,
                    'item' => $data['maintenance_data'][$i]->item,
                    'length' => $counts[$id_item[$i]]
                ]);
            }
        }

        return view('report.preview-dc', $data);
    }
}

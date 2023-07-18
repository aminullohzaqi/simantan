<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\EquipmentMetadata;
use App\Models\EquipmentType;
use App\Models\Item;
use App\Models\Param;
use App\Models\Technician;
use App\Models\LogDataFire;
use App\Models\LogMaintenanceFire;

class MaintenanceController extends Controller
{
    public function indexDc() {
        $data['equipment_type'] = EquipmentType::get(["id_equipment_type", "equipment_type"]);
        $data['technicians'] = Technician::get(["id_technician", "name"]);
        return view('maintenance-dc', $data);
    }

    public function fetchEquipmentMetadata(Request $request) {
        $data['equipment_metadata'] = EquipmentMetadata::where("id_equipment_type", $request->id_equipment_type)
                                ->get(["id_equipment_metadata", "equipment"]);
  
        return response()->json($data);
    }

    public function editDc(Request $request) {
        $data['equipment_form'] = DB::table('log_maintenance_fire')
                                    ->join('equipment_metadata', 'log_maintenance_fire.id_equipment_metadata', '=', 'equipment_metadata.id_equipment_metadata')
                                    ->join('technician', 'log_maintenance_fire.id_technician', '=', 'technician.id_technician')
                                    ->join('equipment_type', 'equipment_metadata.id_equipment_type', '=', 'equipment_type.id_equipment_type')
                                    ->select('log_maintenance_fire.id_log_maintenance', 'log_maintenance_fire.maintenance_date', 'equipment_type.id_equipment_type', 'equipment_type.equipment_type', 'equipment_metadata.id_equipment_metadata', 'equipment_metadata.equipment', 'technician.id_technician', 'technician.name')
                                    ->where('log_maintenance_fire.id_log_maintenance', $request->id_log_maintenance)
                                    ->get();

        $data['maintenance_data'] = DB::table('log_data_fire')
                                    ->join('params', 'log_data_fire.id_param', '=', 'params.id_param')
                                    ->join('items', 'params.id_item', '=', 'items.id_item')
                                    ->join('equipment_metadata', 'items.id_equipment_metadata', '=', 'equipment_metadata.id_equipment_metadata')
                                    ->select('log_data_fire.*', 'items.id_item', 'items.item', 'params.id_param', 'params.param')
                                    ->where('log_data_fire.maintenance_date', $request->maintenance_date)
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

        return view('edit-maintenance', $data);
        // return response()->json($data);
    }

    public function fetchItem(Request $request) {
        $data['form_item'] = Item::where("id_equipment_metadata", $request->id_equipment_metadata)
                                ->get(["id_item", "item"]);

        $data['form_param'] = [];
        $idItem = [];

        foreach ($data['form_item'] as $item) {
            array_push($idItem, $item["id_item"]);
        }
        foreach ($idItem as $item) {
            $params = Param::where("id_item", $item)->get(["id_param", "param"]);
            array_push($data['form_param'], $params); 
        }
  
        return response()->json($data);
    }

    public function fetchParam(Request $request) {
        $data['form_param'] = Param::where("id_item", $request->id_item)
                                ->get(["id_param", "param"]);
  
        return response()->json($data);
    }

    public function saveLog(Request $request) {
        $id_equipment_type = $request->id_equipment_type;
        $id_equipment_metadata = $request->id_equipment_metadata;
        $maintenance_date = $request->maintenance_date;
        $id_technician = $request->id_technician;
        $check_in = $request->check_in;
        $check_out = $request->check_out;
        $tf_passed = $request->tf_passed;
        $tf_not_passed = $request->tf_not_passed;
        $tf_chk = $request->tf_chk;
        $tf_clg = $request->tf_clg;
        $tf_rpr = $request->tf_rpr;
        $tf_rplt = $request->tf_rplt;
        $note = $request->note;

        $insert_log_maintenance = DB::table('log_maintenance_fire')->insert(
            [
                'id_equipment_metadata' => $id_equipment_metadata,
                'maintenance_date' => $maintenance_date,
                'id_technician' => $id_technician
            ]
        );

        $arrayLength = count($check_in);

        for ($x = 0; $x < $arrayLength; $x++) {
            DB::table('log_data_fire')->insert(
                [
                    'id_param' => $check_in[$x]['id'],
                    'maintenance_date' => $maintenance_date,
                    'check_in' => $check_in[$x]['value'],
                    'check_out' => $check_out[$x]['value'],
                    'tf_passed' => $tf_passed[$x]['value'],
                    'tf_not_passed' => $tf_not_passed[$x]['value'],
                    'tf_chk' => $tf_chk[$x]['value'],
                    'tf_clg' => $tf_clg[$x]['value'],
                    'tf_rpr' => $tf_rpr[$x]['value'],
                    'tf_rplt' => $tf_rplt[$x]['value'],
                    'note' => $note[$x]['value'],
                ]
            );
        }
        
        if ($insert_log_maintenance) {
            return response()->json($insert_log_maintenance, 200);
        } else {
            return response()->json($insert_log_maintenance, 500);

        }
    }

    public function editLog(Request $request) {
        $id_log_maintenance = $request->id_log_maintenance;
        $id_equipment_type = $request->id_equipment_type;
        $id_equipment_metadata = $request->id_equipment_metadata;
        $maintenance_date = $request->maintenance_date;
        $id_technician = $request->id_technician;
        $id_log_data = $request->id_log_data;
        $check_in = $request->check_in;
        $check_out = $request->check_out;
        $tf_passed = $request->tf_passed;
        $tf_not_passed = $request->tf_not_passed;
        $tf_chk = $request->tf_chk;
        $tf_clg = $request->tf_clg;
        $tf_rpr = $request->tf_rpr;
        $tf_rplt = $request->tf_rplt;
        $note = $request->note;

        $update_log_maintenance = DB::table('log_maintenance_fire')
                                    ->where('id_log_maintenance', $id_log_maintenance)
                                    ->update([
                                        'id_equipment_metadata' => $id_equipment_metadata,
                                        'maintenance_date' => $maintenance_date,
                                        'id_technician' => $id_technician
                                    ]);

        $arrayLength = count($id_log_data);

        for ($x = 0; $x < $arrayLength; $x++) {
            DB::table('log_data_fire')
                ->where('id_log_data', $id_log_data[$x])
                ->update(
                [
                    'id_param' => $check_in[$x]['id'],
                    'maintenance_date' => $maintenance_date,
                    'check_in' => $check_in[$x]['value'],
                    'check_out' => $check_out[$x]['value'],
                    'tf_passed' => $tf_passed[$x]['value'],
                    'tf_not_passed' => $tf_not_passed[$x]['value'],
                    'tf_chk' => $tf_chk[$x]['value'],
                    'tf_clg' => $tf_clg[$x]['value'],
                    'tf_rpr' => $tf_rpr[$x]['value'],
                    'tf_rplt' => $tf_rplt[$x]['value'],
                    'note' => $note[$x]['value'],
                ]);
        }
        
        if ($update_log_maintenance >= 0) {
            return response()->json($update_log_maintenance, 200);
        } else {
            return response()->json($update_log_maintenance, 500);
        }
    }
}

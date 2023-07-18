@extends('templates.default')
@extends('partial.head')

@php
    $pretitle = 'Aminulloh Zaqi';
    $title = 'Edit Maintenance DC'
@endphp

@section('content')
<div class="row row-cards">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Equipment Form</h4>
            </div>
            <div class="card-body d-flex justify-content-center">
                    <table>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="">Equipment Type</label>
                                    <div id="id-log-maintenance" class="d-none">{{$equipment_form[0]->id_log_maintenance}}</div>
                                </td>
                                <td>
                                    <select id="equipment-type-dropdown" class="form-control" required>
                                        <option disabled selected value="{{$equipment_form[0]->id_equipment_type}}">
                                            {{$equipment_form[0]->equipment_type}}
                                        </option>
                                    </select>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="">Equipment</label>
                                </td>
                                <td>
                                    <select id="equipment-dropdown" class="form-control" required>
                                        <option disabled selected value="{{$equipment_form[0]->id_equipment_metadata}}">
                                            {{$equipment_form[0]->equipment}}
                                        </option>
                                    </select>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="">Maintenance Date</label>
                                </td>
                                <td>
                                    <input id="date-input" class="form-control" type="date" value="{{$equipment_form[0]->maintenance_date}}" required>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="">Technician</label>
                                </td>
                                <td>
                                    <select id="technician-dropdown" class="form-control" required>
                                        <option disabled selected value="{{$equipment_form[0]->id_technician}}">
                                            {{$equipment_form[0]->name}}
                                        </option>
                                    </select>
                                </td>
                            </div>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Maintenance Form</h4>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <table class="table-maintenance table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2">No.</th>
                                <th rowspan="2">Description of Item</th>
                                <th colspan="2">Checking</th>
                                <th colspan="6">Test Functional</th>
                                <th rowspan="2">Note</th>
                            </tr>
                            <tr>
                                <th>IN</th>
                                <th>OUT</th>
                                <th>Passed</th>
                                <th>Not Passed</th>
                                <th>CHK</th>
                                <th>CLG</th>
                                <th>RPR</th>
                                <th>RPLT</th>
                            </tr>
                        </thead>
                        <form action="" id="form-data">
                        <tbody id="form-maintenance">
                            @foreach($item_length as $item)
                            <tr>
                                <td rowspan="{{($item['length'] + 1)}}">{{($loop->index + 1)}}</td>
                                <td colspan="10">{{$item['item']}}</td>
                            </tr>
                                @foreach($maintenance_data as $data)
                                    @if($data->id_item == $item['id_item'])
                                    <tr> 
                                        <td>
                                            <div>{{$data->param}}</div>
                                            <input type="hidden" class="form-control form-control-sm id-log-data" value="{{$data->id_log_data}}"> 
                                        </td> 
                                        <td>
                                            <input type="number" class="form-control form-control-sm check-in-val" value="{{$data->check_in}}"> 
                                            <input type="hidden" class="form-control form-control-sm check-in-id" value="{{$data->id_param}}"> 
                                        </td> 
                                        <td>
                                            <input type="number" class="form-control form-control-sm check-out-val" value="{{$data->check_out}}"> 
                                            <input type="hidden" class="form-control form-control-sm check-out-id" value="{{$data->id_param}}"> 
                                        </td> 
                                        <td> 
                                            @if($data->tf_passed == 1)
                                            <input class="form-check-input tf-passed-val" type="checkbox" value="{{$data->tf_passed}}" checked>
                                            @else 
                                            <input class="form-check-input tf-passed-val" type="checkbox" value="{{$data->tf_passed}}"> 
                                            @endif
                                            <input type="hidden" class="form-control form-control-sm tf-passed-id" value="{{$data->id_param}}">
                                        </td> 
                                        <td> 
                                            @if($data->tf_not_passed == 1)
                                            <input class="form-check-input tf-not-passed-val" type="checkbox" value="{{$data->tf_not_passed}}" checked>
                                            @else 
                                            <input class="form-check-input tf-not-passed-val" type="checkbox" value="{{$data->tf_not_passed}}">
                                            @endif
                                            <input type="hidden" class="form-control form-control-sm tf-not-passed-id" value="{{$data->id_param}}"> 
                                        </td> 
                                        <td> 
                                            @if($data->tf_chk == 1)
                                            <input class="form-check-input tf-chk-val" type="checkbox" value="{{$data->tf_chk}}" checked>
                                            @else 
                                            <input class="form-check-input tf-chk-val" type="checkbox" value="{{$data->tf_chk}}"> 
                                            @endif
                                            <input type="hidden" class="form-control form-control-sm tf-chk-id" value="{{$data->id_param}}"> 
                                        </td> 
                                        <td> 
                                            @if($data->tf_clg == 1)
                                            <input class="form-check-input tf-clg-val" type="checkbox" value="{{$data->tf_clg}}" checked>
                                            @else 
                                            <input class="form-check-input tf-clg-val" type="checkbox" value="{{$data->tf_clg}}"> 
                                            @endif
                                            <input type="hidden" class="form-control form-control-sm tf-clg-id" value="{{$data->id_param}}">
                                        </td> 
                                        <td> 
                                            @if($data->tf_rpr == 1)
                                            <input class="form-check-input tf-rpr-val" type="checkbox" value="{{$data->tf_rpr}}" checked>
                                            @else 
                                            <input class="form-check-input tf-rpr-val" type="checkbox" value="{{$data->tf_rpr}}"> 
                                            @endif
                                            <input type="hidden" class="form-control form-control-sm tf-rpr-id" value="{{$data->id_param}}">
                                        </td> 
                                        <td> 
                                            @if($data->tf_rplt == 1)
                                            <input class="form-check-input tf-rplt-val" type="checkbox" value="{{$data->tf_rplt}}" checked>
                                            @else 
                                            <input class="form-check-input tf-rplt-val" type="checkbox" value="{{$data->tf_rplt}}"> 
                                            @endif
                                            <input type="hidden" class="form-control form-control-sm tf-rplt-id" value="{{$data->id_param}}">
                                        </td> 
                                        <td> 
                                            <textarea class="form-control form-control-sm note-val" rows="1">{{$data->note}}</textarea> 
                                            <input type="hidden" class="form-control form-control-sm note-id" value="{{$data->id_param}}">
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                        </form>
                    </table>
                </div>
            <div class="card-body d-flex justify-content-end btn-section">
                <button class="btn btn-success" id="btn-save">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M14 3v4a1 1 0 0 0 1 1h4"></path><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path><path d="M9 15l2 2l4 -4"></path></svg>
                    </span>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>         
@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#btn-save').on('click', function () {
            let idLogMaintenance = $('#id-log-maintenance').text()
            let idType = $('#equipment-type-dropdown').find(":selected").val()
            let idMetadata = $('#equipment-dropdown').find(":selected").val()
            let dateInput = $('#date-input').val()
            let idTechnician = $('#technician-dropdown').find(":selected").val()
            let idLogData = []
            let checkInVal = []
            let checkOutVal = []
            let tfPassedVal = []
            let tfNotPassedVal = []
            let tfChkVal = []
            let tfClgVal = []
            let tfRprVal = []
            let tfRpltVal = []
            let noteVal = []
            
            function storeToArrayId (classnameVal, arrayname) {
                let $value = $(classnameVal);
    
                $.each($value, function(i, item) {
                    arrayname.push($value[i].value)
                });
            }

            function storeToArray (classnameVal, classnameId, arrayname) {
                let $value = $(classnameVal);
                let $id = $(classnameId);
    
                $.each($id, function(i, item) {
                    arrayname.push({
                        id: $id[i].value,
                        value: $value[i].value
                    })
                });
            }

            function storeToArrayCheck (classnameVal, classnameId, arrayname) {
                let $value = document.getElementsByClassName(classnameVal);
                let $id = $(classnameId);
                let checkedValue = null
    
                $.each($id, function(i, item) {
                    if ($value[i].checked) {
                        checkedValue = '1'
                    } else {
                        checkedValue = '0'
                    }
                    arrayname.push({
                        id: $id[i].value,
                        value: checkedValue
                    })
                });
            }

            storeToArrayId(".id-log-data", idLogData)
            storeToArray(".check-in-val", ".check-in-id", checkInVal)
            storeToArray(".check-out-val", ".check-out-id", checkOutVal)
            storeToArrayCheck("tf-passed-val", ".tf-passed-id", tfPassedVal)
            storeToArrayCheck("tf-not-passed-val", ".tf-not-passed-id", tfNotPassedVal)
            storeToArrayCheck("tf-chk-val", ".tf-chk-id", tfChkVal)
            storeToArrayCheck("tf-clg-val", ".tf-clg-id", tfClgVal)
            storeToArrayCheck("tf-rpr-val", ".tf-rpr-id", tfRprVal)
            storeToArrayCheck("tf-rplt-val", ".tf-rplt-id", tfRpltVal)
            storeToArray(".note-val", ".note-id", noteVal)

            console.log(tfPassedVal)

            $.ajax({
                url: "{{url('api/edit-log-maintenance')}}",
                type: "POST",
                data: {
                    id_log_maintenance: idLogMaintenance,
                    id_equipment_type: idType,
                    id_equipment_metadata: idMetadata,
                    maintenance_date: dateInput,
                    id_technician: idTechnician,
                    id_log_data: idLogData,
                    check_in: checkInVal,
                    check_out: checkOutVal,
                    tf_passed: tfPassedVal,
                    tf_not_passed: tfNotPassedVal,
                    tf_chk: tfChkVal,
                    tf_clg: tfClgVal,
                    tf_rpr: tfRprVal,
                    tf_rplt: tfRpltVal,
                    note: noteVal,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result, textStatus, xhr) {
                    if (xhr.status == 200) {
                        swal({
                            title: "Success",
                            text: "Your Data Has Been Saved",
                            icon: "success",
                        }).then(function() {
                            window.location = "{{url('maintenance-dc')}}";
                        });
                    }
                }
            })
        })
    })
</script>
@endsection

@section('style')
<style>
    td {
        padding: 0.5em 1em;
    }
    .table-maintenance thead th {
        padding: 0 1em;
        text-align: center;
        vertical-align: middle;
    }
    .table-maintenance tbody td {
        padding: 0.5em;
        text-align: left;
        font-size: 13px;
        vertical-align: top;
    }
    .card {
        margin-bottom: 2em;
    }
</style>
@endsection
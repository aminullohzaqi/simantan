@extends('templates.default')
@extends('partial.head')

@php
    $pretitle = 'Aminulloh Zaqi';
    $title = 'Maintenance Data Center'
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
                                </td>
                                <td>
                                    <select id="equipment-type-dropdown" class="form-control" required>
                                        <option disabled selected value></option>
                                        @foreach ($equipment_type as $data)
                                        <option value="{{$data->id_equipment_type}}">
                                            {{$data->equipment_type}}
                                        </option>
                                        @endforeach
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
                                        <option disabled selected value></option>
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
                                    <input id="date-input" class="form-control" type="date" required>
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
                                        <option disabled selected value></option>
                                        @foreach ($technicians as $data)
                                        <option value="{{$data->id_technician}}">
                                            {{$data->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                            </div>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="card-body d-flex justify-content-center">
                <button id="btn-process" class="btn btn-success">Process</button>
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
        $('#equipment-type-dropdown').on('change', function () {
            let idType = this.value;
            $("#equipment-dropdown").html('')
            $.ajax({
                url: "{{url('api/equipment-metadata')}}",
                type: "POST",
                data: {
                    id_equipment_type: idType,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $.each(result.equipment_metadata, function (key, value) {
                        $("#equipment-dropdown").append('<option value="' + value.id_equipment_metadata + '">' + value.equipment + '</option>')
                    })
                }
            })
        })
    })

    $(document).ready(function () {
        $('#btn-process').on('click', function () {
            let idType = $('#equipment-type-dropdown').find(":selected").val()
            let idMetadata = $('#equipment-dropdown').find(":selected").val()
            let dateInput = $('#date-input').val()
            let idTechnician = $('#technician-dropdown').find(":selected").val()
            if (idType !== "" && idMetadata !== "" && dateInput !== "" && idTechnician !== "") {
                $.ajax({
                    url: "{{url('api/valid-form')}}",
                    type: "POST",
                    data: {
                        id_equipment_metadata: idMetadata,
                        maintenance_date: dateInput,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        if (result.length > 0) {
                            swal({
                                title: "Maintenance Has Been Input",
                                text: "Equipment has been input on selected date. Please edit if any update",
                                icon: "warning",
                            }).then(function() {
                                window.location = "{{url('report-dc')}}";
                            });
                        } 
                    }
                })

                $.ajax({
                    url: "{{url('api/item-form')}}",
                    type: "POST",
                    data: {
                        id_equipment_metadata: idMetadata,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        let lengthFormParams = result.form_param.length
                        let lengthArray = []
                        for (x=0; x<lengthFormParams; x++) {
                            lengthArray.push(result.form_param[x].length)
                        }
                        let i = 0
                        let tabl = ''
                        result.form_item.forEach(item => {
                            tabl += `<tr>
                                    <td rowspan="${lengthArray[i] + 1}">${i+1}</td>
                                    <td colspan="10">${item.item}</td>
                                    </tr>`
                            result.form_param[i].forEach(param => {
                                    tabl +=
                                        `<tr> 
                                            <td>  ${param.param}  </td> 
                                            <td> 
                                                <input type="number" class="form-control form-control-sm check-in-val"> 
                                                <input type="hidden" class="form-control form-control-sm check-in-id" value="${param.id_param}"> 
                                            </td> 
                                            <td> 
                                                <input type="number" class="form-control form-control-sm check-out-val"> 
                                                <input type="hidden" class="form-control form-control-sm check-out-id" value="${param.id_param}"> 
                                            </td> 
                                            <td> 
                                                <input class="form-check-input tf-passed-val" type="checkbox" value="1">
                                                <input type="hidden" class="form-control form-control-sm tf-passed-id" value="${param.id_param}">
                                            </td> 
                                            <td> 
                                                <input class="form-check-input tf-not-passed-val" type="checkbox" value="1">
                                                <input type="hidden" class="form-control form-control-sm tf-not-passed-id" value="${param.id_param}"> 
                                            </td> 
                                            <td> 
                                                <input class="form-check-input tf-chk-val" type="checkbox" value="1">
                                                <input type="hidden" class="form-control form-control-sm tf-chk-id" value="${param.id_param}"> 
                                            </td> 
                                            <td> 
                                                <input class="form-check-input tf-clg-val" type="checkbox" value="1"> 
                                                <input type="hidden" class="form-control form-control-sm tf-clg-id" value="${param.id_param}">
                                            </td> 
                                            <td> 
                                                <input class="form-check-input tf-rpr-val" type="checkbox" value="1"> 
                                                <input type="hidden" class="form-control form-control-sm tf-rpr-id" value="${param.id_param}">
                                            </td> 
                                            <td> 
                                                <input class="form-check-input tf-rplt-val" type="checkbox" value="1"> 
                                                <input type="hidden" class="form-control form-control-sm tf-rplt-id" value="${param.id_param}">
                                            </td> 
                                            <td> 
                                                <textarea class="form-control form-control-sm note-val" rows="1"></textarea> 
                                                <input type="hidden" class="form-control form-control-sm note-id" value="${param.id_param}">
                                            </td>
                                        </tr>`
                                    
                            })
                            i++
                        })
                        tabl += 
                            `<tr>
                                <td colspan="3">
                                    <div class="d-flex justify-content-start">
                                        <label class="">ARRIVAL TIME </label>
                                        <input id="arrival-time" type="datetime-local" class="form-control form-control-sm">
                                    </div>
                                </td>
                                <td colspan="3">
                                    <div class="d-flex justify-content-start">
                                        <label class="">FINISH TIME </label>
                                        <input id="finish-time" type="datetime-local" class="form-control form-control-sm">
                                    </div>
                                </td>
                            </tr>`
                        $("#form-maintenance").append(tabl)
                    }
                })
            } else {
                swal("Input Needed", "Please Input The Form", "warning")
            }
        })
    })

    $(document).ready(function () {
        $('#btn-save').on('click', function () {
            let idType = $('#equipment-type-dropdown').find(":selected").val()
            let idMetadata = $('#equipment-dropdown').find(":selected").val()
            let dateInput = $('#date-input').val()
            let arrivalTime = $('#arrival-time').val()
            let finishTime = $('#finish-time').val()
            let idTechnician = $('#technician-dropdown').find(":selected").val()
            let checkInVal = []
            let checkOutVal = []
            let tfPassedVal = []
            let tfNotPassedVal = []
            let tfChkVal = []
            let tfClgVal = []
            let tfRprVal = []
            let tfRpltVal = []
            let noteVal = []
            
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
                        checkedValue = $value[i].value
                    } else {
                        checkedValue = '0'
                    }
                    arrayname.push({
                        id: $id[i].value,
                        value: checkedValue
                    })
                });
            }

            storeToArray(".check-in-val", ".check-in-id", checkInVal)
            storeToArray(".check-out-val", ".check-out-id", checkOutVal)
            storeToArrayCheck("tf-passed-val", ".tf-passed-id", tfPassedVal)
            storeToArrayCheck("tf-not-passed-val", ".tf-not-passed-id", tfNotPassedVal)
            storeToArrayCheck("tf-chk-val", ".tf-chk-id", tfChkVal)
            storeToArrayCheck("tf-clg-val", ".tf-clg-id", tfClgVal)
            storeToArrayCheck("tf-rpr-val", ".tf-rpr-id", tfRprVal)
            storeToArrayCheck("tf-rplt-val", ".tf-rplt-id", tfRpltVal)
            storeToArray(".note-val", ".note-id", noteVal)

            $.ajax({
                url: "{{url('api/save-log-maintenance')}}",
                type: "POST",
                data: {
                    id_equipment_type: idType,
                    id_equipment_metadata: idMetadata,
                    maintenance_date: dateInput,
                    arrival_time: arrivalTime,
                    finish_time: finishTime,
                    id_technician: idTechnician,
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
                            window.location = "{{url('report-dc')}}";
                        });
                    } else {
                        swal({
                            title: "Failed",
                            text: "There is Something Wrong",
                            icon: "error",
                        })
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
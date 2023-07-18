@extends('templates.default')
@extends('partial.head')

@php
    $pretitle = 'Aminulloh Zaqi';
    $title = 'Report Maintenance Data Center'
@endphp

@section('content')
<div class="row row-cards">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Filter Report</h4>
            </div>
            <div class="card-body d-flex justify-content-start">
                <div class="form-group d-flex justify-content-around">
                    <span><label for="">Start Date</label></span>
                    <span><input id="start-date" class="form-control form-control-sm" type="date" name=""></span>
                </div>
                <div class="form-group d-flex justify-content-around">
                    <span><label for="">End Date</label></span>
                    <span><input id="end-date" class="form-control form-control-sm" type="date" name=""></span>
                </div>
                <div class="form-group d-flex justify-content-around">
                    <span><label for="">Equipment Type</label></span>
                    <span>
                        <select id="equipment-type-dropdown" class="form-control form-control-sm" required>
                            <option disabled selected value></option>
                            @foreach ($equipment_type as $data)
                            <option value="{{$data->id_equipment_type}}">
                                {{$data->equipment_type}}
                            </option>
                            @endforeach
                        </select>
                    </span>
                </div>
                <div class="form-group d-flex justify-content-around">
                    <button id="btn-process" class="btn btn-success btn-sm">Process</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Reports</h4>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Maintenance Date</th>
                            <th>Equipment Type</th>
                            <th>Equipment</th>
                            <th>Technician</th>
                        </tr>
                    </thead>
                    <tbody id="report-list">
                        @foreach($maintenance_data_index as $data)
                            <tr onclick="toDetailPage('{{$data->maintenance_date}}', {{$data->id_log_maintenance}}, {{$data->id_equipment_metadata}})">
                                <td>{{$data->maintenance_date}}</td>
                                <td>{{$data->equipment_type}}</td>
                                <td>{{$data->equipment}}</td>
                                <td>{{$data->name}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-body">
                {{$maintenance_data_index->links()}}
            </div>
        </div>
    </div>
</div>  
@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#btn-process').on('click', function () {
            let startDate = $('#start-date').val()
            let endDate = $('#end-date').val()
            let idType = $('#equipment-type-dropdown').find(":selected").val()
            if (startDate !== "" && endDate !== "") {
                $.ajax({
                    url: "{{url('api/report-list')}}",
                    type: "POST",
                    data: {
                        id_equipment_type: idType,
                        start_date: startDate,
                        end_date: endDate,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result)
                        $("#report-list").html('')
                        tabl = ""
                        result.maintenance_data.forEach(report => {
                            tabl += `<tr onclick="toDetailPage('${String(report.maintenance_date)}', ${report.id_log_maintenance}, ${report.id_equipment_metadata})">
                                        <td>${report.maintenance_date}</td>
                                        <td>${report.equipment_type}</td>
                                        <td>${report.equipment}</td>
                                        <td>${report.name}</td>
                                    </tr>`
                        })
                        $("#report-list").append(tabl)
                    }
                })
            } else {
                swal("Date Input Needed", "Please Input Range of Date", "warning");
            }
        })
    })

    function toDetailPage (maintenance_date, id_log, id_equipment_metadata) {
        window.location.href = "{{route('maintenance-dc-edit')}}?id_log_maintenance=" + id_log + '&id_equipment_metadata=' + id_equipment_metadata + '&maintenance_date=' + maintenance_date;
    }
</script>
@endsection

@section('style')
<style>
    .form-group {
        margin-right: 1.5em;
    }
    label {
        margin-right: 0.5em
    }
    .card {
        margin-bottom: 2em;
    }
    table {
        text-align: center;
    }
    tbody {
        font-size: 13px;
    }
</style>
@endsection
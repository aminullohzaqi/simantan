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
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">Preview Report</h4>
                <button class="btn btn-success" id="btn-edit" onclick="toEditPage('{{$equipment_form[0]->maintenance_date}}', {{$equipment_form[0]->id_log_maintenance}}, {{$equipment_form[0]->id_equipment_metadata}})">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M14 3v4a1 1 0 0 0 1 1h4"></path><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path><path d="M9 15l2 2l4 -4"></path></svg>
                    </span>
                    Edit
                </button>
            </div>
            <div class="card-body d-flex justify-content-center">
                <table class="table-maintenance table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="7">SERVICE REPORT</th>
                            <th colspan="4">DATE: {{$equipment_form[0]->maintenance_date}}</th>
                        </tr>
                        <tr>
                            <th colspan="2">CUSTOMER NAME</th>
                            <th>:</th>
                            <th colspan="4">BMKG</th>
                            <th colspan="4">JOB DESCRIPTION</th>
                        </tr>
                        <tr>
                            <th colspan="2">ADDRESS</th>
                            <th>:</th>
                            <th colspan="4">Jl. Angkasa I No.2, Kemayoran, Jakarta Pusat</th>
                            <th></th>
                            <th colspan="3">CHECKING & SURVEY</th>
                        </tr>
                        <tr>
                            <th colspan="2">EQUIPMENT</th>
                            <th>:</th>
                            <th colspan="4">{{$equipment_form[0]->equipment}}</th>
                            <th></th>
                            <th colspan="3">ON CALL SERVICE</th>
                        </tr>
                        <tr>
                            <th colspan="2">MODEL/TYPE</th>
                            <th>:</th>
                            <th colspan="4">{{$equipment_form[0]->model}}</th>
                            <th>✓</th>
                            <th colspan="3">MAINTENANCE SERVICE</th>
                        </tr>
                        <tr>
                            <th colspan="2">ROOM AREA</th>
                            <th>:</th>
                            <th colspan="4"></th>
                            <th></th>
                            <th colspan="3">TESTING & COMMISIONING</th>
                        </tr>
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
                                    </td> 
                                    <td>
                                        <div>{{$data->check_in}}</div>
                                    </td> 
                                    <td>
                                        <div>{{$data->check_out}}</div>
                                    </td> 
                                    <td> 
                                        @if($data->tf_passed == 1)
                                        <div>✓</div>
                                        @else 
                                        <div></div>
                                        @endif
                                    </td> 
                                    <td> 
                                        @if($data->tf_not_passed == 1)
                                        <div>✓</div>
                                        @else 
                                        <div></div>
                                        @endif
                                    </td> 
                                    <td> 
                                        @if($data->tf_chk == 1)
                                        <div>✓</div>
                                        @else 
                                        <div></div>
                                        @endif
                                    </td> 
                                    <td> 
                                        @if($data->tf_clg == 1)
                                        <div>✓</div>
                                        @else 
                                        <div></div>
                                        @endif
                                    </td> 
                                    <td> 
                                        @if($data->tf_rpr == 1)
                                        <div>✓</div>
                                        @else 
                                        <div></div>
                                        @endif
                                    </td> 
                                    <td> 
                                        @if($data->tf_rplt == 1)
                                        <div>✓</div>
                                        @else 
                                        <div></div>
                                        @endif
                                    </td> 
                                    <td> 
                                        <div>{{$data->note}}</div>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                    </form>
                </table>
            </div>
        </div>
    </div>
</div> 
@endsection

@section('script')
<script>
    function toEditPage (maintenance_date, id_log, id_equipment_metadata) {
        window.location.href = "{{route('maintenance-dc-edit')}}?id_log_maintenance=" + id_log + '&id_equipment_metadata=' + id_equipment_metadata + '&maintenance_date=' + maintenance_date;
    }
</script>
@endsection

@section('style')
<style>
    th {
        font-size: 13px;
    }
    td {
        padding: 0.5em 1em;
    }
    .table-maintenance thead th {
        padding: 0 1em;
        text-align: left;
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
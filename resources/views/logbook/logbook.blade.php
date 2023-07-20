@extends('templates.default')
@extends('partial.head')

@php
    $pretitle = 'Aminulloh Zaqi';
    $title = 'Logbook'
@endphp

@section('content')
<div class="row row-cards">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Filter Date</h4>
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
                    <button id="btn-process" class="btn btn-success btn-sm">Process</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">Logbook</h4>
                <button class="btn btn-success" id="btn-add" onclick="toAddPage()">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                            <path d="M12 11l0 6"></path>
                            <path d="M9 14l6 0"></path>
                        </svg>
                    </span>
                    Add Logbook
                </button>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Maintenance Date</th>
                            <th>Action</th>
                            <th>Technician</th>
                        </tr>
                    </thead>
                    <tbody id="logbook-list">
                        @foreach($logbook_data as $data)
                            <tr onclick="toDetailPage('{{$data->visit_date}}', {{$data->id_logbook}})">
                                <td>{{$data->visit_date}}</td>
                                <td>{{$data->action}}</td>
                                <td>{{$data->name}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-body">
                {{$logbook_data->links()}}
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
            if (startDate !== "" && endDate !== "") {
                $.ajax({
                    url: "{{url('api/logbook-list')}}",
                    type: "POST",
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $("#logbook-list").html('')
                        tabl = ""
                        result.logbook_data.forEach(logbook => {
                            tabl += `<tr onclick="toDetailPage('${String(logbook.visit_date)}', ${logbook.id_logbook})">
                                        <td>${logbook.visit_date}</td>
                                        <td>${logbook.action}</td>
                                        <td>${logbook.name}</td>
                                    </tr>`
                        })
                        $("#logbook-list").append(tabl)
                    }
                })
            } else {
                swal("Date Input Needed", "Please Input Range of Date", "warning")
            }
        })
    })

    function toAddPage () {
        window.location.href = "{{route('add-logbook')}}"
    }

    function toDetailPage (visit_date, id_logbook) {
        window.location.href = "{{route('preview-logbook')}}?id_logbook=" + id_logbook + '&visit_date=' + visit_date
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
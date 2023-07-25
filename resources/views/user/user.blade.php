@extends('templates.default')
@extends('partial.head')

@php
    $pretitle = $users->name;
    $title = 'Users'
@endphp

@section('content')
<div class="row row-cards">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Filter User</h4>
            </div>
            <div class="card-body d-flex justify-content-start">
                <div class="form-group d-flex justify-content-around">
                    <span><label for="">Name</label></span>
                    <span><input id="name" class="form-control form-control-sm" type="text" name=""></span>
                </div>
                <div class="form-group d-flex justify-content-around">
                    <button id="btn-process" class="btn btn-success btn-sm">Process</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">Users</h4>
                <button class="btn btn-success" id="btn-add" onclick="toAddPage()">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                            <path d="M16 19h6"></path>
                            <path d="M19 16v6"></path>
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                        </svg>
                    </span>
                    Add Users
                </button>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Level</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="user-list">
                        @foreach($users_data as $data)
                            <tr>
                                <td>{{$data->name}}</td>
                                <td>{{$data->email}}</td>
                                @if($data->role == 1)
                                    <td>Administrator</td>
                                @else
                                    <td>Technician</td>
                                @endif
                                <td>{{$data->level}}</td>
                                <td>{{$data->created_at}}</td>
                                <td>{{$data->updated_at}}</td>
                                <td>
                                    <span><button class="btn btn-warning" onclick="toDetailPage({{$data->id}})">Edit</button></span>
                                    <span><button class="btn btn-primary" onclick="toChangePassword({{$data->id}})">Change Password</button></span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-body">
                {{$users_data->links()}}
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
            let name = $('#name').val()
            if (name !== "") {
                $.ajax({
                    url: "{{url('api/user-list')}}",
                    type: "POST",
                    data: {
                        name: name,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $("#user-list").html('')
                        tabl = ""
                        role = ""
                        result.users_data.forEach(user => {
                            if (user.role == 1) {
                                role = "Administrator"
                            } else {
                                role = "Technician"
                            }
                            tabl += `<tr onclick="toDetailPage(${user.id}">
                                        <td>${user.name}</td>
                                        <td>${user.email}</td>
                                        <td>${role}</td>
                                        <td>${user.level}</td>
                                        <td>${user.created_at}</td>
                                        <td>${user.updated_at}</td>
                                        <td>
                                            <span><button class="btn btn-warning" onclick="toDetailPage(${user.id})">Edit</button></span>
                                            <span><button class="btn btn-primary" onclick="toChangePassword(${user.id})">Change Password</button></span>
                                        </td>
                                    </tr>`
                        })
                        $("#user-list").append(tabl)
                    }
                })
            } else {
                swal("Input Needed", "Please Input Name Field", "warning")
            }
        })
    })

    function toAddPage () {
        window.location.href = "{{route('add-user')}}"
    }

    function toDetailPage (id_user) {
        window.location.href = "{{route('edit-user')}}?id_user=" + id_user
    }

    function toChangePassword (id_user) {
        window.location.href = "{{route('change-password')}}?id_user=" + id_user
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
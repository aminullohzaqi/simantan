@extends('templates.default')
@extends('partial.head')

@php
    $pretitle = $users->name;
    $title = 'Edit User'
@endphp

@section('content')
<div class="row row-cards">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Form</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <form>
                        <table>
                            <tr>
                                <div class="form-group">
                                    <td>
                                        Name
                                    </td>
                                    <td>
                                        <input type="text" id="name" class="form-control" value="{{$user_data[0]->name}}">
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td>
                                        Email
                                    </td>
                                    <td>
                                        <input type="text" id="email" class="form-control" value="{{$user_data[0]->email}}">
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td>
                                        Role
                                    </td>
                                    <td>
                                        <select id="role-dropdown" class="form-control" required>
                                            <option disabled selected value="{{$user_data[0]->role}}">
                                                @if($user_data[0]->role == 0)
                                                    Technician
                                                @else
                                                    Administrator
                                                @endif
                                            </option>
                                            <option value="0">Technician</option>
                                            <option value="1">Administrator</option>
                                        </select>
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td>
                                        Level
                                    </td>
                                    <td>
                                        <select id="level-dropdown" class="form-control" required>
                                            <option disabled selected value="{{$user_data[0]->level}}">
                                                @if($user_data[0]->level == 1)
                                                    L1
                                                @elseif($user_data[0]->level == 2)
                                                    L2
                                                @elseif($user_data[0]->level == 3)
                                                    L3
                                                @endif
                                            </option>
                                            <option value="1">L1</option>
                                            <option value="2">L2</option>
                                            <option value="3">L3</option>
                                        </select>
                                    </td>
                                </div>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="card-body d-flex justify-content-center btn-section">
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
</div>
@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#btn-save').on('click', function () {
            let id = {{$user_data[0]->id}}
            let name = $('#name').val()
            let email = $('#email').val()
            let role = $('#role-dropdown').find(":selected").val()
            let level = $('#level-dropdown').find(":selected").val()

            $.ajax({
                url: "{{url('api/edit-user')}}",
                type: "POST",
                data: {
                    id: id,
                    name: name,
                    email: email,
                    role: role,
                    level: level,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result, textStatus, xhr) {
                    if (xhr.status == 200) {
                        swal({
                            title: "Success",
                            text: "User Has Been Edited",
                            icon: "success",
                        }).then(function() {
                            window.location = "{{url('users')}}";
                        });
                    } 
                },
                error: function (xhr, status, error) {
                    var err = JSON.parse(xhr.responseText)
                    swal({
                        title: "Failed",
                        text: err.message,
                        icon: "error",
                    })
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
        vertical-align: middle;
    }
    .card {
        margin-bottom: 2em;
    }
</style>
@endsection
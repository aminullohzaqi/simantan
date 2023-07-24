@extends('templates.default')
@extends('partial.head')

@php
    $pretitle = $users->name;
    $title = 'User'
@endphp

@section('content')
<div class="row row-cards">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">User Form</h4>
            </div>
            <div class="card-body d-flex justify-content-center">
                <form>
                    <table>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="">Name</label>
                                </td>
                                <td>
                                    <input class="form-control" type="text" id="name" required>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="">Email</label>
                                </td>
                                <td>
                                    <input class="form-control" type="email" id="email" required>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="">Role</label>
                                </td>
                                <td>
                                    <select class="form-select" id="role">
                                        <option value="0" selected>Technician</option>
                                        <option value="1">Administrator</option>
                                    </select>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="">Level</label>
                                </td>
                                <td>
                                    <select class="form-select" id="level">
                                        <option value="1" selected>L1</option>
                                        <option value="2">L2</option>
                                        <option value="3">L3</option>
                                    </select>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="">Password</label>
                                </td>
                                <td>
                                    <input class="form-control" type="password" id="password" required>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="">Retype Password</label>
                                </td>
                                <td>
                                    <input class="form-control" type="password" id="retype-password" required>
                                </td>
                            </div>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="card-body d-flex justify-content-end btn-section">
                <button class="btn btn-success" id="btn-save">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M14 3v4a1 1 0 0 0 1 1h4"></path><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path><path d="M9 15l2 2l4 -4"></path></svg>
                    </span>
                    Add
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
            let name = $('#name').val()
            let email = $('#email').val()
            let role = $('#role').val()
            let level = $('#level').val()
            let password = $('#password').val()
            let retypePassword = $('#retype-password').val()

            if (name !== "" && email !== "" && password !== "" && retypePassword !== "") {
                if (password === retypePassword) {
                    $.ajax({
                        url: "{{url('api/add-user')}}",
                        type: "POST",
                        data: {
                            name: name,
                            email: email,
                            role: role,
                            level: level,
                            password: password,
                            _token: '{{csrf_token()}}'
                        },
                        dataType: 'json',
                        success: function (result, textStatus, xhr) {
                            if (xhr.status == 200) {
                                swal({
                                    title: "Success",
                                    text: "New User Has Been Saved",
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
                } else {
                    swal("Password Not Match", "Password not match with retype password", "warning")
                }
            } else {
                swal("Input Needed", "Please Input The Form", "warning")
            }

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
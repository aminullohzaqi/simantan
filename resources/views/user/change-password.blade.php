@extends('templates.default')
@extends('partial.head')

@php
    $pretitle = $users->name;
    $title = 'Change User Password'
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
                                        Type New Password
                                    </td>
                                    <td>
                                        <input type="password" id="password" class="form-control">
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td>
                                        Retype New Password
                                    </td>
                                    <td>
                                        <input type="password" id="retype-password" class="form-control">
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
            let id = {{$id}}
            let password = $('#password').val()
            let retypePassword = $('#retype-password').val()

            if (password !== "" && retypePassword !== "") {
                if (password === retypePassword) {
                    $.ajax({
                        url: "{{url('api/change-password')}}",
                        type: "POST",
                        data: {
                            id: id,
                            password: password,
                            retype_password: retypePassword,
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
                } else {
                    swal({
                        title: "Warning",
                        text: "Password not match with retype password",
                        icon: "warning",
                    })
                }
            } else {
                swal({
                    title: "Warning",
                    text: "Please input all forms",
                    icon: "warning",
                })
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
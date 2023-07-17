@extends('templates.default')
@extends('partial.head')

@php
    $pretitle = 'Aminulloh Zaqi';
    $title = 'Log Book'
@endphp

@section('content')
<div class="row row-cards">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Log Book Form</h4>
            </div>
            <div class="card-body d-flex ">
                <form>
                    <table>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="">Visit Date</label>
                                </td>
                                <td>
                                    <input class="form-control" type="date" name="" id="">
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="">Action</label>
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="" id="">
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="">Remark</label>
                                </td>
                                <td>
                                    <textarea class="form-control" name="" id="" cols="100" rows="5"></textarea>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="">Technician</label>
                                </td>
                                <td>
                                    <select class="form-control" id="">
                                        <option disabled selected value></option>
                                        <option>Husin Sanusi</option>
                                        <option>Asmadi Djasman</option>
                                        <option>Aminulloh Zaqi</option>
                                        <option>Khoeri Zuhdi</option>
                                        <option>Aby Rengga</option>
                                        <option>Rahmat Hidayat</option>
                                    </select>
                                </td>
                            </div>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="card-body d-flex justify-content-end btn-section">
                <button class="btn btn-success" id="btn-save" onclick="save()">
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
<script>
    function save() {
        // const saveDocument = document.getElementById("btn-save")
        swal("Success", "Your data has been saved", "success");
    }
</script>
@endsection

@section('style')
<style>
    td {
        padding: 0.5em 1em;
        vertical-align: top;
    }
    .card {
        margin-bottom: 2em;
    }
</style>
@endsection
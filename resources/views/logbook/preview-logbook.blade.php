@extends('templates.default')
@extends('partial.head')

@php
    $pretitle = $users->name;
    $title = 'Log Book'
@endphp

@section('content')
<div class="row row-cards">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Preview</h4>
            </div>
            <div class="card-body d-flex ">
                <form>
                    <table>
                        <tr>
                            <div class="form-group">
                                <td>
                                    Visit Date
                                </td>
                                <td>
                                    {{$logbook_data[0]->visit_date}}
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    Action
                                </td>
                                <td>
                                    {{$logbook_data[0]->action}}
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    Remark
                                </td>
                                <td>
                                    {{$logbook_data[0]->remark}}
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    Technician
                                </td>
                                <td>
                                    {{$logbook_data[0]->name}}
                                </td>
                            </div>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
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
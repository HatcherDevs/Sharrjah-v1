@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h5>Inquiry</h5><br/>
                            <a href="{{ url('admin/research/feedback') }}">< Back</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="dataTable">
                                    <tr>
                                        <td>Email: <b>{{ $data->email }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Message: <b>{{ $data->message }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Case Study: <b><a target="_blank" href="{{ url('admin/research/buildings/edit/'.$data->research_building_id) }}">{{ $data->caseStudy->title }}</a></b> </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

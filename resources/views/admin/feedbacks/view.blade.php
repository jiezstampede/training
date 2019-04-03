@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
    <li><a href="{{route('adminFeedbacks')}}">Inquiries</a></li>
    <li class="active">View</li>
</ol>
@stop

@section('content')
<div class="col-sm-8">
    <div class="card ">
        <div class="card-header ">
            <p>View Feedback</p>
        </div>
        <div class="card-header ">
            <h4 class="card-title">{{ $data->subject }}</h4>
        </div>
        <div class="card-body ">
            <p>{{ $data->message }}</p>
            <br>
            <div class="row">
                <div class="col-xs-8">
                    <p>
                        <b>{{ $data->name }}</b><br>
                        <small><i class="text-muted">EMAIL: {{ $data->email }}</i></small><br>
                        <small><i class="text-muted">PHONE: {{ $data->phone }}</i></small><br>
                        <small><i class="text-muted">IP: {{ $data->ip }}</i></small><br>
                    </p>
                </div>
                <div class="col-xs-4 bottom-right-flex">
                    <a href="#" class="btn btn-info btn-round btn-icon inline-block" data-toggle="tooltip" title="Resend"><i class="far fa-paper-plane"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop 
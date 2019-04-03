@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
    <li class="active">Inquiries</li>
</ol>
@stop

@section('content')
<div class="col-md-8">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"> Inquiries</h4>
        </div>
        <div class="card-filter">
            <div class="row">
                <div class="col-sm-5">
                    {!! Form::open(['route'=>'adminFeedbacks', 'method' => 'get']) !!}
                    <div class="form-with-submit-icon">
                        {!! Form::text('name', $keyword, ['class'=>'form-control input-sm', 'placeholder'=>'Search']) !!}
                        <button class="btn btn-primary btn-round btn-icon" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="card-body">
            @if (count($data) > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="text-primary">
                        <th>Details</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                        <tr>
                            <td>
                                <div>{{ $d->name }}</div>
                                <div class="text-muted">{{ $d->email }}</div>
                                <div class="text-muted">{{ $d->phone }}</div>
                            </td>
                            <td>{{$d->subject}}</td>
                            <td>{{ $d->created_at }}</td>
                            <td width="80px" class="text-right">
                                <a href="#" class="btn btn-info btn-round btn-icon inline-block" data-toggle="tooltip" title="Resend"><i class="far fa-paper-plane"></i></a>
                                &nbsp;
                                <a href="{{ route('adminFeedbacksView', [$d->id]) }}" class="inline-block btn btn-primary btn-round btn-icon"><i class="far fa-eye"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p>No results found</p>
            @endif
        </div>
        @if ($pagination)
        <div class="card-footer">
            <div class="pagination-links">
                {!! $pagination !!}
            </div>
        </div>
        @endif
    </div>
</div>
@stop 
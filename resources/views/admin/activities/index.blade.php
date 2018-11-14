@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">

  <li class="active">Activities</li>
</ol>
@stop

@section('content')
<div class="col-sm-12">
  <div class="widget">
    <div class="header">
      <i class="fa fa-table"></i> Table
      <div class="pull-right">
        <a class="btn-transparent btn-sm" href="{{route('adminActivities')}}"><i class="fa fa-eye"></i> Show All</a>
      </div>
    </div>
    <div class="filters">
      {!! Form::open(['route'=>'adminActivities', 'method' => 'get']) !!}
      <label>
        Search: {!! Form::text('log', $keyword, ['class'=>'form-control input-sm', 'placeholder'=>'']) !!}
        <button><i class="fa fa-search"></i></button>
      </label>
      {!! Form::close() !!}
    </div>
    @if (count($data) > 0)
    <div class="table-responsive">
      <table class="table table-bordered table-hover table-striped">
        <thead>
          <tr>
            <th>Reference</th>
            <th>Message</th>
            <th>Date Created</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $d)
          <tr>
            <td><a href='{{route("adminActivitiesView", [$d->id])}}' class="text-info">{{$d->identifier_value}}</a></td>
            <td>{{$d->log}}</td>
            <td>{{$d->created_at}}</td>
            <td width="110px" class="text-center">

              <a href='{{route("adminActivitiesView", [$d->id])}}' class='btn btn-primary btn-xs'>View</a>
             <!--  <button type="button" class="btn btn-primary btn-xs" role="button" data-toggle="popover"
                data-trigger="click" title="{{$d->product_id}}" data-placement="left" data-html="true"
                data-content="@include('admin.activities.show', ['data' => $d])">
                VIEW
              </button> -->
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @if ($pagination)
      <div class="pagination-links text-right">
        {!! $pagination !!}
      </div>
      @endif
    </div>
    @else
    <div class="empty text-center">
      No results found
    </div>
    @endif
  </div>
</div>
@stop

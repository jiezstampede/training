@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li class="active">Emails</li>
</ol>
@stop

@section('content')
<div class="col-sm-12">
  <div class="widget">
    <div class="header">
      <i class="fa fa-table"></i> Table
      <div class="pull-right">
        <a class="btn-transparent btn-sm" href="{{route('adminEmails')}}"><i class="fa fa-eye"></i> Show All</a>
        <!-- <a class="btn-transparent btn-sm" href="{{route('adminEmailsCreate')}}"><i class="fa fa-plus-circle"></i> Create</a> -->
        <!-- <a class="btn-transparent btn-sm" href="#" data-toggle="modal" data-target="#delete-modal"><i class="fa fa-minus-circle"></i> Delete</a> -->
      </div>
    </div>
    <div class="filters">
      {!! Form::open(['route'=>'adminEmails', 'method' => 'get']) !!}
      <label>
        Search: {!! Form::text('to', $keyword, ['class'=>'form-control input-sm', 'placeholder'=>'']) !!}
        <button><i class="fa fa-search"></i></button>
      </label>
      {!! Form::close() !!}
    </div>
    @if (count($data) > 0)
    <div class="table-responsive">
      {!! Form::open(['route'=>'adminEmailsDestroy', 'method' => 'delete', 'class'=>'form form-parsley form-delete']) !!}
      <table class="table table-bordered table-hover table-striped">
        <thead>
          <tr>
           <!--  <th width="30px">
              <label>
                <input type="checkbox" name="delete-all" class="toggle-delete-all">
                <i class="fa fa-square input-unchecked"></i>
                <i class="fa fa-check-square input-checked"></i>
              </label>
            </th> -->
            <th width="30px"><i class="fa fa-paperclip" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Attachment"></i></th>
            <th>To</th>
            <th>Subject</th>
            <th>Status</th>
            <th width="170px">Created</th>
            <th></th>
          </tr>
        </thead>
        <tbody >
          @foreach ($data as $d)
          <tr >
           <!--  <td>
              <label>
                <input type="checkbox" name="ids[]" value="{{$d->id}}">
                <i class="fa fa-square input-unchecked"></i>
                <i class="fa fa-check-square input-checked"></i>
              </label>
            </td> -->
            <td>
              @if ($d->attach != "")
                <i class="fa fa-paperclip" aria-hidden="true"  data-toggle="tooltip" data-placement="right" title="" data-original-title="{{$d->attach}}"></i>
              @endif
            </td>
            <td>{{$d->to}}</td>
            <td>{{$d->subject}}</td>
            <td>
              <?php $emailDate = new Carbon($d->sent); ?>
              {!!  $boolSent = ( @$d->status == 'sent') ?  "<b>Sent</b>- ".$emailDate->toDayDateTimeString() : @$d->status ; !!}
            </td>
            <td>
               <?php $created_at = new Carbon($d->created_at); ?>
              {{$created_at->toFormattedDateString() . ' ' . $created_at->toTimeString()}}
            </td>
            <td width="60px" class="text-center">
              <button type="button" class="btn btn-primary btn-xs" role="button" data-toggle="popover" 
                data-trigger="focus" title="{{$d->subject}}" data-placement="left" data-html="true"
                data-content="@include('admin.emails.show', ['data' => $d])">
                VIEW
              </button>
             <!--  <a href="{{route('adminEmailsEdit', [$d->id])}}" class="btn btn-primary btn-xs">EDIT</a> -->
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {!! Form::close() !!}
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
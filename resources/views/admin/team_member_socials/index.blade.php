@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li class="active">Team Member Socials</li>
</ol>
@stop

@section('content')
<div class="col-sm-12">
  <div class="widget">
    <div class="header">
      <i class="fa fa-table"></i> Table
      <div class="pull-right">
        <a class="btn-transparent btn-sm" href="{{route('adminTeamMemberSocials')}}"><i class="fa fa-eye"></i> Show All</a>
        <a class="btn-transparent btn-sm" href="{{route('adminTeamMemberSocialsCreate')}}"><i class="fa fa-plus-circle"></i> Create</a>
        <a class="btn-transparent btn-sm" href="#" data-toggle="modal" data-target="#delete-modal"><i class="fa fa-minus-circle"></i> Delete</a>
      </div>
    </div>
    <div class="filters">
      {!! Form::open(['route'=>'adminTeamMemberSocials', 'method' => 'get']) !!}
      <label>
        Search: {!! Form::text('team_member_id', $keyword, ['class'=>'form-control input-sm', 'placeholder'=>'']) !!}
        <button><i class="fa fa-search"></i></button>
      </label>
      {!! Form::close() !!}
    </div>
    @if (count($data) > 0)
    <div class="table-responsive">
      {!! Form::open(['route'=>'adminTeamMemberSocialsDestroy', 'method' => 'delete', 'class'=>'form form-parsley form-delete']) !!}
      <table class="table table-bordered table-hover table-striped">
        <thead>
          <tr>
            <th width="30px"></th><th width="30px">
              <label>
                <input type="checkbox" name="delete-all" class="toggle-delete-all">
                <i class="fa fa-square input-unchecked"></i>
                <i class="fa fa-check-square input-checked"></i>
              </label>
            </th>
            <th>ID</th>
            <th>Team member id</th>
            <th>Name</th>
            <th>Icon type</th>
            <th></th>
          </tr>
        </thead>
        <tbody class="sortable" sortable-data-url="{{route('adminTeamMemberSocialsOrder')}}">
          @foreach ($data as $d)
          <tr sortable-id="team_member_socials-{{$d->id}}">
            <td><i class="fa fa-th-large sortable-icon" aria-hidden="true"></i></td><td>
              <label>
                <input type="checkbox" name="ids[]" value="{{$d->id}}">
                <i class="fa fa-square input-unchecked"></i>
                <i class="fa fa-check-square input-checked"></i>
              </label>
            </td>
            <td>{{$d->id}}</td>
            <td>{{$d->team_member_id}}</td>
            <td>{{$d->name}}</td>
            <td>{{$d->icon_type}}</td>
            <td width="110px" class="text-center">
              <button type="button" class="btn btn-primary btn-xs" role="button" data-toggle="popover" 
                data-trigger="focus" title="{{$d->team_member_id}}" data-placement="left" data-html="true"
                data-content="@include('admin.team_member_socials.show', ['data' => $d])">
                VIEW
              </button>
              <a href="{{route('adminTeamMemberSocialsEdit', [$d->id])}}" class="btn btn-primary btn-xs">EDIT</a>
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
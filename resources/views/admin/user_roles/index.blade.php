@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
    <li class="active">User Roles</li>
</ol>
@stop

@section('content')
<div class="col-md-8">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"> User Roles</h4>
        </div>
        <div class="card-filter">
            <div class="row">
                <div class="col-sm-5">
                    {!! Form::open(['route'=>'adminUserRoles', 'method' => 'get']) !!}
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
                {!! Form::open(['route'=>'adminUserRolesDestroy', 'method' => 'delete', 'class'=>'form form-parsley form-delete']) !!}
                <table class="table table-striped">
                    <thead class="text-primary">
                        <th width="30px">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input toggle-delete-all" name="delete-all" type="checkbox">
                                    <span class="form-check-sign"></span>
                                </label>
                            </div>
                        </th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th class="text-right" style="width: 75px">
                            <a href="{{route('adminUserRolesCreate')}}" class="btn btn-primary btn-round btn-icon"><i class="fas fa-plus"></i></a>
                            <a href="#" data-toggle="modal" data-target="#delete-modal" class="btn btn-danger btn-round btn-icon"><i class="far fa-trash-alt"></i></a>
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                        <tr>
                            <td class="text-center">
                                @unless ($d->permanent)
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="ids[]" value="{{$d->id}}">
                                        <span class="form-check-sign"></span>
                                    </label>
                                </div>
                                @endunless
                            </td>
                            <td>{{$d->id}}</td>
                            <td>{{$d->name}}</td>
                            <td>{{$d->description}}</td>
                            <td width="40px" class="text-right">
                                <a href="{{ route('adminUserRolesEdit', [$d->id]) }}" class="btn btn-primary btn-round btn-icon"><i class="far fa-edit"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! Form::close() !!}
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
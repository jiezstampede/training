@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
    <li class="active">Orders</li>
</ol>
@stop

@section('content')
<div class="col-md-10">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"> Orders</h4>
        </div>
        <div class="card-filter">
            <div class="row">
                <div class="col-sm-5">
                    {!! Form::open(['route'=>'adminTransactions', 'method' => 'get']) !!}
                    <div class="form-with-submit-icon">
                        {!! Form::text('name', $keyword, ['class'=>'form-control input-sm', 'placeholder'=>'Search']) !!}
                        <button class="btn btn-primary btn-round btn-icon" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="col-sm-7">
                    <div class="text-right">
                        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#upload-modal"><i class="fas fa-upload"></i> &nbsp;&nbsp;Import Orders from CSV</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if (count($data) > 0)
            <div class="table-responsive">
                {!! Form::open(['route'=>'adminTransactionsDestroy', 'method' => 'delete', 'class'=>'form form-parsley form-delete']) !!}
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
                        <th>number</th>
                        <th>Date</th>
                        <th class="text-right" style="width: 75px">
                            <a href="{{route('adminUsersCreate')}}" class="btn btn-primary btn-round btn-icon"><i class="fas fa-plus"></i></a>
                            <a href="#" data-toggle="modal" data-target="#delete-modal" class="btn btn-danger btn-round btn-icon"><i class="far fa-trash-alt"></i></a>
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                        <tr>
                            <td class="text-center">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="ids[]" value="{{$d->id}}">
                                        <span class="form-check-sign"></span>
                                    </label>
                                </div>
                            </td>
                            <td>{{$d->number}}</td>
                            <td>{{ Carbon::parse($d->date)->format('M d, Y') }}</td>
                            <td width="40px" class="text-right">
                                <a href="{{ route('adminUsersEdit', [$d->id]) }}" class="btn btn-primary btn-round btn-icon"><i class="far fa-edit"></i></a>
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

<div class="modal fade" id="upload-modal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
    <div class="modal-dialog" role="document">
        {!! Form::open(['route'=>'adminOrdersUploadCSV', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
        <div class="modal-content">
            <div class="modal-body">
                {!! csrf_field() !!}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3>Import Orders from CSV</h3>
                <p>Export your orders from your Lazada Seller Center Portal. (System only accepts csv file)</p>
                <input type="file" name="file" accept=".csv" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
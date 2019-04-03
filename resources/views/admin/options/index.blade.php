@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
    <li class="active">Settings</li>
</ol>
@stop

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"> General Settings</h4>
        </div>
        <div class="card-body">
            @if (count($data) > 0)
            <div class="table-responsive">
                {!! Form::open(['route'=>'adminOptionsDestroy', 'method' => 'delete', 'class'=>'form form-parsley form-delete']) !!}
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
                        <th>Name</th>
                        <th>Slug</th>
                        <th width="30px">Type</th>
                        <th>Value</th>
                        <th class="text-right" style="width: 75px">
                            <a href="{{route('adminOptionsCreate')}}" class="btn btn-primary btn-round btn-icon"><i class="fas fa-plus"></i></a>
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
                            <td>{{$d->name}}</td>
                            <td>{{$d->slug}}</td>
                            <td class="text-center">
                                @if ($d->type == 'text')
                                <i class='fa fa-font' data-toggle="tooltip" data-placement="top" title="" data-original-title="Text"></i>
                                @elseif ($d->type == 'asset')
                                <i class='fa fa-image' data-toggle="tooltip" data-placement="top" title="" data-original-title="Asset"></i>
                                @elseif ($d->type == 'bool')
                                <i class='fa fa-power-off' data-toggle="tooltip" data-placement="top" title="" data-original-title="On/Off"></i>
                                @endif
                            </td>
                            <td>
                                @if ($d->type == 'text')
                                {{str_limit($d->value,50)}}
                                @elseif ($d->type == 'asset')
                                <div class="sumo-asset-display" data-id="{{$d->asset}}" data-url="{{route('adminAssetsGet')}}"></div>
                                @elseif ($d->type == 'bool')
                                <?php 
                                $boolCheck = (@$d->value) ? 'On' : 'Off';
                                echo $boolCheck;
                                ?>
                                @endif
                            </td>
                            <td width="40px" class="text-right">
                                <a href="{{ route('adminOptionsEdit', [$d->id]) }}" class="btn btn-primary btn-round btn-icon"><i class="far fa-edit"></i></a>
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
@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="active">Dashboard</li>
</ol>
@stop

@section('content')
<div class="col-sm-6">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"> Activity Logs</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if (count($activities) > 0)
                <table class="table">
                    <thead class="">
                        <th># </th>
                        <th>Log </th>
                        <th class="text-right">Date</th>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($activities as $a)
                        <tr>
                            <td class="text-muted">{{ $a->identifier_value }}</td>
                            <td>{{ $a->log }}</td>
                            <td class="text-right">{{ $a->created_at }}</td>
                        </tr>
                        @endforeach
                        </tr>
                    </tbody>
                </table>
                @else
                <p>No results found</p>
                @endif
            </div>
        </div>
        @if ($pagination)
        <div class="card-footer">
            {!! $pagination !!}
        </div>
        @endif
    </div>
</div>
<div class="col-sm-6">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daily Quote <i class="fas fa-check"></i></h4>
        </div>
        <div class="card-body">
            <p><i>{!! $quote !!}</i></p>
            <p> - {{ $quote_by }}</p>
        </div>
    </div>
</div>
@stop 
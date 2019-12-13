@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
    <li class="active">Shipping Dispute</li>
</ol>
@stop

@section('content')
<div class="col-md-9">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"> Shipping Dispute</h4>
        </div>
        <div class="card-filter">
            <p><small>Shipping dispute covered by selected month</small></p>
            {!! Form::open(['route'=>'adminShippingDisputes', 'method' => 'get']) !!}
            <div class="row">
                <div class="col-sm-3">
                    <?php $default = Carbon::now()->format('m'); ?>
                    <div class="form-group">
                        {!! Form::select('month', [
                        '01' => 'January',
                        '02' => 'February',
                        '03' => 'March',
                        '04' => 'April',
                        '05' => 'May',
                        '06' => 'June',
                        '07' => 'July',
                        '08' => 'August',
                        '09' => 'September',
                        '10' => 'October',
                        '11' => 'November',
                        '12' => 'December',
                        ], $default, ['class'=>'form-control select2']) !!}
                    </div>
                    <?php
                    $year = Carbon::now()->format('Y');
                    $years = [];
                    foreach (range(0, 9) as $i) {
                        $years[$year - $i] = $year - $i;
                    }
                    ?>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        {!! Form::select('year', $years, null, ['class'=>'form-control select2']) !!}
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="">
                        <button type="submit" class="btn btn-primary no-margin">Check for disputes</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        @if (count($disputes) > 0)
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="text-primary">
                        <th>Order Date</th>
                        <th>Order Number</th>
                        <th>Seller SKU</th>
                        <th>Lazada SKU</th>
                        <th>Details</th>
                        <th>Amount Charged</th>
                        <th>Expected Amount to be Charged</th>
                    </thead>
                    <tbody>
                        @foreach ($disputes as $d)
                        <tr>
                            <td>{{ Carbon::parse($d['item']->date)->format('m/d/Y') }}</td>
                            <td>{{$d['item']->number}}</td>
                            <td>{{$d['item']->seller_sku}}</td>
                            <td>{{$d['item']->lazada_sku}}</td>
                            <td>{{$d['item']->details}}</td>
                            <td class="text-danger"><b>{{ number_format($d['shipping_charged'], 2 )}}</b></td>
                            <td><b>{{ number_format($d['shipping_paid'], 2) }}</b></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>

@if (count($disputes) > 0)
<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"> Summary</h4>
        </div>
        <div class="card-body">
            <p>No. of items affected: <strong>{{ count($disputes) }}</strong></p>
            <p><b>Total Paid: PHP {{ number_format($data['total_paid'], 2) }}</b></p>
            <p class="text-danger"><b>Total Charged: PHP {{ number_format($data['total_charged'], 2) }}</b></p>
            <p class="text-success"><b>Total Claims: PHP {{ number_format($data['total_charged'] - $data['total_paid'], 2) }}</b></p>
            <br>
            <a href="{{ route('adminShippingDisputesGenerate') }}?month={{$input['month']}}&year={{$input['year']}}" class="btn btn-primary btn-block">Generate Dispute xForm</a>
        </div>
    </div>
</div>
@endif

<div class="modal fade" id="upload-modal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
    <div class="modal-dialog" role="document">
        {!! Form::open(['route'=>'adminShippingDisputesUploadTransactions', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
        <div class="modal-content">
            <div class="modal-body">
                {!! csrf_field() !!}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3>Upload Transactions from CSV</h3>
                <p>Download your transactions from your Lazada Seller Center Portal. (System only accepts csv file)</p>
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

@section('added-scripts')
<script>
    $(".datepicker").datepicker({
        format: "mm-yyyy",
        startView: "months",
        minViewMode: "months"
    });
</script>
@stop
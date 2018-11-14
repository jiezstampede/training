@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li><a href="{{route('adminEmails')}}">Emails</a></li>
  <li class="active">View</li>
</ol>
@stop

@section('content')
<div class="col-md-12">
	<table class='table table-striped table-bordered table-view'>
		<tr>
			<th>Id</th>
			<td>{!!$data->id!!}</td>
		</tr>
		<tr>
			<th>To</th>
			<td>{!!$data->to!!}</td>
		</tr>
		<tr>
			<th>Subject</th>
			<td>{!!$data->subject!!}</td>
		</tr>
		<tr>
			<th>Cc</th>
			<td>{!!$data->cc!!}</td>
		</tr>
		<tr>
			<th>Bcc</th>
			<td>{!!$data->bcc!!}</td>
		</tr>
		<tr>
			<th>From</th>
			<td>
				{!!$data->from_name!!} 
				&lt;{!!$data->from_email!!}&gt;
			</td>
		</tr>
		<tr>
			<th>ReplyTo</th>
			<td>{!!$data->replyTo!!}</td>
		</tr>
		<tr>
			<th>Content</th>
			<td>{!!$data->content!!}</td>
		</tr>
		<tr>
			<th>Attach</th>
			<td>{!!$data->attach!!}</td>
		</tr>
		<tr>
			<th>Status</th>
			<td>{!!$data->status!!}</td>
		</tr>
		<tr>
			<th>Sent</th>
			<td>
				<?php $sent = new Carbon($data->sent); ?>
				{{$sent->toFormattedDateString() . ' ' . $sent->toTimeString()}}
			</td>
		</tr>
		<tr>
			<th>Created at</th>
			<td>
				@if ($data->created_at)
				<?php $created_at = new Carbon($data->created_at); ?>
				{{$created_at->toFormattedDateString() . ' ' . $created_at->toTimeString()}}
				@endif
			</td>
		</tr>
		<tr>
			<th>Updated at</th>
			<td>
				@if ($data->updated_at)
				<?php $created_at = new Carbon($data->updated_at); ?>
				{{$created_at->toFormattedDateString() . ' ' . $created_at->toTimeString()}}
				@endif
			</td>
		</tr>
	</table>
</div>
@stop
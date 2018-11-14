<table class='table table-striped table-bordered'>
	<tr>
		<th>To</th>
		<td>{{$data->to}}</td>
	</tr>
	<tr>
		<th>Subject</th>
		<td>{{$data->subject}}</td>
	</tr>
	<tr>
		<th>Cc</th>
		<td>{{$data->cc}}</td>
	</tr>
	<tr>
		<th>Bcc</th>
		<td>{{$data->bcc}}</td>
	</tr>
	<tr>
		<th>Status</th>
		<td>
 			<?php $emailDate = new Carbon($data->sent); ?>
            {!!  $boolSent = (@$data->status == 'sent') ?  $emailDate->toDayDateTimeString() : @$data->status ; !!}
		</td>
	</tr>

</table>
<a href='{{route("adminEmailsView", [$data->id])}}' class='btn btn-primary'>More Details</a>
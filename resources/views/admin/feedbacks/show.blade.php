<table class='table table-striped table-bordered'>
	<tr>
		<th>Name</th>
		<td>{{$data->name}}</td>
	</tr>
	<tr>
		<th>Email</th>
		<td>{{$data->email}}</td>
	</tr>
	<tr>
		<th>Phone</th>
		<td>{{$data->phone}}</td>
	</tr>
	<tr>
		<th>Subject</th>
		<td>{{$data->subject}}</td>
	</tr>
	<tr>
		<th>Message</th>
		<td>{{$data->message}}</td>
	</tr>
</table>
<a href='{{route("adminFeedbacksView", [$data->id])}}' class='btn btn-primary'>More Details</a>
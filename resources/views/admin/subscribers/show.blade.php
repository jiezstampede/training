<table class='table table-striped table-bordered'>
	<tr>
		<th>Name</th>
		<td>{{$data->name}}</td>
	</tr>
	<tr>
		<th>Email</th>
		<td>{{$data->email}}</td>
	</tr>
</table>
<a href='{{route("adminSubscribersView", [$data->id])}}' class='btn btn-primary'>More Details</a>
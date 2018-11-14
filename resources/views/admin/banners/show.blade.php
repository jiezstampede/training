<table class='table table-striped table-bordered'>
	<tr>
		<th>Name</th>
		<td>{{$data->name}}</td>
	</tr>
	<tr>
		<th>Caption</th>
		<td>{{$data->caption}}</td>
	</tr>
	<tr>
		<th>Link</th>
		<td>{{$data->link}}</td>
	</tr>
</table>
<a href='{{route("adminBannersView", [$data->id])}}' class='btn btn-primary'>More Details</a>
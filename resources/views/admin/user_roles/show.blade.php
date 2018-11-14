<table class='table table-striped table-bordered'>
	<tr>
		<th>Name</th>
		<td>{{$data->name}}</td>
	</tr>
	<tr>
		<th>Description</th>
		<td>{{$data->description}}</td>
	</tr>
</table>
<a href='{{route("adminUserRolesView", [$data->id])}}' class='btn btn-primary'>More Details</a>
<table class='table table-striped table-bordered'>
	<tr>
		<th>Name</th>
		<td>{{$data->name}}</td>
	</tr>
	<tr>
		<th>Slug</th>
		<td>{{$data->slug}}</td>
	</tr>
	<tr>
		<th>Description</th>
		<td>{{$data->description}}</td>
	</tr>
	<tr>
		<th>Parent</th>
		<td>{{$data->parent}}</td>
	</tr>
	<tr>
		<th>Master</th>
		<td>{{$data->master}}</td>
	</tr>
</table>
<a href='{{route("adminUserPermissionsView", [$data->id])}}' class='btn btn-primary'>More Details</a>
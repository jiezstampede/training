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
		<th>Image</th>
		<td>{{$data->image}}</td>
	</tr>
	<tr>
		<th>Background_image</th>
		<td>{{$data->background_image}}</td>
	</tr>
	<tr>
		<th>Background_image</th>
		<td>{{$data->background_image}}</td>
	</tr>
	<tr>
		<th>Position</th>
		<td>{{$data->position}}</td>
	</tr>
</table>
<a href='{{route("adminTeamMembersView", [$data->id])}}' class='btn btn-primary'>More Details</a>
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
		<th>Blurb</th>
		<td>{{$data->blurb}}</td>
	</tr>
	<tr>
		<th>Date</th>
		<td>{{$data->date}}</td>
	</tr>
	<tr>
		<th>Featured</th>
		<td>{{$data->featured}}</td>
	</tr>
</table>
<a href='{{route("adminArticlesView", [$data->id])}}' class='btn btn-primary'>More Details</a>
<table class='table table-striped table-bordered'>
	<tr>
		<th>Page_id</th>
		<td>{{$data->page_id}}</td>
	</tr>
	<tr>
		<th>Page_id</th>
		<td>{{$data->page_id}}</td>
	</tr>
	<tr>
		<th>Slug</th>
		<td>{{$data->slug}}</td>
	</tr>
	<tr>
		<th>Title</th>
		<td>{{$data->title}}</td>
	</tr>
	<tr>
		<th>Value</th>
		<td>{{$data->value}}</td>
	</tr>
	<tr>
		<th>Description</th>
		<td>{{$data->description}}</td>
	</tr>
</table>
<a href='{{route("adminPageItemsView", [$data->id])}}' class='btn btn-primary'>More Details</a>
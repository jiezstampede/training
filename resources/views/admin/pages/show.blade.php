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
		<th>Published</th>
		<td>{{$data->published}}</td>
	</tr>
	<tr>
		<th>page_category_id</th>
		<td>{!!$data->pageCategory->name!!}</td>
	</tr>
	<tr>
		<th>Content</th>
		<td>{{$data->content}}</td>
	</tr>
</table>
<a href='{{route("adminPagesView", [$data->id])}}' class='btn btn-primary'>More Details</a>
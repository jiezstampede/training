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
		<th>Date</th>
		<td>{{$data->date}}</td>
	</tr>
	<tr>
		<th>Tinyint</th>
		<td>{{$data->tinyint}}</td>
	</tr>
	<tr>
		<th>Order</th>
		<td>{{$data->order}}</td>
	</tr>
</table>
<a href='{{route("adminTestsView", [$data->id])}}' class='btn btn-primary'>More Details</a>
<table class='table table-striped table-bordered'>
	<tr>
		<th>Sample_id</th>
		<td>{{$data->sample_id}}</td>
	</tr>
	<tr>
		<th>Sample_id</th>
		<td>{{$data->sample_id}}</td>
	</tr>
	<tr>
		<th>Name</th>
		<td>{{$data->name}}</td>
	</tr>
</table>
<a href='{{route("adminSamplesTypesView", [$data->id])}}' class='btn btn-primary'>More Details</a>
<table class='table table-striped table-bordered'>
	<tr>
		<th>Asset_id</th>
		<td>{{$data->asset_id}}</td>
	</tr>
	<tr>
		<th>Asset_id</th>
		<td>{{$data->asset_id}}</td>
	</tr>
	<tr>
		<th>Samples_type_id</th>
		<td>{{$data->samples_type_id}}</td>
	</tr>
	<tr>
		<th>Samples_type_id</th>
		<td>{{$data->samples_type_id}}</td>
	</tr>
	<tr>
		<th>Samples_type_id</th>
		<td>{{$data->samples_type_id}}</td>
	</tr>
	<tr>
		<th>Order</th>
		<td>{{$data->order}}</td>
	</tr>
</table>
<a href='{{route("adminAssetSamplesTypeView", [$data->id])}}' class='btn btn-primary'>More Details</a>
<table class='table table-striped table-bordered'>
	<tr>
		<th>Number</th>
		<td>{{$data->number}}</td>
	</tr>
	<tr>
		<th>Date</th>
		<td>{{$data->date}}</td>
	</tr>
	<tr>
		<th>Type</th>
		<td>{{$data->type}}</td>
	</tr>
	<tr>
		<th>Fee_name</th>
		<td>{{$data->fee_name}}</td>
	</tr>
	<tr>
		<th>Fee_name</th>
		<td>{{$data->fee_name}}</td>
	</tr>
	<tr>
		<th>Amount</th>
		<td>{{$data->amount}}</td>
	</tr>
</table>
<a href='{{route("adminTransactionsView", [$data->id])}}' class='btn btn-primary'>More Details</a>
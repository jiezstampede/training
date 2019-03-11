@extends('admin.pages.index')

@section('items')
<tr>
	<td>Banner</td>
	<td width="110px" class="text-center">
		<a href="{{route('adminPagesEdit', [$slug, $slug . '-banner'])}}" class="btn btn-primary btn-xs">EDIT</a>
	</td>
</tr>
<tr>
	<td>About</td>
	<td width="110px" class="text-center">
		<a href="{{route('adminPagesEdit', [$slug, $slug . '-about'])}}" class="btn btn-primary btn-xs">EDIT</a>
	</td>
</tr>
<tr>
	<td>Partners</td>
	<td width="110px" class="text-center">
		<a href="{{route('adminPagesEdit', [$slug, $slug . '-partners'])}}" class="btn btn-primary btn-xs">EDIT</a>
	</td>
</tr>
<tr>
	<td>Inquiry</td>
	<td width="110px" class="text-center">
		<a href="{{route('adminPagesEdit', [$slug, $slug . '-inquiry'])}}" class="btn btn-primary btn-xs">EDIT</a>
	</td>
</tr>
@stop
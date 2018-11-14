@foreach ($assets as $a)
<div class="file" data-id="{{$a->id}}" style="background-image: url({{$a->mime_path}})"><span class="name">{{$a->name}}</span></div>
@endforeach
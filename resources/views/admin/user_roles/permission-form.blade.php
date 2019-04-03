<div class="col-sm-4">
  
  <ul class="list-group permission-list">
    @if(isset($data))
    {{General::checkPermission($permissions,$ids,0,$permissionIds)}}
    @else
    {{General::checkPermission($permissions,$ids,0,[])}}
    @endif
  </ul>
</div>


@section('added-scripts')
<script type="text/javascript">
	$(function() {
	  $("input[type='checkbox']").change(function () {
	    $(this).parent('li').next('ul')
	           .find("input[type='checkbox']")
	           .prop('checked', this.checked);
	  });
	});
</script>
@stop
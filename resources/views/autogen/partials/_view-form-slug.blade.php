@if (isset($data))
<div class="form-group">
  <label for="{$NAME}">{$PLACEHOLDER}</label>
  {!! Form::text('{$NAME}', null, ['class'=>'form-control', 'id'=>'{$NAME}', 'placeholder'=>'{$PLACEHOLDER}','readonly']) !!}
</div>
@endif

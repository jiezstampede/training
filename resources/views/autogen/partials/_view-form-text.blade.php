<div class="form-group">
  <label for="{$NAME}">{$PLACEHOLDER}</label>
  {!! Form::textarea('{$NAME}', null, ['class'=>'form-control redactor', 'id'=>'{$NAME}', 'placeholder'=>'{$PLACEHOLDER}'{$REQUIRED}, 'data-redactor-upload'=>route('adminAssetsRedactor')]) !!}
</div>

<div class="form-group">
  <label for="{$NAME}">{$PLACEHOLDER}</label>
  <br />
   <?php $boolCheck = (@$data->{$NAME}) ? 'disabled="disabled"': ''; ?>
     {!! Form::checkbox('{$NAME}', '0', null , ['hidden',$boolCheck]) !!}
    {!! Form::checkbox('{$NAME}', '1', null , ['data-toggle'=>'toggle','data-size'=>'small','class'=>'form-control ', 'id'=>'{$NAME}','data-onstyle'=>'warning','data-on'=>"<i class='fa fa-star'></i> On",'data-off'=>"<i class='fa fa-star-o'></i> Off "]) !!}
</div>
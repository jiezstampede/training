<div class="row" style="width: 100%;">
    <div class="col-sm-8">

        <div class="form-group">
            <label for="name">Name</label>
            {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Name', 'required']) !!}
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            {!! Form::text('description', null, ['class'=>'form-control', 'id'=>'description', 'placeholder'=>'Description', 'required']) !!}
        </div>
        <div class="form-group clearfix">
            <a href="{{route('adminUserRoles')}}" class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-primary pull-right">
                <i class="fa fa-check" aria-hidden="true"></i>
                Save
            </button>
        </div>
    </div>

    @include('admin.user_roles.permission-form')
</div> 
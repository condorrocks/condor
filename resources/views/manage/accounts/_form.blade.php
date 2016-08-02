<div class="container-fluid">
    <div class="row">
        <div class="form-group">
            {!! Form::text('name', null, [
                'required',
                'class'=>'form-control',
                'placeholder'=> trans('manage.account.label.name')
                ]) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            {!! Button::primary($submitLabel)->large()->block()->submit() !!}
        </div>
    </div>
</div>
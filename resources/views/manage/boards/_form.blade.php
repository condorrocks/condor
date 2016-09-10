<div class="container-fluid">
    <div class="row">
        <div class="form-group">
            {!! Form::select('account_id', $accounts, [
                'required',
                'class'=>'form-control',
                'placeholder'=> trans('manage.board.label.account')
                ]) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            {!! Form::text('name', null, [
                'required',
                'class'=>'form-control',
                'placeholder'=> trans('manage.board.label.name')
                ]) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            {!! Form::text('alert_to', null, [
                'class'=>'form-control',
                'placeholder'=> trans('manage.board.label.alert_to')
                ]) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            {!! Button::primary($submitLabel)->large()->block()->submit() !!}
        </div>
    </div>
</div>
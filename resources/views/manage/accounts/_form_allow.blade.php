<div class="panel panel-default">

    <div class="panel-heading">
        {{ trans('manage.account.title.allow') }}
    </div>

    <div class="panel-body">
        {!! Form::open(['method' => 'POST', 'route' => ['manage.accounts.allow', $account->id]]) !!}
        <div class="container-fluid">
            <div class="row">
                <div class="form-group">
                    {!! Form::text('email', null, [
                        'required',
                        'class'=>'form-control',
                        'placeholder'=> trans('manage.account.label.email')
                        ]) !!}
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    {!! Button::primary($submitLabel)->large()->block()->submit() !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

</div>


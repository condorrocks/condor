@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="col-md-4 col-md-offset-4">

        <div class="panel panel-default">

            <div class="panel-heading">
                {{ trans('manage.account.title.edit') }}
            </div>

            <div class="panel-body">
                {!! Form::model($account, ['method' => 'put', 'route' => ['manage.accounts.update', $account->id]]) !!}
                    @include('manage.accounts._form', ['submitLabel' => trans('manage.account.btn.update')])
                {!! Form::close() !!}
            </div>

        </div>

        {!! Form::open(['method' => 'POST', 'route' => ['manage.accounts.destroy', $account]]) !!}
            <input type="hidden" name="_method" value="DELETE">
            {!! Button::danger(trans('manage.account.btn.remove'))
                    ->withIcon(Icon::trash())
                    ->withAttributes(['type' => 'button'])
                    ->submit()
                    ->block() !!}
        {!! Form::close() !!}

    </div>
</div>
@endsection

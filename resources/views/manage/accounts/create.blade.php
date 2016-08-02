@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="col-md-4 col-md-offset-4">

        <div class="panel panel-default">

            <div class="panel-heading">
                {{ trans('manage.account.title.create') }}
            </div>

            <div class="panel-body">
                {!! Form::model($account, ['method' => 'POST', 'route' => ['manage.accounts.store']]) !!}
                    @include('manage.accounts._form', ['submitLabel' => trans('manage.account.btn.create')])
                {!! Form::close() !!}
            </div>

        </div>

    </div>
</div>
@endsection

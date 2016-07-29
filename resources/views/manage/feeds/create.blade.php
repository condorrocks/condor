@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="col-md-4 col-md-offset-4">

        <div class="panel panel-default">

            <div class="panel-heading">
                {{ trans('manage.feed.title.create') }}
            </div>

            <div class="panel-body">
                {!! Form::model($feed, ['method' => 'POST', 'route' => ['manage.feeds.store']]) !!}
                    @include('manage.feeds._form', ['submitLabel' => trans('manage.feed.btn.create')])
                {!! Form::close() !!}
            </div>

        </div>

    </div>
</div>
@endsection

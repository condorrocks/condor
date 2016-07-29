@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="col-md-4 col-md-offset-4">

        <div class="panel panel-default">

            <div class="panel-heading">
                {{ trans('manage.feed.title.edit') }}
            </div>

            <div class="panel-body">
                {!! Form::model($feed, ['method' => 'put', 'route' => ['manage.feeds.update', $feed->id]]) !!}
                    @include('manage.feeds._form', ['submitLabel' => trans('manage.feed.btn.update')])
                {!! Form::close() !!}
            </div>

        </div>

        {!! Form::open(['method' => 'POST', 'route' => ['manage.feeds.destroy', $feed->id, $board->id]]) !!}
            <input type="hidden" name="_method" value="DELETE">
            {!! Button::danger(trans('manage.feed.btn.remove'))
                    ->withIcon(Icon::trash())
                    ->withAttributes(['type' => 'button'])
                    ->submit()
                    ->block() !!}
        {!! Form::close() !!}

    </div>
</div>
@endsection

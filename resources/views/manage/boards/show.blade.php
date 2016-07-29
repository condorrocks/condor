@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="col-md-4 col-md-offset-4">

        <div class="panel panel-default">

            <div class="panel-heading">
                {{ $board->name }}
            </div>

            <div class="panel-body">
                {!! Button::primary(trans('manage.feed.btn.add'))
                    ->withIcon(Icon::plus())
                    ->asLinkTo(route('manage.feeds.create', $board))
                    ->block() !!}
            </div>

            <ul class="list-group">
                @foreach($board->feeds as $feed)
                <li class="list-group-item">
                    {!! Button::normal(trans('manage.feed.btn.edit'))
                        ->withIcon(Icon::edit())
                        ->asLinkTo(route('manage.feeds.edit', compact('feed', 'board'))) !!}
                    {{ $feed->aspect->name }} / {{ $feed->name }}
                </li>
                @endforeach
            </ul>

        </div>

    </div>
</div>
@endsection

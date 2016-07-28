@extends('layouts.app')

@section('title', trans('manage.boards.index.title'))
@section('subtitle', trans('manage.boards.index.instructions'))

@section('content')
<div class="container-fluid">
    <div class="col-md-4 col-md-offset-4">

        @each('manage.boards._account', $accounts, 'account')

        {!! Button::primary(trans('manage.board.btn.add'))
            ->withIcon(Icon::plus())
            ->asLinkTo(route('manage.boards.create') )
            ->block() !!}

    </div>
</div>
@endsection

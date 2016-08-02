@extends('layouts.app')

@section('title', trans('manage.boards.index.title'))
@section('subtitle', trans('manage.boards.index.instructions'))

@section('content')
<div class="container-fluid">
    <div class="row">

        @each('manage.boards._account', $accounts, 'account')

    </div>

    {!! Button::primary(trans('manage.board.btn.add'))
        ->withIcon(Icon::plus())
        ->asLinkTo(route('manage.boards.create') )
        ->large()
        ->block() !!}

</div>
@endsection

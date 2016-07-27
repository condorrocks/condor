@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="col-md-4 col-md-offset-4">

        <div class="panel panel-default">

            <div class="panel-heading">
                {{ trans('manage.board.edit.title') }}
            </div>

            <div class="panel-body">
                {!! Form::model($board, ['method' => 'put', 'route' => ['manage.boards.update', $board->id]]) !!}
                    @include('manage.boards._form', ['submitLabel' => trans('manage.boards.btn.update')])
                {!! Form::close() !!}
            </div>

        </div>

    </div>
</div>
@endsection

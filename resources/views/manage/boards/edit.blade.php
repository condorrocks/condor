@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="col-md-4 col-md-offset-4">

        <div class="panel panel-default">

            <div class="panel-heading">
                {{ trans('manage.board.title.edit') }}
            </div>

            <div class="panel-body">
                {!! Form::model($board, ['method' => 'put', 'route' => ['manage.boards.update', $board->id]]) !!}
                    @include('manage.boards._form', ['submitLabel' => trans('manage.board.btn.update')])
                {!! Form::close() !!}
            </div>

        </div>

        {!! Form::open(['method' => 'POST', 'route' => ['manage.boards.destroy', $board]]) !!}
            <input type="hidden" name="_method" value="DELETE">
            {!! Button::danger(trans('manage.board.btn.remove'))
                    ->withIcon(Icon::trash())
                    ->withAttributes(['type' => 'button'])
                    ->submit()
                    ->block() !!}
        {!! Form::close() !!}

    </div>
</div>
@endsection

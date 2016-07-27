@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="col-md-4 col-md-offset-4">

        <div class="panel panel-default">

            <div class="panel-heading">
                {{ trans('manage.board.create.title') }}
            </div>

            <div class="panel-body">
                {!! Form::model($board, ['method' => 'POST', 'route' => ['manage.boards.store']]) !!}
                    @include('manage.boards._form', ['submitLabel' => trans('manage.boards.btn.create')])
                {!! Form::close() !!}
            </div>

        </div>

    </div>
</div>
@endsection

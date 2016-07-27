@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="col-md-4 col-md-offset-4">

        <div class="panel panel-default">

            <div class="panel-heading">
                {{ $board->name }}
            </div>

            <div class="panel-body">

            </div>

            <ul class="list-group">
                @foreach($board->feeds as $feed)
                <li class="list-group-item">{{ $feed->aspect->name }} / {{ $feed->name }}</li>
                @endforeach
            </ul>

        </div>

    </div>
</div>
@endsection

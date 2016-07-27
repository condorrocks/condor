@extends('layouts.app')

@section('title', trans('manage.accounts.index.title'))
@section('subtitle', trans('manage.accounts.index.instructions'))

@section('content')
<div class="container-fluid">
    <div class="col-md-4 col-md-offset-4">

        @foreach ($accounts as $account)
        <div class="panel panel-default">

            <div class="panel-heading">
                {{ $account->name }}
            </div>
            
            <div class="panel-body">
                {{-- // --}}
            </div>
        </div>
        @endforeach

    </div>
</div>
@endsection

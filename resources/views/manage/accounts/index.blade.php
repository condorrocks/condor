@extends('layouts.app')

@section('title', trans('manage.accounts.index.title'))
@section('subtitle', trans('manage.accounts.index.instructions'))

@section('content')
<div class="container-fluid">
    <div class="col-md-4 col-md-offset-4">

        @foreach ($accounts as $account)
        <div class="panel panel-default">

            <div class="panel-heading">
                <i class="fa fa-folder-o"></i>&nbsp;{{ $account->name }}
            </div>
            
            <div class="panel-body">
                {!! Button::normal(trans('manage.account.btn.edit'))
                    ->withIcon(Icon::edit())
                    ->asLinkTo(route('manage.accounts.edit', $account) )
                    ->block() !!}
            </div>
        </div>
        @endforeach

        {!! Button::primary(trans('manage.account.btn.add'))
            ->withIcon(Icon::plus())
            ->asLinkTo(route('manage.accounts.create') )
            ->block() !!}

    </div>
</div>
@endsection

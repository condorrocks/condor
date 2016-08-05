@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <h1>{{ trans('dashboard.title') }}</h1>

            @each('panels.panel', $panels, 'panel')

        </div>
    </div>
</div>
@endsection

@push('footer_scripts')
{!! TidioChat::js() !!}
@endpush
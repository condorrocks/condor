@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            @if($markdown)
                {!! Markdown::convertToHtml($markdown) !!}
            @endif

            {!! Button::success(trans('app.welcome.btn'))
                        ->prependIcon(Icon::star())
                        ->large()
                        ->block()
                        ->asLinkTo(route('dashboard')) !!}

        </div>
    </div>
</div>
@endsection

@push('footer_scripts')
{!! TidioChat::js() !!}
@endpush
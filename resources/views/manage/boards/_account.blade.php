@foreach ($account->boards as $board)
<div class="panel panel-default">

    <div class="panel-heading">
        <i class="fa fa-btn fa-columns"></i>&nbsp;{{ $account->name }}/{{ $board->name }}
    </div>
    
    <div class="panel-body">
        {!! Button::primary(trans('manage.board.btn.show'))
            ->withIcon(Icon::eyeOpen())
            ->asLinkTo(route('manage.boards.show', compact('board')) )
            ->block() !!}

        {!! Button::normal(trans('manage.board.btn.edit'))
                ->withIcon(Icon::edit())
                ->asLinkTo(route('manage.boards.edit', compact('board')) )
                ->block() !!}
    </div>

    <div class="panel-footer">
        {{ trans('manage.board.feeds_count', ['count' => $board->feeds()->count()] ) }}
    </div>

</div>
@endforeach
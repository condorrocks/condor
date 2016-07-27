@foreach ($account->boards as $board)
<div class="panel panel-default">

    <div class="panel-heading">
        {{ $board->name }}
    </div>
    
    <div class="panel-body">
        {!! Button::normal()
            ->withIcon(Icon::edit())
            ->asLinkTo(route('manage.boards.edit', compact('board')) )
            ->block() !!}

        <br/>

        {!! Form::open(['method' => 'POST', 'route' => ['manage.boards.destroy', $board]]) !!}
            <input type="hidden" name="_method" value="DELETE">
            {!! Button::danger()->withIcon(Icon::trash())
                                ->withAttributes(['type' => 'button'])
                                ->submit()
                                ->block() !!}
        {!! Form::close() !!}
    </div>

    <div class="panel-footer">
        {{ $account->name }}
    </div>

</div>
@endforeach
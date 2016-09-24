{!! Form::hidden('board_id', $board->id) !!}
{!! Form::hidden('enabled', '0') !!}

<div class="container-fluid">
    <div class="row">
        <div class="form-group">
            {!! Form::select('aspect_id', $aspects, $feed->aspect ? $feed->aspect->id : $aspects->keys()->first(), [
                'required',
                'class'=>'form-control',
                'placeholder'=> trans('manage.feed.label.aspect')
                ]) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            {!! Form::text('name', null, [
                'required',
                'class'=>'form-control',
                'placeholder'=> trans('manage.feed.label.name')
                ]) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            {!! Form::text('apikey', null, [
                'class'=>'form-control',
                'placeholder'=> trans('manage.feed.label.apikey')
                ]) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            {!! Form::textarea('params', null, [
                'class'=>'form-control',
                'placeholder'=> trans('manage.feed.label.params')
                ]) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            {!! Form::label('enabled', trans('manage.feed.label.enabled')) !!}
            {!! Form::checkbox('enabled', '1', null, [
                'class'=>'form-control',
                'placeholder'=> trans('manage.feed.label.enabled'),
                ]) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            {!! Button::primary($submitLabel)->large()->block()->submit() !!}
        </div>
    </div>
</div>
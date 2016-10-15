<div class="col-xs-6 col-md-3">
    <div class="panel panel-default">
      <div class="panel-heading">{{ array_get($panel, 'name') }}</div>

        <!-- List group -->
        <ul class="list-group">

            @foreach(array_get($panel, 'snapshots') as $snapshot)
                <li class="list-group-item list-group-item-{{ $snapshot->cssStatus() }}" title="{{ trans('dashboard.updated', ['at' => $snapshot->timestamp()]) }}">
                    {{ $snapshot->aspect() }} / {{ $snapshot->target }}
                </li>
            @endforeach

        </ul>

    </div>
</div>

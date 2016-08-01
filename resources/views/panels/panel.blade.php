<div class="col-xs-6 col-md-3">
    <div class="panel panel-default">
      <div class="panel-heading">{{ array_get($panel, 'name') }}</div>

        <!-- List group -->
        <ul class="list-group">

            @foreach(array_get($panel, 'summary') as $aspects)

                @foreach(array_get($aspects, 'snapshots') as $aspect => $snapshot)
                    <li class="list-group-item list-group-item-{{ array_get($panel, "summary.".array_get($snapshot, 'aspect.name').".label") }}" title="{{ trans('dashboard.updated', ['at' => $snapshot['timestamp']]) }}">
                        {{ array_get($snapshot, 'aspect.name') }} / {{ array_get($snapshot, 'target') }} 
                    </li>
                @endforeach

            @endforeach

        </ul>

    </div>
</div>

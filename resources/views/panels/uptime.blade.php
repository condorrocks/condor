@foreach($monitors as $monitor)

<div class="col-xs-6 col-md-3">
    <div class="panel panel-{{ $monitor->statuslabel }}">
      <div class="panel-heading">{{ $monitor->friendlyname }}</div>

      <div class="panel-body">
        {{ $monitor->alltimeuptimeratio }} %
      </div>

    </div>
</div>

@endforeach
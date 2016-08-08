@extends('layouts.app')

@section('content')
<div class="container">
    
    <h1>Registered Users</h1>

    {!! Table::withContents($users->makeVisible(['last_ip', 'last_login_at'])->makeHidden('accounts')->toArray())->striped()->condensed()->hover() !!}

</div>
@endsection

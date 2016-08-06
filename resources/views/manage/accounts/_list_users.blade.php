<ul class="list-group">
    @foreach($account->users as $user)
    <li class="list-group-item">
        {{ $user->name }} / {{ $user->email }}
    </li>
    @endforeach
</ul>
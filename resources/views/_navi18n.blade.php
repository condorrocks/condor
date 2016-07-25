{{-- Language Switcher Dropdown --}}
<ul class="nav navbar-nav">

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            {{ $availableLanguages[$appLocale] }} <b class="caret"></b>
        </a>

        <ul class="dropdown-menu" role="menu">
        @foreach ($availableLanguages as $locale => $language)
            @if ($locale != $appLocale)
            <li>
                <a href="{{ route('lang.switch', compact('locale')) }}">{{ $language }}</a>
            </li>
            @endif
        @endforeach
        </ul>
    </li>

</ul>
{{-- Language Switcher Dropdown --}} 
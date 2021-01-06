<header role='header' class='header interior'>

    <nav class="nav" role='navigation'>

        <ul>
            <li>
                <a class="{{ Route::is('media-item.create') ? 'active' : '' }}" href='{{ route('media-item.create') }}' data-toggle="tooltip" data-placement="right" title="{{ __('To '.config('myupload.title').' Home') }}">
                    <span class="sr-only">{{ __('To '.config('myupload.title').' Home') }}</span>
                    <i class="fas fa-home"></i>
                </a>
            </li>
            <li>
                <a class="{{ Route::is('admin') ? 'active' : '' }}" href='{{ route('admin') }}' data-toggle="tooltip" data-placement="right" title="{{ __('Pending Media') }}">
                    <span class="sr-only">{{ __('Pending Media') }}</span>
                    <i class="fas fa-clock"></i>
                </a>
            </li>
            <li>
                <a class="{{ Route::is('ban.index') ? 'active' : '' }}" href='{{ route('ban.index') }}' data-toggle="tooltip" data-placement="right" title="{{ __('Ban Emails') }}">
                    <span class="sr-only">{{ __('Ban Emails') }}</span>
                    <i class="fas fa-ban"></i>
                </a>
            </li>
            <li>
                <a
                class="{{ Route::is('approved') ? 'active' : '' }}"
                href='{{ route('approved') }}'
                data-toggle="tooltip"
                data-placement="right"
                title="{{ __('Approved Media') }}"
                >
                    <span class="sr-only">{{ __('Approved Media') }}</span>
                    <i class="fas fa-images"></i>
                </a>
            </li>
            <li>
                <a
                class="{{ Route::is('rejected') ? 'active' : '' }}"
                href='{{ route('rejected') }}'
                data-toggle="tooltip"
                data-placement="right"
                title="{{ __('Rejected Media') }}"
                >
                    <span class="sr-only">{{ __('Rejected Media') }}</span>
                    <i class="fas fa-eye-slash"></i>
                </a>
            </li>
            <li>
                <a
                class="{{ Route::is('top-five') ? 'active' : '' }}"
                href='{{ route('top-five') }}'
                data-toggle="tooltip"
                data-placement="right"
                title="{{ __('Top 5 Media') }}"
                >
                    <span class="sr-only">{{ __('Top 5 Media') }}</span>
                    <i class="fas fa-list"></i>
                </a>
            </li>
            <li>
                <a class="{{ Route::is('user.index') ? 'active' : '' }}" href='{{ route('user.index') }}' data-toggle="tooltip" data-placement="right" title="{{ __('Users') }}">
                    <span class="sr-only">{{ __('Users') }}</span>
                    <i class="fas fa-users"></i>
                </a>
            </li>
            <li>
                <a
                class="{{ Route::is('account-settings') ? 'active' : '' }}"
                href='{{ route('account-settings') }}'
                data-toggle="tooltip"
                data-placement="right"
                title="{{ __('Account Settings') }}"
                >
                    <span class="sr-only">{{ __('Account Settings') }}</span>
                    <i class="fas fa-user-cog"></i>
                </a>
            </li>
            <li>
                <a
                href='{{ route('logout') }}'
                data-toggle="tooltip"
                data-placement="right"
                title="{{ __('Logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                >   
                    <span class="sr-only">{{ __('Logout') }}</span>
                    <i class="fas fa-sign-out-alt"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class='d-none'>
                    @csrf
                </form>
            </li>
        </ul>

    </nav> <!-- nav -->

</header> <!-- header home -->
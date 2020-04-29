<aside class="menu left-menu-container left-content-column">
    <p class="menu-label">
        Security Items
    </p>

    <ul class="menu-list">
        <li>
            <a href="{{ route('board.index') }}"
               class="@if (($activeMenu ?? '') === '') has-background-light @endif">{{ __('app.All Items') }}</a>
        </li>
        <li>
            <a href="{{ route('board.index', ['itemType' => 'password']) }}"
               class="@if (($activeMenu ?? '') === 'password') has-background-light @endif">{{ __('app.Passwords') }}</a>
        </li>
        <li>
            <a href="{{ route('board.index', ['itemType' => 'note']) }}"
               class="@if (($activeMenu ?? '') === 'note') has-background-light @endif">{{ __('app.Notes') }}</a>
        </li>
        <li>
            <a href="{{ route('user.settings') }}"
               class="@if (($activeMenu ?? '') === 'user.settings') has-background-light @endif">{{ __('app.Settings') }}</a>
        </li>
    </ul>
</aside>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Password Manager') }}</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <header>
                <div class="container">
                    <div class="content has-background-info">
                        <header-navigation
                            csrf="{{ csrf_token() }}"
                            @auth user-name="{{ Auth::user()->name }}" @endauth
                            :is-guest="@guest true @else false @endif"></header-navigation>
                    </div>
                </div>
            </header>

            <section class="section">
                <div class="container">
                    <div class="columns">
                        @auth()
                        <div class="column is-one-fifth is-hidden-touch">
                            @include('views.left_menu')
                        </div>
                        @endauth
                        <div class="column">
                            @include('views.top_content')
                            <div class="columns">
                                <div class="column">@yield('content')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <footer>
                <div class="container">
                    <div class="footer has-background-info">
                        <div class="has-text-centered">
                            <strong>{{ __('app.Own Password Manager') }}</strong> by Yuriy Peskov 2020
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <script src="/js/lang.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
</html>

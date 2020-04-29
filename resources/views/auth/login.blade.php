@extends('layouts.main')

@section('content')
<div class="box content-container">
    <div class="is-size-3">{{ __('app.Login') }}</div>

    <form class="box" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label for="email">{{ __('app.E-Mail Address') }}</label>
            </div>

            <div class="field-body">
                <input id="email"
                       type="email"
                       class="input @error('email') is-danger @enderror"
                       name="email" value="{{ old('email') }}"
                       required
                       autocomplete="email"
                       autofocus>

                @error('email')
                <div class="help has-text-danger error-input-msg" role="alert">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label for="password">{{ __('app.Password') }}</label>
            </div>

            <div class="field-body">
                <input id="password"
                       type="password"
                       class="input @error('password') is-danger @enderror"
                       name="password"
                       required
                       autocomplete="current-password">

                        @error('password')
                            <div class="help has-text-danger error-input-msg" role="alert">{{ $message }}</div>
                        @enderror
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-label is-normal"></div>

            <div class="field-body">
                <div class="control">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                    <label class="checkbox">{{ __('app.Remember Me') }}</label>
                </div>
            </div>
        </div>

        <div class="control">
            <div class="columns">
                <div class="column has-text-right">
                    <button type="submit" class="button is-primary">
                        {{ __('Login') }}
                    </button>
                </div>

                <div class="column is-2 has-text-right reset-password-msg">
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('app.Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>

    </form>

</div>
@endsection

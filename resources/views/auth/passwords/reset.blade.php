@extends('layouts.main')

@section('content')
<div class="box content-container">
    <div class="is-size-3">{{ __('app.Reset Password') }}</div>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label for="email">{{ __('app.E-Mail Address') }}</label>
            </div>

            <div class="field-body">
                <input id="email"
                       type="email"
                       class="input @error('email') is-danger @enderror"
                       name="email"
                       value="{{ $email ?? old('email') }}"
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
                       autocomplete="new-password">

                @error('password')
                    <div class="help has-text-danger error-input-msg" role="alert">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label for="password-confirm">{{ __('app.Confirm Password') }}</label>
            </div>

            <div class="field-body">
                <input id="password-confirm"
                       type="password"
                       class="input"
                       name="password_confirmation"
                       required
                       autocomplete="new-password">
            </div>
        </div>

        <div class="has-text-right">
                <button type="submit" class="button is-primary">
                    {{ __('app.Reset Password') }}
                </button>
        </div>
    </form>
</div>
@endsection

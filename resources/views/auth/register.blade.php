@extends('layouts.main')

@section('content')
<div class="box content-container">
    <div class="is-size-3">{{ __('app.Register') }}</div>

    <form class="box" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label for="name">{{ __('app.Name') }}</label>
            </div>

            <div class="field-body">
                <input id="name"
                       type="text"
                       class="input @error('name') is-danger @enderror"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       autocomplete="name"
                       autofocus>

                @error('name')
                <span class="is-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label for="email">{{ __('app.E-Mail Address') }}</label>
            </div>

            <div class="field-body">
                <div class="control register-field">
                    <input id="email"
                           type="email"
                           class="input @error('email') is-danger @enderror"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autocomplete="email">

                    @error('email')
                    <p class="help is-danger" role="alert">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label for="password">{{ __('app.Password') }}</label>
            </div>

            <div class="field-body">
                <div class="control register-field">
                    <input id="password"
                           type="password"
                           class="input @error('password') is-danger @enderror"
                           name="password"
                           required
                           autocomplete="new-password">

                    @error('password')
                    <p class="help is-danger" role="alert">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label for="password">{{ __('app.Confirm Password') }}</label>
            </div>

            <div class="field-body">
                <div class="control register-field">
                    <input id="password-confirm"
                           type="password"
                           class="input"
                           name="password_confirmation"
                           required
                           autocomplete="new-password">
                </div>
            </div>
        </div>


        <div class="control">
            <div class="has-text-right">
                <button type="submit" class="button is-primary">
                    {{ __('app.Register') }}
                </button>
            </div>
        </div>
    </form>

</div>
@endsection

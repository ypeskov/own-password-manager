@extends('layouts.main')

@section('content')
<div class="box content-container">
    <div class="is-size-3">{{ __('Reset Password') }}</div>

    @if (session('status'))
        <div class="is-normal has-text-success" role="alert">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label for="email">{{ __('E-Mail Address') }}</label>
            </div>

            <div class="field-body">
                <input id="email"
                       type="email"
                       class="input @error('email') is-danger @enderror"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autocomplete="email"
                       autofocus>

                @error('email')
                    <div class="help has-text-danger error-input-msg" role="alert">{{ $message }}</div>
                @enderror
            </div>
        </div>


        <div class="has-text-right">
            <button type="submit" class="button is-primary">
                {{ __('Send Password Reset Link') }}
            </button>
        </div>
    </form>
</div>
@endsection

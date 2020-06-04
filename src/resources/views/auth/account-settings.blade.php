@extends('layouts.dashboard')

@section('content')

    <div class="row custom-row">

        <div class="col-12">

            <h2 class='display-5 mb-5 d-inline-block'>{{ __('Account Settings') }}</h2>

        </div> <!-- col-12 -->

        <div class="col-6">

            <h3 class="display-6 mb-3">Reset Password</h3>

            <form method="POST" action="{{ route('account-settings-update', ['form' => 'password']) }}">
                @csrf

                <div class="form-group">

                    <label for="password">{{ __('New Password') }}</label>

                    <input
                    id='password'
                    type="password"
                    class='form-control'
                    name="password"
                    required
                    autocomplete="new-password"
                    >

                </div> <!-- form-group -->

                <div class="form-group">

                    <label for="password-confirm">{{ __('Confirm New Password') }}</label>

                    <input
                    id='password-confirm'
                    type="password"
                    class='form-control'
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    >

                </div> <!-- form-group -->

                <button type='submit' class='btn btn-info' role='button'>{{ __('Reset Password') }}</button>
            
            </form>

        </div> <!-- col-6 -->

        <div class="col-md-6">

            <h3 class="display-6 mb-3">Change Email</h3>

            <form method="POST" action="{{ route('account-settings-update', ['form' => 'email']) }}">
                @csrf

                <div class="form-group">
                    
                    <label for="current_email">{{ __('Current Email Address') }}</label>

                    <input
                    id="email"
                    type="email"
                    class="form-control"
                    name="current_email"
                    value="{{ Auth::user()->email }}"
                    disabled
                    >

                </div> <!-- form-group -->

                <div class="form-group">

                    <label for="email">{{ __('New Email Address') }}</label>

                    <input
                    id="email"
                    type="email"
                    class="form-control"
                    name="email"
                    value="{{ $email ?? old('email') }}"
                    required
                    autocomplete="email"
                    autofocus
                    >
                    
                </div> <!-- form-group -->

                <div class="form-group">

                    <label for="email_confirm">{{ __('Confirm New Email Address') }}</label>

                    <input
                    id="email"
                    type="email"
                    class="form-control"
                    name="email_confirm"
                    value="{{ $email ?? old('email') }}"
                    required
                    autocomplete="email"
                    autofocus
                    >
                    
                </div> <!-- form-group -->

                <button type='submit' class='btn btn-info' role='button'>{{ __('Change Email') }}</button>

            </form>

        </div> <!-- col-md-6 -->

    </div> <!-- row custom-row -->

@endsection
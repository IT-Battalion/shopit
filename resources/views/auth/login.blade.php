@extends('layouts.app')

@section('content')
<section class="d-flex d-lg-flex justify-content-lg-center align-items-lg-center login-clean" style="background: rgb(255,255,255);">
    <section class="d-flex d-lg-flex justify-content-center flex-wrap m-auto justify-content-lg-center align-items-lg-center" style="width: 50em;padding-bottom:2em!important;height: 45em;background: #ffffff;border-radius: 30px;box-shadow: 9px 11px 20px 0px rgb(204,204,204);border: 0px none rgb(33, 37, 41);padding: 0;">
        <section class="flex-wrap m-auto" style="width: 18em;">
            <h1 style="font-family: Quicksand, sans-serif;font-size: 4em;">{{ __('Login') }}</h1>
            <p style="font-family: Quicksand, sans-serif;">{{ __('Bitte melden Sie sich mit Ihren bestehenden E-Learning Account an') }}</p>
        </section>
        <section class="d-flex d-lg-flex align-items-center align-content-center flex-wrap m-auto justify-content-md-center justify-content-lg-center align-items-lg-center" style="width: 20em;height: 30em;">
            <form method="post" action="{{ route('login') }}" style="border-radius: 21px;width: 20em;height: 32em;background: #303e4e;">
                @csrf
                <div class="illustration"><i class="icon ion-ios-navigate" style="color: rgb(255,255,255);"></i></div>
                <div class="mb-3">
                    <input class="form-control @error('username') is-invalid @enderror" type="text" name="username" placeholder="{{ __('Username') }}" style="color: rgb(255,255,255);background: rgb(48,63,78);border-bottom-width: 1px;">

                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="{{ __('Password') }}" style="background: rgb(48,63,78);color: rgb(255,255,255);">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3 form-check" style="background: rgb(48,63,78);color: rgb(255,255,255);">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" style="color: rgb(255,255,255);">
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
                <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit" style="border-radius: 30px;background: #417fb4;">{{ __('Log In') }}</button></div>
            </form>
        </section>
    </section>
</section>
@endsection

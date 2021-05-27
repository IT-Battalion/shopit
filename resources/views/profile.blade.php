@extends('layouts.app')

@section('content')
    <main>
        <section>
            <i class="fas fa-user d-flex d-lg-flex justify-content-center align-items-center justify-content-lg-center align-items-lg-center" style="font-size: 8em;padding-top: 0.4em;"></i>
            <h1 class="text-center d-lg-flex justify-content-lg-center align-items-lg-center" style="margin: 0.5em;font-family: Quicksand, sans-serif;font-size: 3.7em;font-weight: normal;">{{ Auth::user()->name }}</h1>
            <h2 class="d-flex d-lg-flex justify-content-center align-items-center justify-content-lg-center align-items-lg-center" style="color: #5097d5;font-family: Quicksand, sans-serif;font-size: 1.8em;">
                @switch(Auth::user()->employeeType)
                    @case("schueler")
                        {{ __('TGM Schüler') }}
                        @break
                    @case("lehrer")
                        {{ __('TGM Lehrer') }}
                        @break
                    @default
                        {{ __('TGM Mitglied') }}
                @endswitch
                @if (Auth::user()->isAdmin)
                - {{ __('Admin') }}
                @endif
            </h2>

            @if (Route::has('order-history'))
            <div class="d-flex justify-content-center justify-content-lg-center" style="padding-top: 1em;"><i class="fas fa-file-alt d-flex justify-content-lg-center align-items-lg-center" style="font-size: 1.7em;"></i><a style="margin-left: 0.7em;font-size: 1.2em;color: rgb(33,38,41);font-family: Quicksand, sans-serif;" href="{{ route('order-history') }}">{{ __('Bestellverlauf') }}</a></div>
            @endif

            @if (Auth::user()->isAdmin)
            <div class="d-flex justify-content-center align-items-center justify-content-lg-center align-items-lg-center" style="padding-top: 1em;">
                <h1 class="d-flex d-lg-flex justify-content-center align-items-center" style="font-family: Quicksand, sans-serif;font-size: 3em;">Products</h1><i class="fas fa-plus-circle d-flex d-lg-flex justify-content-center align-items-center justify-content-lg-end" style="font-size: 2.6em;margin-left: 0.5em;"></i>
            </div>
            <div class="d-lg-flex justify-content-lg-center align-items-lg-center" style="margin-right: 3em;margin-left: 3em;border-radius: 60px;box-shadow: 6px 6px 9px 0px rgb(177,177,177);border: 0.1em solid rgb(232,232,232) ;"><img>
                <h1>Heading</h1><i class="fa fa-star"></i>
            </div>
            @endif
        </section>
    </main>
@endsection

@extends('layouts.app')

@section('content')
    <main>
        <div class="container">
            @isset($products)
            @if($products->isNotEmpty())
            @foreach ($products as $product)
                <div class="row">
                    <div class="col-md-6 col-lg-7">
                        <div class="row" style="border-radius: 0;border-bottom: 0.15em solid rgb(171,171,171);">
                            <div class="col-2"><img class="rounded-circle" src="{{ $product->thumbnail()->getResults()->path }}" style="width: 6em;"></div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <h1 style="font-family: Quicksand, sans-serif;">{{ $product->name }}</h1>
                                        <div class="row">
                                            <div class="col">
                                                <div class="d-flex">
                                                    <p style="color: rgb(171,171,171);padding-right: 0.5em;font-family: Quicksand, sans-serif;">{{ $product->getProductAttributeType() }}:</p>
                                                    <p style="font-family: Quicksand, sans-serif;">
                                                        {{ $product->getProductAttribute() }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="d-flex">
                                                    <p style="color: rgb(171,171,171);padding-right: 0.5em;font-family: Quicksand, sans-serif;">{{ __('Typ') }}:</p>
                                                    <p style="font-family: Quicksand, sans-serif;">{{ $product->category()->getResults()->name }}</p>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="d-flex">
                                                    <p style="color: rgb(171,171,171);padding-right: 0.5em;font-family: Quicksand, sans-serif;">{{ __('MwSt') }}:</p>
                                                    <p style="font-family: Quicksand, sans-serif;">0% = {{ $product->price * $product->pivot->count * 0 }}€</p>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="d-flex">
                                                    <p style="color: rgb(171,171,171);padding-right: 0.5em;font-family: Quicksand, sans-serif;">{{ __('Preis') }}:</p>
                                                    <p style="font-family: Quicksand, sans-serif;">{{ $product->price }}€</p>&nbsp;*&nbsp;
                                                    <p style="font-family: Quicksand, sans-serif;">{{ $product->pivot->count }}</p>&nbsp;Stück&nbsp;=&nbsp;
                                                    <p style="font-family: Quicksand, sans-serif;">{{ $product->price * $product->pivot->count }}€</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @else
            <div class="row">
                <div class="col-md-6 col-lg-7">
                    <div class="row" style="border-radius: 0;border-bottom: 0.15em solid rgb(171,171,171);">
                        No items found
                    </div>
                </div>
            </div>
            @endif
            @endisset
            <div class="row">
                <div class="col-md-6 col-lg-7">
                    <div class="row" style="border-radius: 0;border-bottom: 0.15em solid rgb(171,171,171);">
                        <div class="col" style="width: 2em;"></div>
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h1 style="font-family: Quicksand, sans-serif;"></h1>
                                    <div class="row">
                                        <div class="col">
                                        </div>
                                        <div class="col">
                                        </div>
                                        <div class="col">
                                        </div>
                                        <div class="col">
                                            <div class="d-flex">
                                                <p style="color: rgb(171,171,171);padding-right: 0.5em;font-family: Quicksand, sans-serif;">{{ __('Gesamtpreis') }}:</p>
                                                <p style="font-family: Quicksand, sans-serif;">{{ $total }}€</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

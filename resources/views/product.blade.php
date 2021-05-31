@extends('layouts.app')

@section('content')
    <main>
        <h1 style="font-family: Quicksand, sans-serif;text-align: center;padding-top: 0.5em;padding-bottom: 0.5em;">{{ $product->name }}</h1>
        <div class="carousel slide d-flex d-xl-flex m-auto justify-content-xl-center align-items-xl-center" data-bs-ride="carousel" id="carousel-1" style="padding-top: 2em;padding-left: 2em;padding-right: 2em;">
            <div class="carousel-inner">
                @foreach ($product->images as $image)
                    <div class="carousel-item @if ($loop->first) active @endif"><img class="w-100 d-block" src="{{ route('products.images.show', ['product' => $product->id, 'image' => $image->id]) }}" alt="Slide Image"></div>
                @endforeach
            </div>
            <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span><span class="visually-hidden">Previous</span></a><a class="carousel-control-next" href="#carousel-1" role="button" data-bs-slide="next"><span class="carousel-control-next-icon"></span><span class="visually-hidden">Next</span></a></div>
            <ol class="carousel-indicators">
                @foreach ($product->images as $image)
                <li data-bs-target="#carousel-1" data-bs-slide-to="{{ $loop->index }}"@if ($loop->first) class="active" @endif></li>
                @endforeach
            </ol>
        </div>
    </main>
    <p style="padding-top: 2em;padding-right: 4em;padding-left: 4em;font-family: Quicksand, sans-serif;">{{ $product->description }}</p>
    <div class="row" style="margin-right: 3em;margin-left: 3em;padding-top: 0.5EM;padding-bottom: 0.5EM;">
        <div class="col-lg-2">
            <h3 style="font-family: Quicksand, sans-serif;">Typ:</h3>
        </div>
        <div class="col-lg-2 col-xl-2 d-lg-flex justify-content-lg-center align-items-lg-center" style="text-align: left;">
            <p class="d-lg-flex m-auto justify-content-lg-center align-items-lg-center" style="font-family: Quicksand, sans-serif;font-size: 1.3em;">{{ $product->category->name }}</p>
        </div>
    </div>
    @if ($product->attribute_type != 'clothing')
    <div class="row" style="margin-right: 3em;margin-left: 3em;padding-top: 0.5EM;padding-bottom: 0.5EM;">
        <div class="col-lg-2">
            <h3 style="font-family: Quicksand, sans-serif;">{{ $product->getProductAttributeType() }}:</h3>
        </div>
        <div class="col-lg-2 col-xl-2 d-lg-flex justify-content-lg-center align-items-lg-center" style="text-align: left;">
            <p class="d-lg-flex m-auto justify-content-lg-center align-items-lg-center" style="font-family: Quicksand, sans-serif;font-size: 1.3em;">{{ $product->getProductAttribute() }}</p>
        </div>
    </div>
    @else
    <div class="row" style="margin-right: 3em;margin-left: 3em;padding-top: 0.5em;padding-bottom: 0.5em;">
        <div class="col-lg-2">
            <h3 style="font-family: Quicksand, sans-serif;">Kleidungsgröße:</h3>
        </div>
        <div class="col-lg-2 col-xl-2 d-lg-flex justify-content-lg-center align-items-lg-center" style="text-align: left;">
            <select class="form-select" form="buy-form" aria-label="Kleidungsgröße">
                @foreach (explode(', ', $product->attribute_value) as $size)
                <option @if ($loop->index === intval($loop->count/2)) selected @endif>{{ $size }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endif
    <div class="row" style="margin-right: 3em;margin-left: 3em;padding-top: 0.5EM;padding-bottom: 0.5EM;">
        <div class="col-lg-2">
            <h3 style="font-family: Quicksand, sans-serif;">Anzahl:</h3>
        </div>
        <div class="col-lg-2 col-xl-2 d-lg-flex justify-content-lg-center align-items-lg-center" style="text-align: left;">
            <p class="d-lg-flex m-auto justify-content-lg-center align-items-lg-center" style="font-family: Quicksand, sans-serif;font-size: 1.3em;">
                <input type="number" form="buy-form" class="form-control col-1" min="1" max="{{ $product->available }}" name="count" id="count" value="{{ old('count') || '1' }}" /> <span class="col-1">/{{ $product->available }}</span>
            </p>
        </div>
    </div>
    <div class="row" style="margin-right: 3em;margin-left: 3em;padding-top: 0.5EM;padding-bottom: 0.5EM;">
        <div class="col-lg-2">
            <h3 style="font-family: Quicksand, sans-serif;">Preis:</h3>
        </div>
        <div class="col-lg-2 col-xl-2 d-lg-flex justify-content-lg-center align-items-lg-center" style="text-align: left;">
            <p class="d-lg-flex m-auto justify-content-lg-center align-items-lg-center" style="font-family: Quicksand, sans-serif;font-size: 1.3em;">{{ $product->price }}€</p>
        </div>
    </div>
    @guest
        <div class="row" style="padding-top: 0.5em;padding-bottom: 5em;">
            <div class="col"><button type="submit" form="buy-form" class="btn btn-primary d-flex m-auto justify-content-lg-center align-items-lg-center" type="button" style="border-left-color: #1a7ae1;border-radius: 30px;">In den Einkaufswagen&nbsp;<i class="fas fa-cart-plus d-flex justify-content-center align-items-center m-auto" style="font-size: 1em;"></i></button></div>
        </div>
    @else
        @if (Auth::user()->id == $product->created_by)
            <div class="row" style="padding-top: 0.5em;padding-bottom: 5em;">
                <div class="col"><a href="{{ route('products.edit', [ 'product' => $product->id ]) }}"><button class="btn btn-primary d-flex m-auto justify-content-lg-center align-items-lg-center" type="button" style="border-left-color: #1a7ae1;border-radius: 30px;">bearbeiten&nbsp;<i class="fas fa-cart-plus d-flex justify-content-center align-items-center m-auto" style="font-size: 1em;"></i></button></a></div>
            </div>
            <div class="row" style="padding-top: 0.5em;padding-bottom: 5em;">
                <div class="col"><button type="submit" form="delete-form" class="btn btn-primary d-flex m-auto justify-content-lg-center align-items-lg-center" type="button" style="border-left-color: #1a7ae1;border-radius: 30px;">Löschen&nbsp;<i class="fas fa-cart-plus d-flex justify-content-center align-items-center m-auto" style="font-size: 1em;"></i></button></div>
            </div>
        @else
            <div class="row" style="padding-top: 0.5em;padding-bottom: 5em;">
                <div class="col"><button type="submit" form="buy-form" class="btn btn-primary d-flex m-auto justify-content-lg-center align-items-lg-center" type="button" style="border-left-color: #1a7ae1;border-radius: 30px;">In den Einkaufswagen&nbsp;<i class="fas fa-cart-plus d-flex justify-content-center align-items-center m-auto" style="font-size: 1em;"></i></button></div>
            </div>
        @endif
    @endguest
    @if (Route::has('shopping-cart.add'))
    <form action="{{ route('shopping-cart.add', $product->id) }}" id="buy-form" method="POST">
        @csrf
    </form>
    @endif
    @if (Route::has('products.destroy'))
    <form action="{{ route('products.destroy', $product->id) }}" id="delete-form" method="POST">
        @csrf
        @method('DELETE')
    </form>
    @endif
@endsection

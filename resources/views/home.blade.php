@extends('layouts.app')

@section('content')
    <!--<div class="d-flex blog-slider">
        <div class="blog-slider__wrp swiper-wrapper">
            <div class="blog-slider__item swiper-slide">
                <div></div>
                <div class="blog-slider__img"><img src="{{ asset('img/blog-1.jpg') }}"></div>
                <div class="blog-slider__content">
                    <span class="blog-slider__code">4 May 2021</span>
                    <div class="blog-slider__title">Produkt 1</div>
                    <div class="blog-slider__text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Recusandae voluptate repellendus magni illo ea animi? </div>
                    <a class="class=&quot;blog-slider__button" href="#">READ MORE</a>
                </div>
            </div>
            <div class="blog-slider__item swiper-slide">
                <div></div>
                <div class="blog-slider__img"><img src="{{ asset('img/blog-2.jpg') }}"></div>
                <div class="blog-slider__content">
                    <span class="blog-slider__code">26 December 2019</span>
                    <div class="blog-slider__title">Lorem Ipsum Dolor</div>
                    <div class="blog-slider__text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Recusandae voluptate repellendus magni illo ea animi? </div>
                    <a class="class=&quot;blog-slider__button" href="#">READ MORE</a>
                </div>
            </div>
            <div class="blog-slider__item swiper-slide">
                <div></div>
                <div class="blog-slider__img"><img src="{{ asset('img/blog-3.jpg') }}"></div>
                <div class="blog-slider__content">
                    <span class="blog-slider__code">26 December 2019</span>
                    <div class="blog-slider__title">Lorem Ipsum Dolor</div>
                    <div class="blog-slider__text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Recusandae voluptate repellendus magni illo ea animi? </div>
                    <a class="class=&quot;blog-slider__button" href="#">READ MORE</a>
                </div>
            </div>
            <div class="blog-slider__pagination"></div>
        </div>
    </div>-->
    <section class="projects-clean">
        <div class="container">
            <div class="intro">
                <h2 class="text-center" style="margin-top: -1em;">Projects</h2>
                <p class="text-center" style="margin: 1em;">Nunc luctus in metus eget fringilla. Aliquam sed justo ligula. Vestibulum nibh erat, pellentesque ut laoreet vitae. </p>
            </div>
            <div class="row d-flex d-lg-flex m-auto justify-content-lg-center align-items-lg-center projects">
                <div class="col-sm-6 col-lg-4 mx-auto item" style="border-radius: 25px;box-shadow: 3px 9px 18px 0px rgb(178,182,186);border-style: solid;border-color: rgb(251,251,251);margin: 1em;width: 18em;"><img class="img-fluid" src="{{ asset('img/desk.jpg') }}" style="border-radius: 20px;">
                    <h3 class="name">Produkt</h3>
                    <p class="description">Beschreibung</p><strong class="d-flex d-lg-flex justify-content-center align-items-center justify-content-lg-center align-items-lg-center" style="padding-top: 0.5em;padding-bottom: 0.5em;">20€</strong>
                    <div class="btn-group" role="group" style="width: 12em;"><button class="btn btn-primary" type="button"><i class="fa fa-info"></i></button><button class="btn btn-primary" type="button"><i class="fa fa-cart-plus"></i></button></div>
                </div>
                <div class="col-sm-6 col-lg-4 mx-auto item" style="border-radius: 25px;box-shadow: 3px 9px 18px 0px rgb(178,182,186);border-style: solid;border-color: rgb(251,251,251);width: 18em;margin: 1em;"><img class="img-fluid" src="{{ asset('img/desk.jpg') }}" style="border-radius: 20px;">
                    <h3 class="name">Produkt</h3>
                    <p class="description">Beschreibung</p><strong class="d-flex d-lg-flex justify-content-center align-items-center justify-content-lg-center align-items-lg-center" style="padding-top: 0.5em;padding-bottom: 0.5em;">20€</strong>
                    <div class="btn-group" role="group" style="width: 12em;"><button class="btn btn-primary" type="button"><i class="fa fa-info"></i></button><button class="btn btn-primary" type="button"><i class="fa fa-cart-plus"></i></button></div>
                </div>
                <div class="col-sm-6 col-lg-4 mx-auto item" style="border-radius: 25px;box-shadow: 3px 9px 18px 0px rgb(178,182,186);border-style: solid;border-color: rgb(251,251,251);margin: 1em;width: 18em;"><img class="img-fluid" src="{{ asset('img/desk.jpg') }}" style="border-radius: 20px;">
                    <h3 class="name">Produkt</h3>
                    <p class="description">Beschreibung</p><strong class="d-flex d-lg-flex justify-content-center align-items-center justify-content-lg-center align-items-lg-center" style="padding-top: 0.5em;padding-bottom: 0.5em;">20€</strong>
                    <div class="btn-group" role="group" style="width: 12em;"><button class="btn btn-primary" type="button"><i class="fa fa-info"></i></button><button class="btn btn-primary" type="button"><i class="fa fa-cart-plus"></i></button></div>
                </div>
                @isset($products)
                    @if($products->isNotEmpty())
                        @foreach ($products as $product)
                            <div class="col-sm-6 col-lg-4 mx-auto item" style="border-radius: 25px;box-shadow: 3px 9px 18px 0px rgb(178,182,186);border-style: solid;border-color: rgb(251,251,251);margin: 1em;width: 18em;"><img class="img-fluid" src="{{ route('products.images.show', ['product' => $product->id, 'image' => $product->thumbnail()->getResults()->id]) }}" style="border-radius: 20px;">
                                <h3 class="name">{{ $product->name }}</h3>
                                <p class="description">{{ $product->description }}</p><strong class="d-flex d-lg-flex justify-content-center align-items-center justify-content-lg-center align-items-lg-center" style="padding-top: 0.5em;padding-bottom: 0.5em;">{{ $product->price }}€</strong>
                                <div class="btn-group" role="group" style="width: 12em;"><a class="btn btn-primary" type="button" href="{{ route('products.show', ['product' => $product->id]) }}"><i class="fa fa-info"></i></a></div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-sm-6 col-lg-4 mx-auto item">
                            No Products found.
                        </div>
                    @endif
                @else
                    <div class="col-sm-6 col-lg-4 mx-auto item">
                        No Products found.
                    </div>
                @endisset
            </div>
        </div>
    </section>
@endsection

@extends('layouts.app')

@section('content')
<main style="margin-right: 3em;margin-left: 3em;margin-top: 3em;border-radius: 31px;box-shadow: 20px 23px 20px rgb(204,204,204);border: 0.2em solid rgb(239,239,239) ;">
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row" style="margin: 2em;">
            <div class="col" style="border-right: 0.2em solid #eeeeee ;">
                <div class="row">
                    <div class="col">
                        <h3 style="font-family: Quicksand, sans-serif;">Produktbild</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col"><input class="form-control" type="file" name="images[]" multiple=""></div>
                </div>
                <div class="row">
                    <div class="col" style="margin-top: 2em;">
                        <select class="form-select" name="category" aria-label="Artikelkategorie" style="background: #1a7ae1;color:white;">
                            <option selected>Artikelkategorie&nbsp;&nbsp;<i class="fa fa-tags" style="font-size: 1em;"></i></option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col" style="border-right: 0.2em solid #eeeeee ;">
                <div class="row"><div class="group">
                    <input name="name" id="name" type="text" required>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label for="name">Name</label>
                </div>


            </div>
            <div class="row">
                <div class="group">
                    <input name="price" id="price" type="number" step="0.01" min="0" value="0" required>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Preis (€)</label>
                </div>
            </div>
            <div class="row">
                <div class="group">
                    <input name="sale" id="sale" type="number" step="0.1" min="0" value="0" required>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Rabatt (%)</label>
                </div>
            </div>
            <div class="row">
                <div class="group">
                    <input name="available" id="available" type="number" step="0.01" min="0" value="0" required>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Verfügbare anzahl</label>
                </div>
            </div>
                <div class="row">
                    <div class="col">
                        <h3 style="font-family: Quicksand, sans-serif;">Größen</h3>
                        <div class="row">
                            <div class="col-xl-8 d-xl-flex">
                                <p>Volumen (l)</p>
                            </div>
                            <div class="col-xl-4 d-xl-flex justify-content-xl-center align-items-xl-center">
                                    <div class="d-xl-flex justify-content-xl-center align-items-xl-center custom-control custom-radio" style="width: 2em;"><input class="d-xl-flex justify-content-xl-center align-items-xl-center custom-control-input" type="radio" id="size_type-2" name="size_type" value="volume" checked></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-8">
                                <p>Gewicht (kg)</p>
                            </div>
                            <div class="col-xl-4 d-xl-flex justify-content-xl-center align-items-xl-center">
                                <div class="d-xl-flex justify-content-xl-center align-items-xl-center custom-control custom-radio" style="width: 2em;"><input class="d-xl-flex justify-content-xl-center align-items-xl-center custom-control-input" type="radio" id="size_type-3" name="size_type" value="weight"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-xl-flex">
                                <p class="d-xl-flex">Kleidungsgröße (XS, S, M, X, XL)</p>
                            </div>
                            <div class="col-xl-4 d-xl-flex justify-content-xl-center align-items-xl-center">
                                <div class="custom-control custom-radio"><input class="d-flex justify-content-xl-center align-items-xl-center custom-control-input" type="radio" id="size_type-1" name="size_type" value="clothing" style="width: 2em;"></div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 2em;">
                            <div class="group" id="size-value-input">
                                <input type="number" name="size" required>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Größe</label>
                            </div>
                            <div class="group" id="clothe-size-input">
                                <div class="form-check">
                                    <input type="checkbox" name="size[]" id="clothe-size-1" class="form-check-input" value="XS">
                                    <label class="form-check-label" for="clothe-size-1">XS</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="size[]" id="clothe-size-2" value="S">
                                    <label class="form-check-label" for="clothe-size-2">S</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="size[]" id="clothe-size-3" value="M">
                                    <label class="form-check-label" for="clothe-size-3">M</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="size[]" id="clothe-size-4" value="L">
                                    <label class="form-check-label" for="clothe-size-4">L</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="size[]" id="clothe-size-5" value="XL">
                                    <label class="form-check-label" for="clothe-size-5">XL</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">
                        <h3 style="font-family: Quicksand, sans-serif;">Beschreibung</h3>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col"><textarea name="description" style="width: 100%;"></textarea></div>
                    </div>
                    <div class="col">
                        <input class="btn btn-primary" style="margin-top: 2em" type="submit" value="Speichern">
                    </div>
                </div>
            </div>
        </main>
    </main>
    <script>
        document.querySelectorAll('input[type="radio"][name="size_type"]').forEach(function (elem) {
            elem.addEventListener('change', function (e) {
                if (e.target.value == 'clothing') {
                    document.getElementById('size-value-input').style.display = 'none';
                    document.getElementById('clothe-size-input').style.display = 'block';
                } else {
                    document.getElementById('size-value-input').style.display = 'block';
                    document.getElementById('clothe-size-input').style.display = 'none';
                }
            });
            if (elem.value == 'clothing') {
                document.getElementById('size-value-input').style.display = 'none';
                document.getElementById('clothe-size-input').style.display = 'block';
            } else {
                document.getElementById('size-value-input').style.display = 'block';
                document.getElementById('clothe-size-input').style.display = 'none';
            }
        });
    </script>
@endsection

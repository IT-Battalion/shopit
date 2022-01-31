@extends('layouts.document")
@section('main-content')
    <div>
        <div class="flex flex-col mb-8">
                <h3 class="mb-3 text-xl font-medium underline decoration-solid">Zahlung</h3>
                <p>Bar</p>
            </div>
        <div>
            <h1 class="text-2xl font-semibold">Zahlungsbeleg</h1>
            <section class="mt-5">Lieber Max Mustermann, vielen Dank für Ihre Bestellung bei Shop-IT.</section>
            <section class="mt-5">
                Ihre Zahlung in Höhe von
                <span class="font-bold">30 Euro </span>
                für die
                <span class="font-bold">Rechnung Nr. 2523523523</span>
                haben wir erhalten und Ihrem Kundenkonto gutgeschrieben.
            </section>
            <section class="mt-5">
                Ihre Bestellung wird nun bearbeitet. Sie erhalten eine E-Mail sobald Sie diese bei uns Abholen können.
            </section>
            <section class="mt-5">
                ACHTUNG: Sie können Ihre Produkte erst abholen, nachdem Sie die E-Mail für die Abholung der produkte erhalten haben.
            </section>
        </div>
    </div>
@endsection

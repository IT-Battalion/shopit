@extends('layouts.invoice')
@section('main-content')
    <div>
        <div>
            <h3 class="underline decoration-solid">Zahlung</h3>
            <p>Bar</p>
        </div>
        <div>
            <h1>Zahlungsbeleg</h1>
            <section>Lieber Max Mustermann, vielen Dank für Ihre Bestellung bei Shop-IT.</section>
            <section>
                Ihre Zahlung in Höhe von
                <span class="font-bold">30 Euro </span>
                für die
                <span class="font-bold">Rechnung Nr. 2523523523</span>
                haben wir erhalten und Ihrem Kundenkonto gutgeschrieben.
            </section>
            <section>
                Ihre Bestellung wird nun bearbeitet. Sie erhalten eine E-Mail sobald Sie diese bei uns Abholen können.
            </section>
            <section>
                ACHTUNG: Sie können Ihre Produkte erst abholen, nachdem Sie die E-Mail für die Abholung der produkte erhalten haben.
            </section>
        </div>
    </div>
@endsection

@extends('layouts.invoice')
@section('main-content')
    <div class="flex flex-col">
        <div class="flex flex-col text-lg">
            <h1 class="mb-3 text-3xl font-bold">Rechnung</h1>
            <p>Lieber Max Mustermann,</p>
            <p>Vielen Dank für Ihre Bestellung bei Shop-IT.</p>
        </div>
        <div class="flex flex-row gap-20 my-16">
            <div class="flex flex-col">
                <h3 class="mb-3 text-xl font-medium underline decoration-solid">Abholadresse</h3>
                <p>Stefan Zakall</p>
                <p>Wexstraße 19-23</p>
                <p>Stockwerk 11, Raum H1124</p>
                <p>1200 Wien</p>
                <p>Österreich</p>
            </div>
            <div class="flex flex-col">
                <h3 class="mb-3 text-xl font-medium underline decoration-solid">Zahlung</h3>
                <p>Bar</p>
            </div>
        </div>
        <table class="text-center border border-collapse table-auto border-slate-500">
            <tr class="h-16 text-lg border border-collapse border-slate-500">
                <th>Artikel</th>
                <th>Größe</th>
                <th>Farbe</th>
                <th>Anzahl</th>
                <th>Betrag</th>
            </tr>
            <tr>
                <td>
                    <h4>Standard T-Shirt</h4>
                    <p>Artikelnummer: 21424242422241</p>
                </td>
                <td>
                    <h3>L</h3>
                </td>
                <td>
                    <h4>Schwarz</h4>
                </td>
                <td>
                    <h3>1</h3>
                </td>
                <td>
                   <span class="font-bold">9.99$</span>
                   <p>Einzelpreis: 9.99$</p>
                   <p>Coupon: 2.00$</p>
                </td>
            </tr>
        </table>
        <div class="grid grid-cols-2 grid-rows-1 px-5 bg-whiteHighlight">
            <div class="grid items-center grid-cols-2 grid-rows-2 my-3">
                <h3 class="col-start-1 text-xl justify-self-center">Eingelöste Coupons:</h3>
                <span class="col-start-1 row-start-2 p-3 bg-white justify-self-center">NAT-D23-KF4-M66</span>
                <span class="col-start-2 row-start-2 justify-self-start">10% auf alle Produkte</span>
            </div>
            <div class="grid grid-cols-1 grid-rows-3 my-3 mr-8 justify-self-end">
                <span>Versandkosten: 0.00$</span>
                <span>Coupon: 4.00$</span>
                <span class="font-semibold text-medium">Gesamtkosten: 19.99$</span>
            </div>
        </div>
        <p class="mt-5 text-sm text-center">Der Betrag enthält keine gesetzliche MWST. aufgrund der Begünstigung des Vereins gemäß BAO </p>
    </div>
@endsection

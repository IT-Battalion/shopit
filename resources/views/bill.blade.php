@extends('layouts.invoice')
@section('main-content')
    <div class="flex flex-col">
        <div class="flex flex-col">
            <h1>Rechnung</h1>
            <p>Lieber Max Mustermann,</p>
            <p>Vielen Dank für Ihre Bestellung bei Shop-IT.</p>
        </div>
        <div class="flex flex-row">
            <div class="flex flex-col">
                <h3 class="underline decoration-solid">Abholadresse</h3>
                <p>Stefan Zakall</p>
                <p>Wexstraße 19-23</p>
                <p>Stockwerk 11, Raum H1124</p>
                <p>1200 Wien</p>
                <p>Österreich</p>
            </div>
            <div class="flex flex-col">
                <h3 class="underline decoration-solid">Zahlung</h3>
                <p>Bar</p>
            </div>
        </div>
        <table>
            <tr>
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
    </div>
@endsection

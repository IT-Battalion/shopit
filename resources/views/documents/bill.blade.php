@extends('layouts.document')
@section('main-content')
    <div id="formData">
        <div id="greeting">
            <h1>Rechnung</h1>
            <p>Lieber Max Mustermann,</p>
            <p>Vielen Dank für Ihre Bestellung bei Shop-IT.</p>
        </div>
        <div id="adress">
            <div id="adressing">
                <h3>Abholadresse</h3>
                <p>Stefan Zakall</p>
                <p>Wexstraße 19-23</p>
                <p>Stockwerk 11, Raum H1124</p>
                <p>1200 Wien</p>
                <p>Österreich</p>
            </div>
            <div id="paymentMethod">
                <h3>Zahlung</h3>
                <p>Bar</p>
            </div>
        </div>
        <table id="priceTable">
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
                   <span>9.99$</span>
                   <p>Einzelpreis: 9.99$</p>
                   <p>Coupon: 2.00$</p>
                </td>
            </tr>
        </table>
        <div id="couponTable">
            <div id="coupon">
                <h3>Eingelöste Coupons:</h3>
                <span id="nat">NAT-D23-KF4-M66</span>
                <span id="productDiscount">10% auf alle Produkte</span>
            </div>
            <div id="costs">
                <span>Versandkosten: 0.00$</span>
                <span>Coupon: 4.00$</span>
                <span id="totalCost">Gesamtkosten: 19.99$</span>
            </div>
        </div>
        <p id="mwst">Der Betrag enthält keine gesetzliche MWST. aufgrund der Begünstigung des Vereins gemäß BAO </p>
    </div>
@endsection

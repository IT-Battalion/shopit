@extends('layouts.document')
@section('main-content')
    <table>
      <thead>
        <tr>
          <th>Artikel</th>
          <th>Größe</th>
          <th>Farbe</th>
          <th>Anzahl</th>
          <th>Betrag</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Standard T-Shirt<br>Artikelnummer: 1212121</td>
          <td>L</td>
          <td>Schwarz</td>
          <td>1</td>
          <td>9.99€<br>Einzelpreis: 9.99€<br>Coupon: 9.99€</td>
        </tr>
        <tr>
          <td>Standard T-Shirt<br>Artikelnummer: 1212121</td>
          <td>L</td>
          <td>Schwarz</td>
          <td>1</td>
          <td>9.99€<br>Einzelpreis: 9.99€<br>Coupon: 9.99€</td>
        </tr>
      </tbody>
    </table>

    <table id="total">
      <tbody>
        <tr>
          <td>Eingelöste Coupons:</td>
          <td></td>
          <td>Versandkosten:  10.00€</td>
        </tr>
        <tr>
          <td>NAt-D23-KF4-M66</td>
          <td></td>
          <td>Coupon:  4.00€</td>
        </tr>
        <tr>
          <td>10% auf alle Produkte</td>
          <td></td>
          <td style="font-weight: bold">Gesamtkosten:  19.99€</td>
        </tr>
      </tbody>
    </table>
@endsection

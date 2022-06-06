@extends('layouts.document')
@section('main-content')
    <table>
      <thead>
        <tr>
          <th>Description</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Website design</td>
          <td>€34.20</td>
          <td>100</td>
          <td>€3,420.00</td>
        </tr>
        <tr>
          <td>Website development</td>
          <td>€45.50</td>
          <td>100</td>
          <td>€4,550.00</td>
        </tr>
        <tr>
          <td>Website integration</td>
          <td>€25.75</td>
          <td>100</td>
          <td>€2,575.00</td>
        </tr>
      </tbody>
    </table>

    <table id="total">
      <thead>
        <tr>
          <th>Due by</th>
          <th>Account number</th>
          <th>Total due</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>May 10, 2018</td>
          <td>132 456 789 012</td>
          <td>€10,545.00</td>
        </tr>
      </tbody>
    </table>
@endsection

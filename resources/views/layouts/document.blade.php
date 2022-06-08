<!DOCTYPE html>
<html lang="de-at">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0,initial-scale=1.0, height=device-height">
    <title>ShopIT</title>
    <link rel="stylesheet" type="text/css" href="{{ public_path('css/vendor-pdf.css') }}">
    @yield('head-content')
</head>

<body>
    <img src="{{resource_path('assets/images/lernenImAufbruch.svg')}}" alt="Lernen im Aubfruch Logo">

    <aside>
      <address id="from">
        Lernen im Aufbruch
        Wexstraße 19-23, 1200 Wien
        ZVR-Nummer: 234235654
        ShopIT
      </address>

      <div id="pageNumber">
        Seite 1 von 2
      </div>
    </aside>

    <dl id="informations">
      <dt>Rechnugnsdatum</dt>
      <dd>10.10.2021</dd>
      <dt>Rechnungsnummer</dt>
      <dd>4353453</dd>
      <dt>Kundenummer</dt>
      <dd>5675467</dd>
      <dt>Bestellnummer</dt>
      <dd>213123</dd>
    </dl>
    @yield('main-content')
</body>

</html>

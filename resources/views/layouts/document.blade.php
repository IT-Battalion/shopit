<!DOCTYPE html>
<html lang="de-at">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0,initial-scale=1.0, height=device-height">
    <title>ShopIT</title>
    <link rel="stylesheet" type="text/css" href="{{ public_path('css/vendor-pdf.css') }}">
    <link rel="stylesheet" type="text/css" href="/css/vendor-pdf.css">
    @yield('head-content')
</head>

<body>
    <h1>Invoice</h1>

    <aside>
      <address id="from">
        WeasyPrint
        26 rue Emile Decorps
        69100 Villeurbanne
        France
      </address>

      <address id="to">
        Our awesome developers
        From all around the world
        Earth
      </address>
    </aside>

    <dl id="informations">
      <dt>Invoice number</dt>
      <dd>12345</dd>
      <dt>Date</dt>
      <dd>March 31, 2018</dd>
    </dl>
    @yield('main-content')
</body>

</html>

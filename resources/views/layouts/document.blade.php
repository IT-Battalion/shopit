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
    <div id="firstHeader">
        <div id="address">
            <h1>Lernen im Aufbruch</h1>
            <p>Wexstraße 19-23, 1200 Wien</p>
            <p>ZVR-Nummer: 1129819755</p>
            <img src="{{ resource_path('assets/images/logoBlack.svg') }}" alt="Logo ShopIT">
        </div>
        <img src="{{ resource_path('assets/images/lernenImAufbruch.svg') }}" alt="Logo Lernen im Aufbruch">
    </div>
    <div id="secondHeader">
        <div id="billData">
            <p>Rechnungsdaten: 10.10.2021</p>
            <p>Rechnungsnummer: 41414123</p>
            <p>Kundennummer 2312414</p>
            <p>Bestellnummer: 3522333</p>
        </div>
        <span>Seite 1 von 2</span>
    </div>
    @yield('main-content')
    <footer>
        <p>Ihre Bestellung wird von Lernen im Aufbruch abgewickelt und ist ihr Vertragspartner</p>
        <div id="footerContent">
            <div>
                <p>Wexstraße 19-23</p>
                <p>1200 Wien</p>
                <p>ZVR-Nummer: 1129819755</p>
            </div>
            <div>
                <p>Obmann:</p>
                <p>Mag. Dr. Christian Kruisz</p>
                <p>Obmann-Stv.:</p>
                <p>Mag. Lisa Vittori</p>
            </div>
            <div>
                <p>Email:</p>
                <a href="mailto:info@shopit.tgm.ac.at">info@shopit.tgm.ac.at</a>
                <a href="mailto:info@lernenImAufbruch.at">info@lernenImAufbruch.at</a>
            </div>
        </div>
    </footer>
</body>

</html>

<!DOCTYPE html>
<html lang="de-at">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0,initial-scale=1.0, height=device-height">
    <title>ShopIT</title>
    <link rel="stylesheet" type="text/css" href="/css/vendor.css">
    <style>
        html,
        body {
            background: rgb(30, 29, 43);
        }

    </style>
    @yield('head-content')
</head>

<body>
    <div class="grid grid-cols-2 grid-rows-2">
        <div class="flex flex-col justify-items-start">
            <h1>Lernen im Aufbruch</h1>
            <p>Wexstraße 19-23, 1200 Wien</p>
            <p>ZVR-Nummer: 1129819755</p>
            <img src="" alt="Logo ShopIT">
        </div>
        <img src="" alt="Logo Lernen im Aufbruch">
        <div class="flex flex-col justify-items-start">
            <p>Rechnungsdaten: 10.10.2021</p>
            <p>Rechnungsnummer: 41414123</p>
            <p>Kundennummer 2312414</p>
            <p>Bestellnummer: 3522333</p>
        </div>
    </div>
    @yield('main-content')
    <footer>
        <span class="w-5 bg-black rounded-full"/>
        <p>Ihre Bestellung wird von Lernen im Aufbruch abgewickelt und ist ihr Vertragspartner</p>
        <div class="grid grid-cols-3 grid-rows-1">
            <div class="flex flex-col">
                <p>Wexstraße 19-23</p>
                <p>1200 Wien</p>
                <p>ZVR-Nummer: 1129819755</p>
            </div>
            <div class="flex flex-col">
                <p>Obmann:</p>
                <p>Mag. Dr. Christian Kruisz</p>
                <p>Obmann-Stv.:</p>
                <p>Mag. Lisa Vittori</p>
            </div>
            <div class="flex flex-col">
                <p>Email:</p>
                <a href="mailto:info@shopit.tgm.ac.at">info@shopit.tgm.ac.at</a>
                <a href="mailto:info@lernenImAufbruch.at">info@lernenImAufbruch.at</a>
            </div>
        </div>
    </footer>
</body>

</html>

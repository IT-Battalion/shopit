<!DOCTYPE html>
<html lang="de-at">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0,initial-scale=1.0, height=device-height">
    <title>ShopIT</title>
    <link rel="stylesheet" type="text/css" href="/css/vendor.css">
    {{-- <style>
        html,
        body {
            background: rgb(30, 29, 43);
        }

    </style> --}}
    @yield('head-content')
</head>

<body class="p-16">
    <div class="grid items-center grid-cols-2 grid-rows-1">
        <div class="flex flex-col justify-items-start">
            <h1 class="mb-3 text-4xl font-bold">Lernen im Aufbruch</h1>
            <p>Wexstraße 19-23, 1200 Wien</p>
            <p>ZVR-Nummer: 1129819755</p>
            <img src="{{resource_path('assets/images/logoBlack.svg')}}" alt="Logo ShopIT" class="h-16">
        </div>
        <img src="{{resource_path('assets/images/lernenImAufbruch.svg')}}" alt="Logo Lernen im Aufbruch" class="justify-self-end">
    </div>
    <div class="grid items-center grid-cols-2 grid-rows-1">
        <div class="flex flex-col my-16 font-semibold justify-items-start">
            <p>Rechnungsdaten: 10.10.2021</p>
            <p>Rechnungsnummer: 41414123</p>
            <p>Kundennummer 2312414</p>
            <p>Bestellnummer: 3522333</p>
        </div>
        <span class="text-2xl justify-self-end">Seite 1 von 2</span>
    </div>
    @yield('main-content')
    <footer class="mt-16 font-medium border-t-4">
        <p class="my-8 text-center">Ihre Bestellung wird von Lernen im Aufbruch abgewickelt und ist ihr Vertragspartner</p>
        <div class="grid grid-cols-3 grid-rows-1 place-items-center">
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

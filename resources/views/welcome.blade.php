<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="antialiased">
    <x-guest-layout>
        <!-- component -->
        <div class="py-16">
            <div class="container m-auto px-6">

                <div class="lg:flex justify-between items-center">
                    <div class="lg:w-6/12 lg:p-0 p-7 bg-gray-200"
                    style="transform: scale(1) perspective(1040px) rotateY(21deg) rotateX(-2deg) rotate(-2deg);">
                        <h1 class="text-4xl font-bold leading-tight mb-5 capitalize px-4 py-4"> Smoothiemaker </h1>
                        <p class="text-xl px-4 py-4"> Stelle Dir jetzt deinen perfekten Smoothie zusammen! Deine Auswahl erstreckt
                            sich aus einer Vielzahl verschiedener Zutaten. Es gibt vier veschiedene Smoothie-Größen. Du
                            kannst entscheiden, ob dein Smoothie aus 250ml, 500ml, 750ml oder sogar 1l leckeren Zutaten
                            bestehen soll. Den Smoothie kannst du kostenlos und ohne Anmeldung zusammenstellen. Bei Kauf
                            errechnet sich der Preis deines Getränks aus den Einzelpreisen der Zutaten. </p>
                        <div class="px-4 py-4">
                            <button class="button-right greenbg"
                                onclick="window.location='{{ route('showBottleSizes') }}'">
                                Beginne mit der Zusammenstellung

                            </button>
                        </div>
                    </div>
                    <div class="lg:w-7/12 order-2">
                        <img src="/images/smoothie.jpg"
                            style="transform: scale(1) perspective(1040px) rotateY(-11deg) rotateX(2deg) rotate(2deg);"
                            alt="" class="rounded">
                    </div>
                </div>
            </div>
        </div>
    </x-guest-layout>
</body>

</html>
<script>
    sessionStorage.clear();
</script>

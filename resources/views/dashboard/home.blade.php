@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="rounded-lg bg-white p-6 shadow-sm">
        <h1 class="mb-6 text-2xl font-semibold text-gray-900">Test Case Full Stack Developer</h1>

        <section class="mb-8">
            <h2 class="mb-3 text-lg font-semibold text-gray-800">Introductie</h2>
            <p class="mb-3 text-gray-600">
                De case is zo opgezet dat er met een aantal uur een POC neergezet kan worden die de kennis naar voren brengt.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="mb-3 text-lg font-semibold text-gray-800">De case</h2>
            <p class="mb-3 text-gray-600">
                Voor een data-gedreven organisatie is het belangrijk dat grote hoeveelheden data overzichtelijk gepresenteerd
                worden. Dit project is een proof-of-concept van een interactief dashboard waarbij de frontend gevoed wordt
                vanuit de backend, en data wordt gevisualiseerd in een grafiek.</p>
        </section>

        <section class="mb-8">
            <h2 class="mb-3 text-lg font-semibold text-gray-800">Wat is er gebouwd</h2>
            <p class="mb-3 text-gray-600">
            Een fullstack webapplicatie met een weekoverzicht van omzetdata over de afgelopen 52 weken,
            inclusief filters en interactieve grafiek functionaliteit.
            </p>
        </section>
        <section class="mb-8">
            <h2 class="mb-3 text-lg font-semibold text-gray-800">Opbouw van de grafiek</h2>
            <ul class="list-inside list-disc space-y-2 text-gray-600">
                <li>Per week (tot maximaal 1 jaar terug) een bar met hierin basis omzet, en bonus omzet (door een promotie)</li>
                <li>De scheiding op de bar tussen basis en bonus moet zichtbaar zijn</li>
                <li>De bar moet on hover de basis en bonus omzet tonen</li>
                <li>De bar moet on click extra informatie tonen (x aantal producten)</li>
                <li>Qua filters de mogelijkheid om te kiezen voor enkel het tonen van de basis of enkel de bonus (en uiteraard ook samen in 1 bar)</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="mb-3 text-lg font-semibold text-gray-800">Welke data te gebruiken</h2>
            <p class="mb-3 text-gray-600">Als dummy data is het volgende gebruikt:</p>
            <ul class="list-inside list-disc space-y-2 text-gray-600">
                <li>Basis omzet: random tussen de 1 en 3 miljoen</li>
                <li>Bonus omzet: random tussen de 100.000 en 1.5 miljoen</li>
                <li>Product(en):
                    <ul class="ml-6 mt-1 list-inside list-disc">
                        <li>Coca Cola Regular 1.5L</li>
                        <li>Coca Cola Zero 1.5L</li>
                        <li>Fanta 1.5L</li>
                        <li>Fanta Zero Sugar 1.5L</li>
                        <li>Overige dummy producten</li>
                    </ul>
                </li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="mb-3 text-lg font-semibold text-gray-800">Tech stack</h2>
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <h3 class="mb-2 font-medium text-gray-700">Back-end:</h3>
                    <ul class="list-inside list-disc text-gray-600">
                        <li>Laravel</li>
                        <li>Livewire (optioneel)</li>
                    </ul>
                </div>
                <div>
                    <h3 class="mb-2 font-medium text-gray-700">Front-end:</h3>
                    <ul class="list-inside list-disc text-gray-600">
                        <li>TailwindCSS</li>
                        <li>AlpineJS</li>
                        <li>Highcharts</li>
                    </ul>
                </div>
            </div>
        </section>

        <section>
            <h2 class="mb-3 text-lg font-semibold text-gray-800">Styling / branding</h2>
            <ul class="list-inside list-disc space-y-1 text-gray-600">
                <li>Blauw: <code class="rounded bg-gray-100 px-1 text-[#325ff4]">#325ff4</code></li>
                <li>Grijstint: <code class="rounded bg-gray-100 px-1">#f1f5f9</code> (Tailwind slate-100)</li>
                <li>Icons: FontAwesome</li>
                <li>Lettertype: Inter</li>
            </ul>
        </section>
    </div>
@endsection

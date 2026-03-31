@extends('layouts.app')

@section('title', $product->name . ' — Prijstabel')

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('dashboard.index') }}" class="text-sm text-[#325ff4] hover:underline">
            &larr; Terug naar overzicht
        </a>
    </div>

    @include('dashboard.partials.product-nav', ['product' => $product, 'active' => 'priceTable'])

    <div class="rounded-lg bg-white p-6 shadow-sm">
        <h1 class="mb-4 text-2xl font-semibold text-gray-900">{{ $product->name }} — Prijstabel</h1>
        <p class="text-gray-500">Prijstabel wordt hier weergegeven.</p>
    </div>
@endsection

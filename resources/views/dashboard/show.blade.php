@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('dashboard.index') }}" class="text-sm text-[#325ff4] hover:underline">
            &larr; Terug naar overzicht
        </a>
    </div>

    @include('dashboard.partials.product-nav', ['product' => $product, 'active' => 'show'])

    <div class="rounded-lg bg-white p-6 shadow-sm">
        <div class="flex items-start gap-6">
            @if ($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="shrink-0 rounded-lg object-contain" style="max-width: 120px; max-height: 120px;">
            @else
                <div class="flex shrink-0 items-center justify-center rounded-lg bg-gray-100 text-sm text-gray-400" style="width: 80px; height: 80px;">—</div>
            @endif

            <div>
                <h1 class="text-2xl font-semibold text-gray-900">{{ $product->name }}</h1>
                <dl class="mt-3 grid grid-cols-2 gap-x-8 gap-y-2 text-sm">
                    <dt class="text-gray-500">Retailer</dt>
                    <dd class="text-gray-900">{{ $product->retailer }}</dd>
                    <dt class="text-gray-500">SKU</dt>
                    <dd class="text-gray-900">{{ $product->sku }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', $product->name . ' — ' . __('product.chart_title'))

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('dashboard.index') }}" class="text-sm text-[#325ff4] hover:underline">
            &larr; @lang('product.back_to_overview')
        </a>
    </div>

    @include('product.partials.nav', ['product' => $product, 'active' => 'productChart'])

    <div class="rounded-lg bg-white p-6 shadow-sm">
        <h1 class="mb-4 text-2xl font-semibold text-gray-900">{{ $product->name }} — @lang('product.chart_title')</h1>
        <p class="text-gray-500">@lang('product.chart_placeholder')</p>
    </div>
@endsection

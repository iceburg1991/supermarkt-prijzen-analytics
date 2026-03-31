{{-- Horizontal tab navigation for product detail pages --}}
<nav class="mb-6 flex gap-6 border-b border-gray-200 text-sm font-medium">
    <a href="{{ route('dashboard.productChart', $product) }}"
       class="border-b-2 pb-2 {{ ($active ?? '') === 'productChart' ? 'border-[#325ff4] text-[#325ff4]' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-900' }}">
        Grafiek
    </a>
    <a href="{{ route('dashboard.show', $product) }}"
       class="border-b-2 pb-2 {{ ($active ?? '') === 'show' ? 'border-[#325ff4] text-[#325ff4]' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-900' }}">
        Overzicht
    </a>
    <a href="{{ route('dashboard.priceTable', $product) }}"
       class="border-b-2 pb-2 {{ ($active ?? '') === 'priceTable' ? 'border-[#325ff4] text-[#325ff4]' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-900' }}">
        Prijstabel
    </a>
</nav>

@extends('layouts.warga')

@section('content')
<div class="mb-4">
    <h2 class="text-xl font-bold">Daftar Harga Referensi</h2>
    <p class="text-sm text-gray-500">Harga acuan per kilogram untuk setoran sampah.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-emerald-50 border-b border-gray-200">
                <th class="p-4 text-sm font-semibold text-gray-700">Jenis Sampah</th>
                <th class="p-4 text-sm font-semibold text-gray-700 text-right">Harga (Kg)</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($catalogs as $item)
            <tr class="hover:bg-gray-50">
                <td class="p-4 text-sm text-gray-700 font-medium">{{ $item->category_name }}</td>
                <td class="p-4 text-sm text-emerald-600 font-bold text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="p-4 text-center text-sm text-gray-500">Data harga belum tersedia.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
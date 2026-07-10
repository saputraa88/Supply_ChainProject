<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">
            Detail Negara
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto">

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">

                <!-- Header -->
                <div class="bg-blue-600 text-white p-6">

                    <div class="flex items-center space-x-5">

                        @if($country->flag)
    <img
        src="{{ $country->flag }}"
        alt="{{ $country->name }}"
        class="w-24 h-16 object-cover border rounded shadow"
        onerror="this.src='https://placehold.co/120x80?text=No+Flag'">
@else
    <img
        src="https://placehold.co/120x80?text=No+Flag"
        class="w-24 h-16 object-cover border rounded shadow">
@endif

                        <div>

                            <h1 class="text-4xl font-bold">
                                {{ $country->name }}
                            </h1>

                            <p class="text-blue-100 mt-2">
                                Kode Negara : {{ $country->code }}
                            </p>

                        </div>

                    </div>

                </div>

                <!-- Isi -->
                <div class="p-8">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="border rounded-lg p-4">

                            <h3 class="font-bold text-gray-700 mb-3">
                                Informasi Negara
                            </h3>

                            <table class="w-full">

                                <tr>
                                    <td class="py-2 font-semibold">Kode</td>
                                    <td>{{ $country->code }}</td>
                                </tr>

                                <tr>
                                    <td class="py-2 font-semibold">Ibu Kota</td>
                                    <td>{{ $country->capital ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td class="py-2 font-semibold">Region</td>
                                    <td>{{ $country->region ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td class="py-2 font-semibold">Mata Uang</td>
                                    <td>{{ $country->currency ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td class="py-2 font-semibold">Simbol</td>
                                    <td>{{ $country->currency_symbol ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td class="py-2 font-semibold">Populasi</td>
                                    <td>
                                        {{ number_format($country->population) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="py-2 font-semibold">Latitude</td>
                                    <td>{{ $country->latitude ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td class="py-2 font-semibold">Longitude</td>
                                    <td>{{ $country->longitude ?? '-' }}</td>
                                </tr>

                            </table>

                        </div>

                        <div class="border rounded-lg p-4">

                            <h3 class="font-bold text-gray-700 mb-4">
                                Bendera Negara
                            </h3>

                            @if($country->flag)
    <img
        src="{{ $country->flag }}"
        alt="{{ $country->name }}"
        class="w-full rounded-lg border shadow"
        onerror="this.src='https://placehold.co/600x350?text=No+Flag'">
@else
    <img
        src="https://placehold.co/600x350?text=No+Flag"
        class="w-full rounded-lg border shadow">
@endif

                        </div>

                    </div>

                    <div class="mt-8">

                        <a href="{{ route('countries.index') }}"
                           class="inline-block bg-gray-700 hover:bg-gray-800 text-white px-6 py-3 rounded-lg">

                            ← Kembali ke Daftar Negara

                        </a>

                    </div>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
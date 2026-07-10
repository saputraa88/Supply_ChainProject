<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Negara') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-lg p-6">

                <!-- Form Pencarian -->
                <form method="GET" action="{{ route('countries.index') }}" class="mb-6">
                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="🔍 Cari negara..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </form>

                <!-- Tabel -->
                <div class="overflow-x-auto">

                    <table class="min-w-full border border-gray-200">

                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="border px-4 py-3 text-center">
                                    Bendera
                                </th>

                                <th class="border px-4 py-3">
                                    Negara
                                </th>

                                <th class="border px-4 py-3">
                                    Kode
                                </th>

                                <th class="border px-4 py-3">
                                    Region
                                </th>

                                <th class="border px-4 py-3">
                                    Mata Uang
                                </th>

                                <th class="border px-4 py-3 text-center">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($countries as $country)

                                <tr class="hover:bg-gray-100">

                                    <!-- Bendera -->
                                    <td class="border px-4 py-3 text-center">

                                        @if($country->flag)

                                            <img
                                                src="{{ $country->flag }}"
                                                alt="{{ $country->name }}"
                                                width="40"
                                                height="30"
                                                loading="lazy"
                                                class="mx-auto border rounded"
                                                onerror="this.src='https://placehold.co/40x30?text=No';">

                                        @else

                                            -

                                        @endif

                                    </td>

                                    <!-- Nama -->
                                    <td class="border px-4 py-3">
                                        {{ $country->name }}
                                    </td>

                                    <!-- Kode -->
                                    <td class="border px-4 py-3">
                                        {{ $country->code }}
                                    </td>

                                    <!-- Region -->
                                    <td class="border px-4 py-3">
                                        {{ $country->region ?? '-' }}
                                    </td>

                                    <!-- Mata Uang -->
                                    <td class="border px-4 py-3">
                                        {{ $country->currency ?? '-' }}
                                    </td>

                                    <!-- Tombol Detail -->
                                    <td class="border px-4 py-3 text-center">

                                        <a href="{{ route('countries.show', $country) }}"
   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
    Detail
</a>

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6"
                                        class="border text-center py-6">

                                        Tidak ada data negara.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $countries->withQueryString()->links() }}
                </div>

            </div>

        </div>
    </div>

</x-app-layout>
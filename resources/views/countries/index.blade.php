<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Negara') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">
                        Daftar Negara
                    </h3>

                    <a href="{{ route('countries.create') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        + Tambah Negara
                    </a>
                </div>

                <table class="min-w-full border border-gray-200">

                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Nama</th>
                            <th class="border px-4 py-2">Kode</th>
                            <th class="border px-4 py-2">Region</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($countries as $country)

                        <tr>

                            <td class="border px-4 py-2">
                                {{ $loop->iteration }}
                            </td>

                            <td class="border px-4 py-2">
                                {{ $country->name }}
                            </td>

                            <td class="border px-4 py-2">
                                {{ $country->code }}
                            </td>

                            <td class="border px-4 py-2">
                                {{ $country->region }}
                            </td>

                            <td class="border px-4 py-2 space-x-2">

                                <a href="{{ route('countries.show',$country) }}"
                                   class="text-blue-600">
                                    Detail
                                </a>

                                <a href="{{ route('countries.edit',$country) }}"
                                   class="text-yellow-600">
                                    Edit
                                </a>

                                <form action="{{ route('countries.destroy',$country) }}"
                                      method="POST"
                                      class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Yakin ingin menghapus?')"
                                        class="text-red-600">

                                        Hapus

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5"
                                class="text-center border px-4 py-4">

                                Belum ada data negara.

                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

                <div class="mt-4">
                    {{ $countries->links() }}
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
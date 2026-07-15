<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Intelijen Negara & Logistik') }}
        </h2>
    </x-slot>

    <div style="padding: 32px 0; background-color: #f3f4f6; min-height: 85vh; font-family: 'Inter', system-ui, -apple-system, sans-serif;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 24px;">
            
            @if(session('success'))
                <div style="background-color: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; padding: 14px 20px; border-radius: 8px; margin-bottom: 24px; font-weight: 600; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); padding: 28px;">

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; flex-wrap: wrap; gap: 16px;">
                    
                    <form method="GET" action="{{ route('countries.index') }}" style="flex: 1; min-width: 300px; margin: 0;">
                        <div style="display: flex; gap: 12px;">
                            <input
                                type="text"
                                name="search"
                                value="{{ $search }}"
                                placeholder="🔍 Cari berdasarkan nama negara atau kode (Contoh: Afghanistan, AF)..."
                                style="flex: 1; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px 18px; font-size: 15px; outline: none; transition: border-color 0.2s; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);"
                                onfocus="this.style.borderColor='#2563eb';"
                                onblur="this.style.borderColor='#d1d5db';"
                            >
                            <button type="submit" style="background-color: #2563eb; color: white; border: none; border-radius: 8px; padding: 0 24px; font-weight: 600; cursor: pointer; font-size: 15px; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor='#2563eb'">
                                Cari
                            </button>
                        </div>
                    </form>

                    <a href="{{ route('countries.syncAll') }}" 
                       style="background-color: #10b981; color: white; border: none; border-radius: 8px; padding: 13px 22px; font-weight: bold; cursor: pointer; font-size: 14px; text-decoration: none; transition: background-color 0.2s; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);" 
                       onmouseover="this.style.backgroundColor='#059669'" 
                       onmouseout="this.style.backgroundColor='#10b981'">
                        🔄 Sinkronisasi Massal (API)
                    </a>

                </div>

                <div style="overflow-x: auto; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <table style="width: 100%; border-collapse: collapse; background-color: white;">
                        <thead>
                            <tr style="background-color: #1e3a8a; color: #ffffff; font-size: 14px; text-transform: uppercase; letter-spacing: 0.05em;">
                                <th style="padding: 14px 16px; text-align: center; width: 90px; border-bottom: 2px solid #1d4ed8;">Bendera</th>
                                <th style="padding: 14px 16px; text-align: left; border-bottom: 2px solid #1d4ed8;">Nama Negara</th>
                                <th style="padding: 14px 16px; text-align: left; width: 100px; border-bottom: 2px solid #1d4ed8;">Kode</th>
                                <th style="padding: 14px 16px; text-align: left; border-bottom: 2px solid #1d4ed8;">Region</th>
                                <th style="padding: 14px 16px; text-align: left; border-bottom: 2px solid #1d4ed8;">Mata Uang</th>
                                <th style="padding: 14px 16px; text-align: center; width: 120px; border-bottom: 2px solid #1d4ed8;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 15px; color: #374151;">
                            @php
                                // Kamus data lokal cadangan agar halaman index tidak kosong saat offline
                                $localIndexData = [
                                    'af' => ['region' => 'Asia', 'curr' => 'Afghan afghani', 'sym' => '؋'],
                                    'id' => ['region' => 'Asia', 'curr' => 'Indonesian rupiah', 'sym' => 'Rp'],
                                    'us' => ['region' => 'Americas', 'curr' => 'United States dollar', 'sym' => '$'],
                                    'cn' => ['region' => 'Asia', 'curr' => 'Renminbi', 'sym' => '¥'],
                                    'de' => ['region' => 'Europe', 'curr' => 'Euro', 'sym' => '€'],
                                    'au' => ['region' => 'Oceania', 'curr' => 'Australian dollar', 'sym' => '$'],
                                    'sg' => ['region' => 'Asia', 'curr' => 'Singapore dollar', 'sym' => '$'],
                                    'my' => ['region' => 'Asia', 'curr' => 'Malaysian ringgit', 'sym' => 'RM'],
                                    'jp' => ['region' => 'Asia', 'curr' => 'Japanese yen', 'sym' => '¥'],
                                    
                                    // Backup tambahan wilayah halaman pertama Anda
                                    'al' => ['region' => 'Europe', 'curr' => 'Albanian lek', 'sym' => 'Lek'],
                                    'dz' => ['region' => 'Africa', 'curr' => 'Algerian dinar', 'sym' => 'DA'],
                                    'ax' => ['region' => 'Europe', 'curr' => 'Euro', 'sym' => '€'],
                                    'ad' => ['region' => 'Europe', 'curr' => 'Euro', 'sym' => '€'],
                                    'ao' => ['region' => 'Africa', 'curr' => 'Angolan kwanza', 'sym' => 'Kz'],
                                    'ai' => ['region' => 'Americas', 'curr' => 'East Caribbean dollar', 'sym' => '$'],
                                    'aq' => ['region' => 'Antarctic', 'curr' => 'Antarctic Currency', 'sym' => '¤'],
                                    'as' => ['region' => 'Oceania', 'curr' => 'US Dollar', 'sym' => '$'],
                                    'wsb' => ['region' => 'Europe', 'curr' => 'Euro', 'sym' => '€'],
                                ];
                            @endphp

                            @forelse($countries as $index => $country)
                                @php
                                    $codeClean = trim(strtolower($country->code));
                                    
                                    // PRIORITAS UTAMA: Gunakan database. JIKA data di database kosong / default, pakai Kamus Cadangan
                                    $displayRegion = (!empty($country->region) && $country->region !== '-' && $country->region !== 'Global Area') 
                                        ? $country->region 
                                        : ($localIndexData[$codeClean]['region'] ?? 'Global Area');

                                    $displayCurrency = (!empty($country->currency) && $country->currency !== 'Local Currency') 
                                        ? $country->currency 
                                        : ($localIndexData[$codeClean]['curr'] ?? 'Local Currency');

                                    $displaySymbol = $localIndexData[$codeClean]['sym'] ?? '';
                                    
                                    // Efek warna selang-seling (zebra striping) pada baris tabel
                                    $rowBg = ($index % 2 == 0) ? '#ffffff' : '#f8fafc';
                                @endphp
                                <tr style="background-color: {{ $rowBg }}; border-bottom: 1px solid #e5e7eb; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#f1f5f9'" onmouseout="this.style.backgroundColor='{{ $rowBg }}'">
                                    
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <img
                                            src="https://flagcdn.com/w40/{{ $codeClean }}.png"
                                            alt="{{ $country->name }}"
                                            width="40"
                                            style="margin: 0 auto; border: 1px solid #cbd5e1; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"
                                            onerror="this.src='https://placehold.co/40x30?text=No';">
                                    </td>

                                    <td style="padding: 12px 16px; font-weight: 600; color: #1e293b;">
                                        {{ $country->name }}
                                    </td>

                                    <td style="padding: 12px 16px;">
                                        <span style="background-color: #dbeafe; color: #1e40af; font-weight: 700; padding: 4px 8px; border-radius: 6px; font-size: 12px; text-transform: uppercase; font-family: monospace; border: 1px solid #bfdbfe;">
                                            {{ $country->code }}
                                        </span>
                                    </td>

                                    <td style="padding: 12px 16px; color: #475569; font-weight: 500;">
                                        {{ $displayRegion }}
                                    </td>

                                    <td style="padding: 12px 16px; color: #475569;">
                                        {{ $displayCurrency }} 
                                        @if($displaySymbol) 
                                            <span style="background-color: #f1f5f9; color: #0f172a; font-weight: 600; padding: 2px 6px; border-radius: 4px; font-size: 13px; margin-left: 4px; border: 1px solid #e2e8f0;">
                                                {{ $displaySymbol }}
                                            </span>
                                        @endif
                                    </td>

                                    <td style="padding: 12px 16px; text-align: center;">
                                        <a href="{{ url('/countries/' . $country->id) }}"
                                           style="display: inline-block; background-color: #2563eb; color: #ffffff; font-size: 13px; font-weight: 600; padding: 8px 16px; border-radius: 6px; text-decoration: none; box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2); transition: all 0.2s;"
                                           onmouseover="this.style.backgroundColor='#1d4ed8'; this.style.boxShadow='0 4px 6px rgba(29, 78, 216, 0.3)';"
                                           onmouseout="this.style.backgroundColor='#2563eb'; this.style.boxShadow='0 2px 4px rgba(37, 99, 235, 0.2)';">
                                            📊 Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 32px; color: #64748b; font-style: italic; background-color: #f8fafc;">
                                        🔍 Tidak ada data negara yang cocok dengan pencarian.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 24px; display: flex; justify-content: center;">
                    {{ $countries->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
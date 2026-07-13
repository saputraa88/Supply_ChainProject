<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Intelijen Geopolitik Negara') }}
            </h2>
            <a href="{{ route('countries.index') }}" style="color: #4b5563; font-weight: 600; text-decoration: none; font-size: 14px;">← Kembali ke Daftar</a>
        </div>
    </x-slot>

    <div style="padding: 40px 0; background-color: #f3f4f6; min-height: 85vh; font-family: 'Inter', sans-serif;">
        <div style="max-width: 1140px; margin: 0 auto; padding: 0 20px;">
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 32px;">
                
                <div style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 32px;">
                    <span style="background-color: #eff6ff; color: #2563eb; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 6px; text-transform: uppercase;">
                        KODE: {{ $country->code }}
                    </span>
                    
                    <h3 style="font-size: 32px; font-weight: 800; color: #111827; margin: 12px 0 20px 0;">{{ $country->name }}</h3>
                    
                    <div style="margin-bottom: 28px;">
                        <form action="{{ route('watchlist.toggle', $country->id) }}" method="POST">
                            @csrf
                            @if(auth()->user()->watchlistCountries && auth()->user()->watchlistCountries->contains($country->id))
                                <button type="submit" style="background-color: #ef4444; color: white; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; border: none; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#dc2626'" onmouseout="this.style.backgroundColor='#ef4444'">
                                    📌 Hapus dari Daftar Pantau
                                </button>
                            @else
                                <button type="submit" style="background-color: #2563eb; color: white; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; border: none; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor='#2563eb'">
                                    ⭐ Tambah ke Daftar Pantau
                                </button>
                            @endif
                        </form>
                    </div>

                    <div style="font-size: 14px; color: #374151;">
                        <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f3f4f6;">
                            <span style="color: #6b7280; font-weight: 500;">Ibu Kota</span>
                            <span style="font-weight: 600; color: #111827;">{{ $country->capital ?? '-' }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f3f4f6;">
                            <span style="color: #6b7280; font-weight: 500;">Wilayah / Region</span>
                            <span style="font-weight: 600; color: #111827;">{{ $region }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f3f4f6;">
                            <span style="color: #6b7280; font-weight: 500;">Mata Uang</span>
                            <span style="font-weight: 600; color: #111827;">{{ $currencyName }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f3f4f6;">
                            <span style="color: #6b7280; font-weight: 500;">Simbol Kurs</span>
                            <span style="font-weight: 600; color: #111827; background-color: #f3f4f6; padding: 2px 8px; border-radius: 4px;">{{ $currencySymbol }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f3f4f6;">
                            <span style="color: #6b7280; font-weight: 500;">Estimasi Populasi</span>
                            <span style="font-weight: 600; color: #111827;">👥 {{ $population }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f3f4f6;">
                            <span style="color: #6b7280; font-weight: 500;">Garis Lintang (Lat)</span>
                            <span style="font-weight: 600; color: #4b5563;">{{ $country->latitude ?? '-' }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 12px 0;">
                            <span style="color: #6b7280; font-weight: 500;">Garis Bujur (Lng)</span>
                            <span style="font-weight: 600; color: #4b5563;">{{ $country->longitude ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 32px;">
                    
                    <div style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 28px; text-align: center;">
                        <h4 style="font-size: 12px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px; text-align: left;">
                            Bendera Resmi Negara
                        </h4>
                        @if($flagUrl)
                            <img src="{{ $flagUrl }}" alt="Bendera {{ $country->name }}" style="max-width: 80%; height: auto; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); margin: 0 auto; border: 1px solid #e5e7eb;">
                        @else
                            <div style="padding: 40px; background-color: #f3f4f6; border-radius: 8px; color: #9ca3af; font-size: 14px;">
                                Bendera tidak tersedia
                            </div>
                        @endif
                    </div>

                    <div style="background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%); border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.3); padding: 28px; color: #ffffff;">
                        <h4 style="font-size: 12px; font-weight: 700; color: #bae6fd; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px;">
                            🌤️ Live Weather Indicator
                        </h4>
                        
                        @if($weatherData)
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 16px;">
                                <div>
                                    <div style="font-size: 48px; font-weight: 900; letter-spacing: -0.05em; line-height: 1;">
                                        {{ $weatherData['temperature'] }}°C
                                    </div>
                                    <p style="font-size: 13px; color: #e0f2fe; margin: 8px 0 0 0; font-weight: 500;">
                                        Kecepatan Angin: 💨 {{ $weatherData['windspeed'] }} km/h
                                    </p>
                                </div>
                                <div style="font-size: 54px;">
                                    {{-- Mengubah icon cuaca berdasarkan temperatur sederhana --}}
                                    @if($weatherData['temperature'] > 28) ☀️ @elseif($weatherData['temperature'] > 18) ⛅ @else 🌧️ @endif
                                </div>
                            </div>
                            <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.2); font-size: 12px; color: #e0f2fe;">
                                Data cuaca maritim diperbarui otomatis melalui sistem satelit radar Open-Meteo.
                            </div>
                        @else
                            <div style="padding: 20px 0; color: #e0f2fe; font-size: 14px; text-align: center;">
                                🛰️ Koordinat cuaca logistik tidak terjangkau atau lat/lng belum diatur.
                            </div>
                        @endif
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pemantauan Logistik & Supply Chain') }}
        </h2>
    </x-slot>

    <div style="padding: 40px 0; background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); min-height: 85vh; font-family: 'Inter', sans-serif;">
        <div style="max-width: 1140px; margin: 0 auto; padding: 0 20px;">
            
            <div style="background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%); border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.3); padding: 32px; margin-bottom: 32px; color: #ffffff; position: relative; overflow: hidden;">
                <div style="position: absolute; right: -50px; top: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.03); border-radius: 50%;"></div>
                
                <span style="background-color: rgba(59, 130, 246, 0.4); color: #93c5fd; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; padding: 6px 12px; border-radius: 9999px; display: inline-block; margin-bottom: 12px;">
                    Control Tower Active
                </span>
                <h3 style="font-size: 24px; font-weight: 800; margin: 0 0 8px 0; letter-spacing: -0.025em;">
                    Selamat Datang Kembali, <span style="color: #60a5fa; text-transform: capitalize;">{{ auth()->user()->name }}</span>!
                </h3>
                <p style="font-size: 14px; color: #cbd5e1; max-width: 700px; margin: 0; line-height: 1.6;">
                    Sistem visualisasi distribusi global siap dikendalikan. Gunakan panel instrumen di bawah untuk memantau gerbang perimeter maritim dan wilayah kedaulatan logistik Anda.
                </p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 32px;">
                
                <div style="background-color: #ffffff; padding: 28px; border-radius: 16px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05), 0 4px 6px -2px rgba(0,0,0,0.05); border-top: 5px solid #2563eb; transition: transform 0.2s, box-shadow 0.2s; display: flex; flex-direction: column; justify-content: space-between;"
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 20px 25px -5px rgba(37,99,235,0.1)'"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.05)'">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                            <span style="font-size: 13px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Negara Dipantau</span>
                            <span style="font-size: 24px; background-color: #eff6ff; padding: 8px; border-radius: 12px;">⭐</span>
                        </div>
                        <div style="font-size: 44px; font-weight: 900; color: #1e3a8a; margin: 0 0 4px 0; letter-spacing: -0.05em;">
                            {{ $totalWatchlist }}
                        </div>
                        <p style="font-size: 13px; color: #9ca3af; margin: 0 0 20px 0;">Wilayah geopolitik aktif dalam pengawasan khusus.</p>
                    </div>
                    <a href="{{ route('watchlist.index') }}" style="display: inline-flex; align-items: center; justify-content: center; background-color: #eff6ff; color: #2563eb; font-size: 13px; font-weight: 700; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: background 0.2s;"
                       onmouseover="this.style.backgroundColor='#dbeafe'"
                       onmouseout="this.style.backgroundColor='#eff6ff'">
                        Buka Radar Pantau →
                    </a>
                </div>

                <div style="background-color: #ffffff; padding: 28px; border-radius: 16px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05), 0 4px 6px -2px rgba(0,0,0,0.05); border-top: 5px solid #10b981; transition: transform 0.2s, box-shadow 0.2s; display: flex; flex-direction: column; justify-content: space-between;"
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 20px 25px -5px rgba(16,185,129,0.1)'"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.05)'">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                            <span style="font-size: 13px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Total Pelabuhan</span>
                            <span style="font-size: 24px; background-color: #ecfdf5; padding: 8px; border-radius: 12px;">⚓</span>
                        </div>
                        <div style="font-size: 44px; font-weight: 900; color: #065f46; margin: 0 0 4px 0; letter-spacing: -0.05em;">
                            {{ $totalPorts }}
                        </div>
                        <p style="font-size: 13px; color: #9ca3af; margin: 0 0 20px 0;">Titik jangkar infrastruktur maritim terdaftar.</p>
                    </div>
                    <a href="{{ route('ports.index') }}" style="display: inline-flex; align-items: center; justify-content: center; background-color: #ecfdf5; color: #10b981; font-size: 13px; font-weight: 700; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: background 0.2s;"
                       onmouseover="this.style.backgroundColor='#d1fae5'"
                       onmouseout="this.style.backgroundColor='#ecfdf5'">
                        Kelola Infrastruktur →
                    </a>
                </div>

            </div>

            <div style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 24px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 20px; background-color: #f3f4f6; padding: 8px; border-radius: 8px;">🌐</span>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 700; color: #111827; margin: 0;">Eksplorasi Basis Data Wilayah</h4>
                        <p style="font-size: 12px; color: #6b7280; margin: 0;">Cari informasi kode negara, koordinat, dan populasi dunia.</p>
                    </div>
                </div>
                <a href="{{ route('countries.index') }}" style="background-color: #4b5563; color: #ffffff; font-size: 13px; font-weight: 600; padding: 10px 20px; border-radius: 8px; text-decoration: none; transition: background 0.2s;"
                   onmouseover="this.style.backgroundColor='#374151'"
                   onmouseout="this.style.backgroundColor='#4b5563'">
                    Jelajahi Negara
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
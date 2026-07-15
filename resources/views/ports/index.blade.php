<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('⚓ Manajemen Infrastruktur Pelabuhan (Ports)') }}
            </h2>
            <a href="{{ route('ports.create') }}" style="background-color: #2563eb; color: #ffffff; padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; transition: background 0.2s;"
               onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor='#2563eb'">
                + Registrasi Pelabuhan
            </a>
        </div>
    </x-slot>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <div style="padding: 40px 0; background-color: #f3f4f6; min-height: 85vh;">
        <div style="max-width: 1024px; margin: 0 auto; padding: 0 20px;">

            @if(session('success'))
                <div style="background-color: #ecfdf5; border-left: 4px solid #10b981; color: #065f46; padding: 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px; font-weight: 500;">
                    🎉 {{ session('success') }}
                </div>
            @endif

            <div style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 24px; margin-bottom: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #111827; margin: 0;">🗺️ Peta Lokasi Pelabuhan Dunia</h3>
                    
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <input type="text" id="mapSearch" placeholder="Cari pelabuhan / kode..." 
                               style="border: 1px solid #d1d5db; border-radius: 8px; padding: 6px 12px; font-size: 14px; outline: none; width: 200px;">
                        
                        <select id="mapCountryFilter" style="border: 1px solid #d1d5db; border-radius: 8px; padding: 6px 12px; font-size: 14px; outline: none; background-color: #ffffff; width: 180px;">
                            <option value="">Semua Negara</option>
                            @isset($countries)
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                        
                        <button onclick="loadMapMarkers()" style="background-color: #2563eb; color: #ffffff; border: none; padding: 6px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: background 0.2s;"
                                onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor='#2563eb'">
                            Cari
                        </button>
                    </div>
                </div>

                <div id="portMap" style="height: 380px; border-radius: 12px; border: 1px solid #e5e7eb; z-index: 1;"></div>
            </div>

            <div style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 24px;">
                
                @if($ports->isEmpty())
                    <div style="text-align: center; padding: 40px 20px; color: #6b7280;">
                        <span style="font-size: 48px; display: block; margin-bottom: 16px;">⚓</span>
                        <h3 style="font-size: 16px; font-weight: 700; color: #111827; margin-bottom: 4px;">Belum Ada Pelabuhan Terdaftar</h3>
                        <p style="font-size: 14px; margin-bottom: 16px;">Basis data infrastruktur maritim saat ini masih kosong.</p>
                        <a href="{{ route('ports.create') }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">Mulai tambahkan pelabuhan pertama →</a>
                    </div>
                @else
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                            <thead>
                                <tr style="border-bottom: 2px solid #e5e7eb; color: #4b5563; font-weight: 700;">
                                    <th style="padding: 12px 16px;">Nama Pelabuhan</th>
                                    <th style="padding: 12px 16px;">Kode Protokol</th>
                                    <th style="padding: 12px 16px;">Negara Kedaulatan</th>
                                    <th style="padding: 12px 16px; text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ports as $port)
                                    <tr style="border-bottom: 1px solid #f3f4f6; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#f9fafb'" onmouseout="this.style.backgroundColor='transparent'">
                                        <td style="padding: 16px; font-weight: 600; color: #111827;">{{ $port->name }}</td>
                                        <td style="padding: 16px; color: #4b5563;"><code style="background-color: #f3f4f6; padding: 4px 8px; border-radius: 4px;">{{ $port->code ?? '-' }}</code></td>
                                        <td style="padding: 16px; color: #111827;">
                                            {{ $port->country->name ?? 'Tidak Diketahui' }}
                                        </td>
                                        <td style="padding: 16px; text-align: center;">
                                            <form action="{{ route('ports.destroy', $port->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus infrastruktur pelabuhan ini?');" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="color: #ef4444; background: none; border: none; font-weight: 600; cursor: pointer; font-size: 13px;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <script>
        // 1. Inisialisasi Peta Dunia (Fokus default tengah-tengah ekuator / wilayah Indonesia)
        var map = L.map('portMap').setView([5.0, 115.0], 3);

        // Menggunakan OpenStreetMap gratis
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Group Layer untuk menampung marker agar bisa dihapus-tulis ulang saat pencarian dilakukan
        var markersLayer = L.layerGroup().addTo(map);

        /**
         * FUNGSI DECODER DMS KE DESIMAL:
         * Mengubah teks koordinat derajat di database (misal: "6 05 S" atau "106 53 E")
         * menjadi format angka desimal murni (float) agar dikenali oleh Leaflet.js.
         */
        function parseDMSToDecimal(dmsStr) {
            if (!dmsStr) return null;
            
            // Hapus spasi berlebih di awal/akhir dan ubah spasi ganda menjadi tunggal
            var str = dmsStr.trim().replace(/\s+/g, ' ');
            
            // Jika data di DB sudah berupa angka desimal murni, langsung kembalikan float
            if (!isNaN(str)) return parseFloat(str);
            
            var parts = str.split(' ');
            
            if (parts.length >= 2) {
                var degrees = parseFloat(parts[0]) || 0;
                var minutes = parseFloat(parts[1]) || 0;
                var seconds = 0;
                
                // Ambil karakter terakhir untuk menentukan arah mata angin (N, S, E, W)
                var lastPart = parts[parts.length - 1].toUpperCase();
                var hasDirection = ['N', 'S', 'E', 'W'].includes(lastPart);
                var direction = hasDirection ? lastPart : null;

                // Hitung detik jika formatnya lengkap (cth: "51 45 30 S")
                if (hasDirection && parts.length === 4) {
                    seconds = parseFloat(parts[2]) || 0;
                } else if (!hasDirection && parts.length === 3) {
                    seconds = parseFloat(parts[2]) || 0;
                }

                // Kalkulasi ke desimal murni
                var decimal = degrees + (minutes / 60) + (seconds / 3600);
                
                // Jika arahnya Selatan (S) atau Barat (W), nilainya wajib negatif (-)
                if (direction === 'S' || direction === 'W') {
                    decimal = -decimal;
                }
                return decimal;
            }
            
            return parseFloat(str);
        }

        /**
         * Mengambil data koordinat pelabuhan dari API dan me-render marker interaktif ke peta
         */
        function loadMapMarkers() {
            var search = document.getElementById('mapSearch').value;
            var countryId = document.getElementById('mapCountryFilter').value;

            // Hapus semua marker lama sebelum memuat yang baru
            markersLayer.clearLayers();

            // Panggil REST API internal yang mengarah ke controller Anda
            var url = `/api/ports?search=${encodeURIComponent(search)}&country_id=${encodeURIComponent(countryId)}`;

            fetch(url)
                .then(response => response.json())
                .then(ports => {
                    var bounds = [];

                    ports.forEach(port => {
                        // Terjemahkan koordinat teks dari DB ke koordinat desimal Leaflet
                        var lat = parseDMSToDecimal(port.latitude);
                        var lng = parseDMSToDecimal(port.longitude);

                        // Pastikan koordinat hasil terjemahan valid sebelum di-render
                        if (lat !== null && lng !== null && !isNaN(lat) && !isNaN(lng)) {
                            
                            // Konten Popup info pelabuhan saat marker di-klik
                            var popupContent = `
                                <div style="font-family: Arial, sans-serif; font-size: 12px; line-height: 1.4; min-width: 160px;">
                                    <h4 style="margin: 0 0 6px; color: #111827; font-weight: 700; font-size: 13px;">⚓ ${port.name}</h4>
                                    <div style="border-top: 1px solid #e5e7eb; padding-top: 6px;">
                                        <p style="margin: 0 0 4px; color: #4b5563;"><b>Kode:</b> <code style="background-color: #f3f4f6; padding: 2px 4px; border-radius: 4px;">${port.code || '-'}</code></p>
                                        <p style="margin: 0 0 4px; color: #4b5563;"><b>Negara:</b> ${port.country ? port.country.name : 'Tidak Diketahui'}</p>
                                        <p style="margin: 0; color: #2563eb; font-size: 11px;">📍 ${lat.toFixed(5)}, ${lng.toFixed(5)}</p>
                                    </div>
                                </div>
                            `;

                            var marker = L.marker([lat, lng]).bindPopup(popupContent);
                            
                            markersLayer.addLayer(marker);
                            bounds.push([lat, lng]);
                        }
                    });

                    // LOGIKA SMART ZOOM & TRANSISI MAP:
                    if (bounds.length === 1) {
                        // JIKA HANYA ADA 1 HASIL: Gunakan .flyTo agar peta bergeser dengan animasi mulus dan zoom level dekat (12)
                        map.flyTo(bounds[0], 12, {
                            animate: true,
                            duration: 1.5 // Durasi animasi pergeseran dalam detik
                        });
                    } else if (bounds.length > 1) {
                        // JIKA ADA BANYAK HASIL: Sesuaikan area layar (fitBounds) agar semua marker terlihat bersamaan
                        map.fitBounds(bounds, { padding: [50, 50] });
                    } else {
                        // RESET PETA: Jika hasil pencarian kosong, kembalikan posisi peta ke default dunia
                        map.setView([5.0, 115.0], 3); 
                    }
                })
                .catch(err => console.error('Gagal memuat data API Pelabuhan:', err));
        }

        // Peta langsung memuat semua marker pelabuhan saat halaman pertama kali dibuka
        document.addEventListener('DOMContentLoaded', function() {
            loadMapMarkers();
        });
    </script>
</x-app-layout>
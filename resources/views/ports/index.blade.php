<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="font-family: system-ui, sans-serif; display: flex; align-items: center; gap: 8px; margin: 0;">
                <span style="font-size: 1.35rem;">⚓</span> {{ __('Manajemen Infrastruktur Pelabuhan') }}
            </h2>
            <a href="{{ route('ports.create') }}" 
               style="background-color: #2563eb; color: #ffffff; padding: 10px 20px; border-radius: 10px; font-size: 14px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); transition: all 0.2s ease;"
               onmouseover="this.style.backgroundColor='#1d4ed8'; this.style.transform='translateY(-1px)';" 
               onmouseout="this.style.backgroundColor='#2563eb'; this.style.transform='none';">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="display: inline;">
                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                </svg>
                Registrasi Pelabuhan
            </a>
        </div>
    </x-slot>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .custom-card {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.02), 0 4px 6px -2px rgba(0,0,0,0.02);
            border: 1px solid #f1f5f9;
            padding: 24px;
            margin-bottom: 24px;
            transition: transform 0.3s ease;
        }
        .filter-input {
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 8px 14px;
            font-size: 14px;
            outline: none;
            transition: all 0.2s ease;
            width: 210px;
            background-color: #f8fafc;
        }
        .filter-input:focus {
            border-color: #3b82f6;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }
        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            text-align: left;
            font-size: 14px;
        }
        .modern-table th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            padding: 14px 16px;
            border-bottom: 2px solid #e2e8f0;
        }
        .modern-table td {
            padding: 16px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
        }
        .modern-table tr {
            transition: all 0.2s;
        }
        .modern-table tr:hover {
            background-color: #f8fafc;
        }
        .badge-locode {
            background-color: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            padding: 4px 10px;
            border-radius: 9999px;
            font-family: monospace;
            font-weight: 700;
            font-size: 12px;
        }
        .btn-focus {
            color: #3b82f6;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-focus:hover {
            background-color: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.2);
        }
        .btn-delete {
            color: #ef4444;
            background: #fef2f2;
            border: 1px solid #fecaca;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-delete:hover {
            background-color: #ef4444;
            color: #ffffff;
            border-color: #ef4444;
            box-shadow: 0 4px 8px rgba(239, 68, 68, 0.2);
        }
        /* Styling Scrollbar Tabel agar halus */
        .table-scroll::-webkit-scrollbar {
            height: 6px;
        }
        .table-scroll::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        .table-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        /* Animasi khusus popup peta */
        .leaflet-popup-content-wrapper {
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
        }
    </style>

    <div style="padding: 32px 0; background-color: #f8fafc; min-height: 85vh;">
        <div style="max-width: 1140px; margin: 0 auto; padding: 0 24px;">

            @if(session('success'))
                <div style="background-color: #f0fdf4; border-left: 5px solid #22c55e; color: #15803d; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px rgba(34, 197, 94, 0.05);">
                    <span>🎉</span> {{ session('success') }}
                </div>
            @endif

            <div class="custom-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 16px;">
                    <div>
                        <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                            <i class="bi bi-map-fill text-blue-600" style="color: #2563eb;"></i> Visualisasi Spasial Pelabuhan
                        </h3>
                        <p style="font-size: 13px; color: #64748b; margin: 4px 0 0 0;">Cari, temukan, dan pantau lokasi infrastruktur secara langsung.</p>
                    </div>
                    
                    <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                        <input type="text" id="mapSearch" class="filter-input" placeholder="Cari pelabuhan atau kode...">
                        
                        <select id="mapCountryFilter" class="filter-input" style="width: 190px;">
                            <option value="">Semua Negara</option>
                            @isset($countries)
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                        
                        <button onclick="loadMapMarkers()" 
                                style="background-color: #0f172a; color: #ffffff; border: none; padding: 8px 20px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 6px;"
                                onmouseover="this.style.backgroundColor='#1e293b';" onmouseout="this.style.backgroundColor='#0f172a';">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </div>

                <div id="portMap" style="height: 420px; border-radius: 14px; border: 1px solid #e2e8f0; z-index: 1; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);"></div>
            </div>

            <div class="custom-card" style="padding: 0; overflow: hidden;">
                <div style="padding: 24px 24px 16px 24px; border-bottom: 1px solid #f1f5f9;">
                    <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                        <i class="bi bi-list-task" style="color: #2563eb;"></i> Dataset Infrastruktur Terdaftar
                    </h3>
                    <p style="font-size: 13px; color: #64748b; margin: 4px 0 0 0;">Daftar lengkap gerbang maritim yang tersimpan di dalam sistem basis data.</p>
                </div>
                
                @if($ports->isEmpty())
                    <div style="text-align: center; padding: 50px 24px; color: #64748b;">
                        <span style="font-size: 54px; display: block; margin-bottom: 16px;">⚓</span>
                        <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 6px;">Basis Data Masih Kosong</h3>
                        <p style="font-size: 14px; margin-bottom: 20px; color: #64748b;">Belum ada infrastruktur maritim yang terdaftar saat ini.</p>
                        <a href="{{ route('ports.create') }}" style="color: #2563eb; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                            Registrasi Pelabuhan Pertama Anda <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                @else
                    <div class="table-scroll" style="overflow-x: auto;">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th style="padding-left: 24px;">Nama Pelabuhan</th>
                                    <th>Kode Protokol</th>
                                    <th>Negara Kedaulatan</th>
                                    <th style="text-align: center; padding-right: 24px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ports as $port)
                                    <tr>
                                        <td style="padding-left: 24px; font-weight: 700; color: #1e293b;">
                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                <div style="background-color: #f1f5f9; padding: 6px 10px; border-radius: 8px; color: #475569;">
                                                    <i class="bi bi-ship-front-fill"></i>
                                                </div>
                                                {{ $port->name }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge-locode">
                                                {{ $port->code ?? '-' }}
                                            </span>
                                        </td>
                                        <td style="color: #475569; font-weight: 500;">
                                            <div style="display: flex; align-items: center; gap: 6px;">
                                                <i class="bi bi-geo-alt-fill" style="color: #ef4444;"></i>
                                                {{ $port->country->name ?? 'Tidak Diketahui' }}
                                            </div>
                                        </td>
                                        <td style="text-align: center; padding-right: 24px;">
                                            <div style="display: inline-flex; gap: 8px; align-items: center;">
                                                <button type="button" class="btn-focus" 
                                                        onclick="focusPortOnMap('{{ $port->id }}', '{{ $port->latitude }}', '{{ $port->longitude }}')">
                                                    <i class="bi bi-crosshair"></i> Fokus
                                                </button>

                                                <form action="{{ route('ports.destroy', $port->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus infrastruktur pelabuhan ini?');" style="display:inline; margin: 0;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-delete">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
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
        // 1. Inisialisasi Peta Dunia (Fokus wilayah Indonesia secara default)
        var map = L.map('portMap').setView([5.0, 115.0], 3);

        // Menggunakan OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Group Layer untuk menampung marker agar bisa dihapus-tulis ulang saat pencarian dilakukan
        var markersLayer = L.layerGroup().addTo(map);

        // Objek Global untuk menyimpan referensi marker berdasarkan Port ID agar fungsi fokus bisa mengaksesnya
        var activeMarkers = {};

        /**
         * FUNGSI DECODER DMS KE DESIMAL:
         * Mengubah teks koordinat derajat di database (misal: "6 05 S" atau "106 53 E")
         * menjadi format angka desimal murni (float) agar dikenali oleh Leaflet.js.
         */
        function parseDMSToDecimal(dmsStr) {
            if (!dmsStr) return null;
            
            var str = dmsStr.trim().replace(/\s+/g, ' ');
            if (!isNaN(str)) return parseFloat(str);
            
            var parts = str.split(' ');
            if (parts.length >= 2) {
                var degrees = parseFloat(parts[0]) || 0;
                var minutes = parseFloat(parts[1]) || 0;
                var seconds = 0;
                
                var lastPart = parts[parts.length - 1].toUpperCase();
                var hasDirection = ['N', 'S', 'E', 'W'].includes(lastPart);
                var direction = hasDirection ? lastPart : null;

                if (hasDirection && parts.length === 4) {
                    seconds = parseFloat(parts[2]) || 0;
                } else if (!hasDirection && parts.length === 3) {
                    seconds = parseFloat(parts[2]) || 0;
                }

                var decimal = degrees + (minutes / 60) + (seconds / 3600);
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
            activeMarkers = {}; // Reset database referensi marker aktif

            // Jalankan REST API internal
            var url = `/api/ports?search=${encodeURIComponent(search)}&country_id=${encodeURIComponent(countryId)}`;

            fetch(url)
                .then(response => response.json())
                .then(ports => {
                    var bounds = [];

                    ports.forEach(port => {
                        var lat = parseDMSToDecimal(port.latitude);
                        var lng = parseDMSToDecimal(port.longitude);

                        if (lat !== null && lng !== null && !isNaN(lat) && !isNaN(lng)) {
                            
                            // Markup Konten Balon Keterangan (Popup) yang modern
                            var popupContent = `
                                <div style="font-family: system-ui, sans-serif; padding: 4px; min-width: 180px;">
                                    <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 8px;">
                                        <span style="font-size: 16px;">⚓</span>
                                        <h4 style="margin: 0; color: #0f172a; font-weight: 700; font-size: 14px;">${port.name}</h4>
                                    </div>
                                    <div style="border-top: 1px solid #e2e8f0; padding-top: 8px; font-size: 12px; display: flex; flex-direction: column; gap: 4px;">
                                        <p style="margin: 0; color: #475569;"><b>Kode Protokol:</b> <span style="background-color: #eff6ff; color:#1d4ed8; padding: 2px 6px; border-radius: 4px; font-family: monospace; font-weight: 700;">${port.code || '-'}</span></p>
                                        <p style="margin: 0; color: #475569;"><b>Negara:</b> ${port.country ? port.country.name : 'Tidak Diketahui'}</p>
                                        <p style="margin: 4px 0 0 0; color: #2563eb; font-weight: 600;">📍 ${lat.toFixed(5)}, ${lng.toFixed(5)}</p>
                                    </div>
                                </div>
                            `;

                            var marker = L.marker([lat, lng]).bindPopup(popupContent);
                            
                            markersLayer.addLayer(marker);
                            bounds.push([lat, lng]);

                            // Simpan referensi marker menggunakan port ID
                            activeMarkers[port.id] = marker;
                        }
                    });

                    // Logika Smart Zooming & Pergerakan Peta
                    if (bounds.length === 1) {
                        map.flyTo(bounds[0], 12, { animate: true, duration: 1.5 });
                    } else if (bounds.length > 1) {
                        map.fitBounds(bounds, { padding: [50, 50] });
                    } else {
                        map.setView([5.0, 115.0], 3); 
                    }
                })
                .catch(err => console.error('Gagal memuat data API Pelabuhan:', err));
        }

        /**
         * FUNGSI FOKUS INTERAKTIF BARU:
         * Mengarahkan peta secara mulus langsung ke koordinat pelabuhan dari baris tabel,
         * lalu otomatis membuka popup informasi pelabuhan yang bersangkutan.
         */
        function focusPortOnMap(portId, latStr, lngStr) {
            var lat = parseDMSToDecimal(latStr);
            var lng = parseDMSToDecimal(lngStr);

            if (lat !== null && lng !== null && !isNaN(lat) && !isNaN(lng)) {
                // Terbangkan kamera peta ke koordinat target (zoom level 13)
                map.flyTo([lat, lng], 13, {
                    animate: true,
                    duration: 1.5
                });

                // Scroll layar ke arah peta dengan mulus agar user langsung melihat pergerakannya
                document.getElementById('portMap').scrollIntoView({ behavior: 'smooth', block: 'center' });

                // Buka popup balon info marker setelah animasi pergeseran selesai (1.5 detik delay)
                setTimeout(function() {
                    if (activeMarkers[portId]) {
                        activeMarkers[portId].openPopup();
                    }
                }, 1500);
            } else {
                alert("Koordinat pelabuhan tidak valid untuk divisualisasikan.");
            }
        }

        // Jalankan mapping data pelabuhan begitu seluruh komponen halaman selesai dimuat
        document.addEventListener('DOMContentLoaded', function() {
            loadMapMarkers();
        });
    </script>
</x-app-layout>
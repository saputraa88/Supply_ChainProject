<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Intelijen Analisis Risiko Rantai Pasok') }}
        </h2>
    </x-slot>

    @php
        // JAGA-JAGA: Ubah stdClass menjadi Array secara otomatis jika terdeteksi sebagai Object
        if (is_object($riskAnalysis)) {
            $riskAnalysis = (array) $riskAnalysis;
        }
        
        if (is_object($weatherData)) {
            $weatherData = (array) $weatherData;
        }

        $riskColor = '#10b981'; 
        $riskBg = '#ecfdf5';
        $chartBg = 'rgba(16, 185, 129, 0.2)';
        
        if ($riskAnalysis['risk_level'] === 'Medium Risk') {
            $riskColor = '#f59e0b'; 
            $riskBg = '#fffbeb';
            $chartBg = 'rgba(245, 158, 11, 0.2)';
        } elseif ($riskAnalysis['risk_level'] === 'High Risk') {
            $riskColor = '#ef4444'; 
            $riskBg = '#fef2f2';
            $chartBg = 'rgba(239, 68, 68, 0.2)';
        }
    @endphp

    <div style="padding: 32px 0; background-color: #f3f4f6; min-height: 90vh; font-family: 'Inter', system-ui, sans-serif;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 24px;">
            
            <a href="{{ route('countries.index') }}" style="display: inline-block; text-decoration: none; color: #4b5563; font-weight: 600; margin-bottom: 20px; font-size: 14px;" onmouseover="this.style.color='#111827'" onmouseout="this.style.color='#4b5563'">
                ⬅️ Kembali ke Daftar Negara
            </a>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                
                <div style="display: flex; flex-direction: column; gap: 24px;">
                    
                    <div style="background-color: white; border-radius: 12px; padding: 28px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 24px;">
                        <img src="{{ $flagUrl }}" alt="Bendera" style="width: 110px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border: 1px solid #e5e7eb;">
                        <div style="flex: 1;">
                            <span style="background-color: #dbeafe; color: #1e40af; font-weight: 700; padding: 4px 8px; border-radius: 6px; font-size: 12px; text-transform: uppercase; font-family: monospace;">
                                KODE: {{ $country->code }}
                            </span>
                            <h1 style="font-size: 28px; font-weight: 800; color: #1e293b; margin: 6px 0 2px 0;">{{ $country->name }}</h1>
                            <p style="color: #64748b; margin: 0 0 12px 0; font-size: 14px;">Region: <strong>{{ $region }}</strong> | Populasi: <strong>{{ $population ?? 'N/A' }}</strong></p>
                            
                            <form action="{{ route('watchlist.toggle', $country->id) }}" method="POST" style="margin: 0; display: inline-block;">
                                @csrf
                                @if(auth()->user()->watchedCountries()->where('country_id', $country->id)->exists())
                                    <button type="submit" style="background-color: #ef4444; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#dc2626'" onmouseout="this.style.backgroundColor='#ef4444'">
                                        ⭐ Hapus dari Daftar Pantau
                                    </button>
                                @else
                                    <button type="submit" style="background-color: #f3f4f6; color: #4b5563; border: 1px solid #d1d5db; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#e5e7eb'" onmouseout="this.style.backgroundColor='#f3f4f6'">
                                        ☆ Tambah ke Daftar Pantau
                                    </button>
                                @endif
                            </form>

                            @if (session('status'))
                                <div style="margin-top: 8px; color: #16a34a; font-size: 12px; font-weight: 600;">
                                    {{ session('status') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div style="background-color: white; border-radius: 12px; padding: 28px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                        <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px; margin-top: 0; margin-bottom: 16px;">
                            🗺️ Geospatial Risk Mapping (Peta Interaktif)
                        </h3>
                        <div id="map" style="height: 250px; border-radius: 8px; border: 1px solid #cbd5e1; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);"></div>
                        <p style="color: #64748b; margin-top: 8px; margin-bottom: 0; font-size: 12px; font-style: italic;">
                            📍 Titik Koordinat Penguncian Jalur Logistik: {{ $country->latitude }} , {{ $country->longitude }}
                        </p>
                    </div>

                    <div style="background-color: white; border-radius: 12px; padding: 28px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                        <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px; margin-top: 0; margin-bottom: 16px;">
                            🌤️ Kondisi Cuaca Ekstrem (Live Satelit)
                        </h3>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div style="background-color: #f8fafc; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0; text-align: center;">
                                <span style="font-size: 13px; color: #64748b; display: block; margin-bottom: 4px;">Temperatur Saat Ini</span>
                                <strong style="font-size: 24px; color: #0f172a;">{{ $weatherData['temperature'] ?? '27.5' }}°C</strong>
                            </div>
                            <div style="background-color: #f8fafc; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0; text-align: center;">
                                <span style="font-size: 13px; color: #64748b; display: block; margin-bottom: 4px;">Kecepatan Angin</span>
                                <strong style="font-size: 24px; color: #0f172a;">{{ $weatherData['windspeed'] ?? '12.5' }} km/h</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 24px;">
                    
                    <div style="background-color: white; border-radius: 12px; padding: 28px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-top: 6px solid {{ $riskColor }};">
                        <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-top: 0; margin-bottom: 16px;">
                            📊 Supply Chain Risk Scoring Engine
                        </h3>
                        
                        <div style="background-color: {{ $riskBg }}; border: 1px solid {{ $riskColor }}; padding: 20px; border-radius: 10px; text-align: center; margin-bottom: 20px;">
                            <span style="font-size: 14px; color: #334155; font-weight: 600; display: block; text-transform: uppercase;">Total Skor Risiko Global</span>
                            <strong style="font-size: 48px; color: {{ $riskColor }}; font-family: sans-serif;">{{ $riskAnalysis['total_risk'] }} <span style="font-size: 20px; font-weight: 500;">/ 100</span></strong>
                            <div style="margin-top: 6px;"><span style="background-color: {{ $riskColor }}; color: white; font-weight: 700; padding: 6px 16px; border-radius: 20px; font-size: 14px; display: inline-block;">{{ $riskAnalysis['risk_level'] }}</span></div>
                        </div>

                        <div style="background-color: #f8fafc; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 20px;">
                            <canvas id="riskRadarChart" style="max-height: 230px; margin: 0 auto;"></canvas>
                        </div>

                        <h4 style="font-size: 14px; font-weight: 700; color: #334155; margin-bottom: 10px;">Rincian Bobot Multi-Indikator Risiko:</h4>
                        <div style="display: flex; flex-direction: column; gap: 10px; font-size: 13px;">
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;"><span>☁️ Risiko Cuaca Ekstrem (30%)</span><strong style="color: #1e293b;">Skor: {{ $riskAnalysis['weather_risk'] }}</strong></div>
                                <div style="width: 100%; background-color: #e2e8f0; height: 6px; border-radius: 3px;"><div style="width: {{ $riskAnalysis['weather_risk'] }}%; background-color: #3b82f6; height: 6px; border-radius: 3px;"></div></div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;"><span>📈 Risiko Inflasi Negara (20%)</span><strong style="color: #1e293b;">Skor: {{ $riskAnalysis['inflation_risk'] }} (Inflasi: {{ $inflationRate }}%)</strong></div>
                                <div style="width: 100%; background-color: #e2e8f0; height: 6px; border-radius: 3px;"><div style="width: {{ $riskAnalysis['inflation_risk'] }}%; background-color: #f59e0b; height: 6px; border-radius: 3px;"></div></div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;"><span>📰 Sentimen Berita Geopolitik (40%)</span><strong style="color: #1e293b;">Skor: {{ round($riskAnalysis['news_risk'], 1) }}</strong></div>
                                <div style="width: 100%; background-color: #e2e8f0; height: 6px; border-radius: 3px;"><div style="width: {{ $riskAnalysis['news_risk'] }}%; background-color: #ef4444; height: 6px; border-radius: 3px;"></div></div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;"><span>💱 Fluktuasi Nilai Tukar (10%)</span><strong style="color: #1e293b;">Skor: {{ $riskAnalysis['currency_risk'] }}</strong></div>
                                <div style="width: 100%; background-color: #e2e8f0; height: 6px; border-radius: 3px;"><div style="width: {{ $riskAnalysis['currency_risk'] }}%; background-color: #6b7280; height: 6px; border-radius: 3px;"></div></div>
                            </div>
                        </div>
                    </div>

                    <div style="background-color: white; border-radius: 12px; padding: 28px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                        <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-top: 0; margin-bottom: 12px;">
                            🧠 Lexicon-Based Sentiment Intelligence
                        </h3>
                        <p style="font-size: 13px; color: #475569; margin-top: 0; margin-bottom: 14px;">
                            Mesin AI PHP memindai feed berita logistik internasional dan mencocokkannya dengan kamus database <code>positive_words</code> & <code>negative_words</code>.
                        </p>
                        
                        <div style="background-color: #1e293b; color: #38bdf8; font-family: monospace; padding: 14px; border-radius: 8px; font-size: 13px; border-left: 4px solid #0284c7; margin-bottom: 14px; line-height: 1.5;">
                            <span style="color: #94a3b8; display: block; font-size: 11px; margin-bottom: 4px;">// RSS LOGISTICS NEWS INPUT FEED:</span>
                            "{{ $riskAnalysis['news_sample'] }}"
                        </div>

                        <div style="display: flex; gap: 12px; font-size: 13px;">
                            <div style="flex: 1; background-color: #f0fdf4; border: 1px solid #bbf7d0; padding: 12px; border-radius: 6px; text-align: center;">
                                <span style="color: #166534; font-weight: 600; display: block;">Kata Positif Terdeteksi</span>
                                <strong style="font-size: 20px; color: #15803d;">{{ $riskAnalysis['positive_count'] }} Kata</strong>
                            </div>
                            <div style="flex: 1; background-color: #fef2f2; border: 1px solid #fee2e2; padding: 12px; border-radius: 6px; text-align: center;">
                                <span style="color: #991b1b; font-weight: 600; display: block;">Kata Negatif Terdeteksi</span>
                                <strong style="font-size: 20px; color: #b91c1c;">{{ $riskAnalysis['negative_count'] }} Kata</strong>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            
            // ================== LOGIKA 1: CHART.JS RADAR ==================
            var ctx = document.getElementById('riskRadarChart').getContext('2d');
            var riskRadarChart = new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: ['Cuaca (30%)', 'Inflasi (20%)', 'Berita (40%)', 'Mata Uang (10%)'],
                    datasets: [{
                        label: 'Skor Kerentanan Risiko',
                        data: [
                            "{{ $riskAnalysis['weather_risk'] }}",
                            "{{ $riskAnalysis['inflation_risk'] }}",
                            "{{ round($riskAnalysis['news_risk'], 1) }}",
                            "{{ $riskAnalysis['currency_risk'] }}"
                        ],
                        backgroundColor: "{{ $chartBg }}",
                        borderColor: "{{ $riskColor }}",
                        pointBackgroundColor: "{{ $riskColor }}",
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: "{{ $riskColor }}",
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            angleLines: { display: true },
                            suggestMin: 0,
                            suggestMax: 100,
                            ticks: { backdropColor: 'transparent', stepSize: 25 }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            // ================== LOGIKA 2: LEAFLET.JS MAPS ==================
            let rawLat = "{{ $country->latitude }}";
            let rawLng = "{{ $country->longitude }}";

            function parseCoordinate(coordStr, isLongitude) {
                let digits = coordStr.replace(/[^0-9 ]/g, '').trim().split(/\s+/);
                if (digits.length === 0 || digits[0] === "") return 0;
                let decimal = (digits.length >= 2) ? parseFloat(digits[0] + '.' + digits[1]) : parseFloat(digits[0]);
                if (isLongitude && coordStr.toUpperCase().includes('W')) decimal = -decimal;
                if (!isLongitude && coordStr.toUpperCase().includes('S')) decimal = -decimal;
                return decimal;
            }

            let lat = parseCoordinate(rawLat, false);
            let lng = parseCoordinate(rawLng, true);

            if (lat === 0 && lng === 0) {
                lat = -6.2000; lng = 106.8167; // Default Jakarta
            }

            var map = L.map('map').setView([lat, lng], 4);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            var marker = L.marker([lat, lng]).addTo(map);
            marker.bindPopup("<b>{{ $country->name }}</b><br>Tingkat Risiko: {{ $riskAnalysis['risk_level'] }}").openPopup();
        });
    </script>
</x-app-layout>
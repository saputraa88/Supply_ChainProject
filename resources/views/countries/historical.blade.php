<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight" style="font-family: system-ui, sans-serif; letter-spacing: -0.5px;">
            📊 {{ __('Data Visualization Dashboard') }}
        </h2>
    </x-slot>

    <!-- Memanggil Script Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div style="padding: 40px 0; background-color: #f8fafc; min-height: 90vh; font-family: system-ui, -apple-system, sans-serif;">
        <!-- Kunci Max-Width 960px agar sejajar sempurna di tengah monitor -->
        <div style="max-width: 960px; margin: 0 auto; padding: 0 20px;">
            
            <!-- 1. SELEKTOR DROPDOWN NEGARA -->
            <div style="background: #ffffff; padding: 20px 24px; border-radius: 16px; box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05); margin-bottom: 28px; border: 1px solid #e2e8f0; border-top: 4px solid #1e3a8a;">
                <form action="{{ route('historical.index') }}" method="GET" style="display: flex; gap: 16px; align-items: center; justify-content: center; flex-wrap: wrap;">
                    <span style="font-size: 13px; font-weight: 800; color: #1e3a8a; text-transform: uppercase; letter-spacing: 0.5px;">Pilih Visualisasi Data Negara:</span>
                    
                    <select name="country_id" onchange="this.form.submit()" style="border: 1px solid #cbd5e1; border-radius: 10px; padding: 8px 16px; width: 280px; background:#ffffff; font-size: 14px; font-weight: 600; color: #0f172a; outline: none;">
                        @foreach($countries as $c)
                            <option value="{{ $c->id }}" {{ $country && $country->id == $c->id ? 'selected' : '' }}>
                                🏛️ {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if($country)
            <!-- 2. GRID VISUALISASI DUA GRAFIK UTAMA -->
            <div style="display: flex; flex-direction: column; gap: 28px;">
                
                <!-- BLOK GRAFIK 1: TREN NOMINAL GDP (BAR CHART PREMIUM) -->
                <div style="background: #ffffff; padding: 24px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
                    <div style="margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 22px;">📈</span>
                        <div>
                            <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; letter-spacing: -0.3px;">Pertumbuhan Gross Domestic Product (GDP)</h3>
                            <p style="font-size: 12px; color: #64748b;">Statistik perkembangan produk domestik bruto dalam skala Miliar USD (2022 - 2026).</p>
                        </div>
                    </div>
                    <div style="position: relative; width: 100%; height: 280px;">
                        <canvas id="gdpBarChart"></canvas>
                    </div>
                </div>

                <!-- BLOK GRAFIK 2: TREN INFLASI DOMESTIK (LINE CHART SMOOTH) -->
                <div style="background: #ffffff; padding: 24px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
                    <div style="margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 22px;">📉</span>
                        <div>
                            <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; letter-spacing: -0.3px;">Laju Tren Inflasi Tahunan</h3>
                            <p style="font-size: 12px; color: #64748b;">Metrik fluktuasi persentase inflasi pasar domestik rantai pasok.</p>
                        </div>
                    </div>
                    <div style="position: relative; width: 100%; height: 280px;">
                        <canvas id="inflationLineChart"></canvas>
                    </div>
                </div>

            </div>
            @endif

        </div>
    </div>

    <!-- SCRIPT INJEKSI PEM Pembuatan GRAPH INTEGRATION -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // A. KONFIGURASI CHART 1: GDP BAR CHART (EMERALD GRADIENT)
            const ctxGdp = document.getElementById('gdpBarChart').getContext('2d');
            new Chart(ctxGdp, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($yearsLabel) !!},
                    datasets: [{
                        label: 'GDP Nominal (Billion USD)',
                        data: {!! json_encode($gdpData) !!},
                        backgroundColor: 'rgba(16, 185, 129, 0.85)', // Emerald Green Solid
                        hoverBackgroundColor: '#047857',
                        borderRadius: 8,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: true, position: 'top' }
                    },
                    scales: {
                        y: { grid: { color: '#f1f5f9' }, ticks: { color: '#64748b' } },
                        x: { grid: { display: false }, ticks: { color: '#64748b', font: { weight: '600' } } }
                    }
                }
            });

            // B. KONFIGURASI CHART 2: INFLATION LINE CHART (AMBER CURVE)
            const ctxInflasi = document.getElementById('inflationLineChart').getContext('2d');
            new Chart(ctxInflasi, {
                type: 'line',
                data: {
                    labels: {!! json_encode($yearsLabel) !!},
                    datasets: [{
                        label: 'Tingkat Inflasi (%)',
                        data: {!! json_encode($inflationData) !!},
                        borderColor: '#d97706', // Amber Dark Line
                        backgroundColor: 'rgba(251, 191, 36, 0.08)',
                        borderWidth: 3,
                        pointBackgroundColor: '#d97706',
                        pointHoverRadius: 6,
                        tension: 0.35, // Efek melengkung halus
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: true, position: 'top' }
                    },
                    scales: {
                        y: { grid: { color: '#f1f5f9' }, ticks: { color: '#64748b' } },
                        x: { grid: { display: false }, ticks: { color: '#64748b', font: { weight: '600' } } }
                    }
                }
            });
        });
    </script>
</x-app-layout>
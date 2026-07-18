<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight" style="font-family: system-ui, sans-serif; letter-spacing: -0.5px;">
            💱 {{ __('Currency Impact Dashboard') }}
        </h2>
    </x-slot>

    <!-- Pustaka Chart.js Resmi via CDN Aman -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div style="padding: 40px 0; background-color: #f8fafc; min-height: 90vh; font-family: system-ui, -apple-system, sans-serif;">
        <!-- Kunci Max-Width 960px agar simetris di tengah layar -->
        <div style="max-width: 960px; margin: 0 auto; padding: 0 20px;">
            
            <!-- 1. SELEKTOR PILIHAN MATA UANG NEGARA -->
            <div style="background: #ffffff; padding: 20px 24px; border-radius: 16px; box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05); margin-bottom: 24px; border: 1px solid #e2e8f0; border-top: 4px solid #3b82f6;">
                <form action="{{ route('currency.index') }}" method="GET" style="display: flex; gap: 16px; align-items: center; justify-content: center; flex-wrap: wrap;">
                    <span style="font-size: 13px; font-weight: 800; color: #1e3a8a; text-transform: uppercase; letter-spacing: 0.5px;">Pilih Analisis Mata Uang Negara:</span>
                    
                    <select name="country_id" onchange="this.form.submit()" style="border: 1px solid #cbd5e1; border-radius: 10px; padding: 8px 16px; width: 280px; background:#ffffff; font-size: 14px; font-weight: 600; color: #0f172a; outline: none;">
                        @foreach($countries as $c)
                            <option value="{{ $c->id }}" {{ $country && $country->id == $c->id ? 'selected' : '' }}>
                                💵 {{ $c->name }} ({{ $c->currency ?? 'Mata Uang Lokal' }})
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if($country)
            <!-- 2. EXECUTIVE METRIC CARDS -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 28px;">
                
                <!-- Card 1: Informasi Mata Uang -->
                <div style="background: linear-gradient(135deg, #1e3a8a, #0f172a); padding: 20px; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); color: #ffffff;">
                    <div style="font-size: 11px; font-weight: 800; color: #93c5fd; text-transform: uppercase; letter-spacing: 0.05em;">Nama Valuta Resmi</div>
                    <div style="font-size: 18px; font-weight: 800; margin-top: 6px;">{{ $country->currency ?? 'Local Currency' }}</div>
                    <div style="font-size: 12px; color: #cbd5e1; margin-top: 4px;">Kode Negara: {{ $country->code }}</div>
                </div>

                <!-- Card 2: Status Stabilitas -->
                <div style="background: #ffffff; padding: 20px; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;">
                    <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Tingkat Volatilitas Kurs</div>
                    <div style="font-size: 20px; font-weight: 800; color: {{ $volatilityColor }}; margin-top: 6px;">
                        {{ $volatilityStatus }}
                    </div>
                    <div style="font-size: 12px; color: #94a3b8; margin-top: 4px;">Indikator Dampak Rantai Pasok</div>
                </div>

                <!-- Card 3: Nilai Terakhir (Juli 2026) -->
                <div style="background: #ffffff; padding: 20px; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;">
                    <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Kurs Terakhir (Per 1 USD)</div>
                    <div style="font-size: 20px; font-weight: 800; color: #1e293b; font-family: monospace; margin-top: 6px;">
                        {{ number_format(end($chartData), 2, ',', '.') }}
                    </div>
                    <div style="font-size: 12px; color: #94a3b8; margin-top: 4px;">Data Terupdate Real-Time</div>
                </div>
            </div>

            <!-- 3. MAIN GRAPH BLOCK (CHART KONTROL PANEL) -->
            <div style="background: #ffffff; padding: 28px; border-radius: 20px; box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04); border: 1px solid #e2e8f0;">
                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; letter-spacing: -0.3px;">📈 Tren Nilai Tukar Kontemporer Historis</h3>
                    <p style="font-size: 12px; color: #64748b; margin-top: 2px;">Visualisasi fluktuasi grafik nilai tukar mata uang terhadap US Dollar (USD) dalam 6 bulan terakhir.</p>
                </div>

                <!-- Kontainer Canvas Grafik Chart.js -->
                <div style="position: relative; width: 100%; height: 320px;">
                    <canvas id="currencyImpactChart"></canvas>
                </div>
            </div>
            @endif

        </div>
    </div>

    <!-- INJEKSI SCRIPT JAVASCRIPT UNTUK CHART.JS -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('currencyImpactChart').getContext('2d');
            
            // Konfigurasi Chart.js Premium Style
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Nilai Tukar Kurs (Per 1 USD)',
                        data: {!! json_encode($chartData) !!},
                        borderColor: '#2563eb', // Warna Line Navy Blue
                        backgroundColor: 'rgba(37, 99, 235, 0.06)', // Efek Gradient Fill Terbawah
                        borderWidth: 3,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.35, // Membuat garis melengkung dinamis halus (Smooth Curve)
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                font: { size: 12, weight: 'bold', family: 'system-ui' },
                                color: '#475569'
                            }
                        }
                    },
                    scales: {
                        y: {
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                font: { size: 11, family: 'monospace' },
                                color: '#64748b'
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { size: 11, weight: '600', family: 'system-ui' },
                                color: '#64748b'
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
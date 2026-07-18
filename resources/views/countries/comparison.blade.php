<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight" style="font-family: system-ui, sans-serif; letter-spacing: -0.5px;">
            📊 {{ __('Country Comparison Engine') }}
        </h2>
    </x-slot>

    <div style="padding: 40px 0; background-color: #f8fafc; min-height: 90vh; font-family: system-ui, -apple-system, sans-serif;">
        <!-- Lebar tetap kompak di 960px agar pas di tengah monitor lebar -->
        <div style="max-width: 960px; margin: 0 auto; padding: 0 20px;">
            
            <!-- 1. FORM SELEKTOR DENGAN UTAS AKSEN BLUE LIGHT -->
            <div style="background: #ffffff; padding: 20px 24px; border-radius: 16px; box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05); margin-bottom: 28px; border: 1px solid #e2e8f0; border-top: 4px solid #2563eb;">
                <form action="{{ route('countries.comparison') }}" method="GET" style="display: flex; gap: 24px; align-items: center; justify-content: center; flex-wrap: wrap;">
                    
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 12px; font-weight: 800; color: #1e3a8a; text-transform: uppercase; letter-spacing: 0.5px;">Negara A:</span>
                        <select name="country_a" style="border: 1px solid #cbd5e1; border-radius: 10px; padding: 9px 16px; width: 220px; background:#ffffff; font-size: 14px; font-weight: 600; color: #0f172a; outline: none; box-shadow: inset 0 1px 2px rgba(0,0,0,0.02);">
                            @foreach($countries as $c)
                                <option value="{{ $c->id }}" {{ $analysisA['model']->id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="font-size: 16px; font-weight: 900; color: #3b82f6; font-style: italic; background: #eff6ff; padding: 4px 12px; border-radius: 8px;">VS</div>

                    <div style="display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 12px; font-weight: 800; color: #1e3a8a; text-transform: uppercase; letter-spacing: 0.5px;">Negara B:</span>
                        <select name="country_b" style="border: 1px solid #cbd5e1; border-radius: 10px; padding: 9px 16px; width: 220px; background:#ffffff; font-size: 14px; font-weight: 600; color: #0f172a; outline: none; box-shadow: inset 0 1px 2px rgba(0,0,0,0.02);">
                            @foreach($countries as $c)
                                <option value="{{ $c->id }}" {{ $analysisB['model']->id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #ffffff; border: none; padding: 10px 26px; border-radius: 10px; font-weight: 700; font-size: 13px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);"
                            onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 16px rgba(37, 99, 235, 0.3)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 12px rgba(37, 99, 235, 0.2)';">
                        ⚡ Bandingkan Analitik
                    </button>
                </form>
            </div>

            <!-- 2. EXECUTIVE BOARD GRID (WARNA PREMIUM DEEP BLUE CONTROL TOWER) -->
            <div style="background: #ffffff; border-radius: 20px; box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; overflow: hidden;">
                
                <!-- HEADER BOARD: KITA BAWAKAN KEMBALI WARNA BANNER CORE UTAMA -->
                <div style="display: grid; grid-template-columns: 34% 33% 33%; background: linear-gradient(135deg, #1e3a8a, #0f172a); align-items: center; border-bottom: 2px solid #1e293b;">
                    <div style="padding: 26px 24px; font-size: 11px; font-weight: 800; color: #93c5fd; text-transform: uppercase; letter-spacing: 0.08em;">KOMPONEN INDIKATOR</div>
                    
                    <!-- Bendera & Nama Negara A -->
                    <div style="padding: 22px; text-align: center; border-left: 1px solid rgba(255,255,255,0.1);">
                        <div style="display: inline-flex; flex-direction: column; align-items: center; gap: 8px; background: rgba(255,255,255,0.07); padding: 10px 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.15);">
                            <img src="{{ $analysisA['flag_url'] }}" style="width: 36px; height: auto; border-radius: 4px; box-shadow: 0 4px 10px rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.2);">
                            <span style="font-size: 15px; font-weight: 800; color: #ffffff; letter-spacing: -0.3px;">{{ $analysisA['model']->name }}</span>
                        </div>
                    </div>

                    <!-- Bendera & Nama Negara B -->
                    <div style="padding: 22px; text-align: center; border-left: 1px solid rgba(255,255,255,0.1);">
                        <div style="display: inline-flex; flex-direction: column; align-items: center; gap: 8px; background: rgba(255,255,255,0.07); padding: 10px 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.15);">
                            <img src="{{ $analysisB['flag_url'] }}" style="width: 36px; height: auto; border-radius: 4px; box-shadow: 0 4px 10px rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.2);">
                            <span style="font-size: 15px; font-weight: 800; color: #ffffff; letter-spacing: -0.3px;">{{ $analysisB['model']->name }}</span>
                        </div>
                    </div>
                </div>

                <!-- BODY BARIS ANALISIS DATA -->
                <div style="font-size: 14px; color: #334155;">
                    
                    <!-- 1. TOTAL RISK SCORE (VISUAL MENYALA) -->
                    <div style="display: grid; grid-template-columns: 34% 33% 33%; border-bottom: 1px solid #e2e8f0; background: #fdfdfd; align-items: center;">
                        <div style="padding: 22px 24px; font-weight: 800; color: #0f172a; background: #f8fafc; height: 100%; display: flex; align-items: center; border-right: 1px solid #f1f5f9;">🛡️ Total Risk Score (1-100)</div>
                        <div style="padding: 22px; text-align: center; border-left: 1px solid #f1f5f9;">
                            <span style="font-weight: 900; font-size: 22px; color: {{ $analysisA['total_risk'] >= 50 ? '#dc2626' : '#10b981' }};">
                                {{ $analysisA['total_risk'] }} 
                                <span style="font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 8px; margin-left: 8px; background: {{ $analysisA['total_risk'] >= 50 ? '#fee2e2' : '#dcfce7' }}; color: {{ $analysisA['total_risk'] >= 50 ? '#ef4444' : '#15803d' }}; border: 1px solid {{ $analysisA['total_risk'] >= 50 ? '#fca5a5' : '#86efac' }};">
                                    {{ $analysisA['risk_level'] }}
                                </span>
                            </span>
                        </div>
                        <div style="padding: 22px; text-align: center; border-left: 1px solid #f1f5f9;">
                            <span style="font-weight: 900; font-size: 22px; color: {{ $analysisB['total_risk'] >= 50 ? '#dc2626' : '#10b981' }};">
                                {{ $analysisB['total_risk'] }}
                                <span style="font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 8px; margin-left: 8px; background: {{ $analysisB['total_risk'] >= 50 ? '#fee2e2' : '#dcfce7' }}; color: {{ $analysisB['total_risk'] >= 50 ? '#ef4444' : '#15803d' }}; border: 1px solid {{ $analysisB['total_risk'] >= 50 ? '#fca5a5' : '#86efac' }};">
                                    {{ $analysisB['risk_level'] }}
                                </span>
                            </span>
                        </div>
                    </div>

                    <!-- 2. GROSS DOMESTIC PRODUCT (FINANSIAL STYLE) -->
                    <div style="display: grid; grid-template-columns: 34% 33% 33%; border-bottom: 1px solid #e2e8f0; align-items: center; background: #ffffff;">
                        <div style="padding: 20px 24px; font-weight: 700; color: #475569; background: #f8fafc; height: 100%; display: flex; align-items: center; border-right: 1px solid #f1f5f9;">📈 Gross Domestic Product (GDP)</div>
                        <div style="padding: 20px; text-align: center; font-weight: 800; color: #1e3a8a; font-family: 'Courier New', Courier, monospace; font-size: 15px; border-left: 1px solid #f1f5f9;">
                            {{ $analysisA['gdp_formatted'] }}
                        </div>
                        <div style="padding: 20px; text-align: center; font-weight: 800; color: #1e3a8a; font-family: 'Courier New', Courier, monospace; font-size: 15px; border-left: 1px solid #f1f5f9;">
                            {{ $analysisB['gdp_formatted'] }}
                        </div>
                    </div>

                    <!-- 3. INFLATION RATE (AKSEN ORANYE TUA) -->
                    <div style="display: grid; grid-template-columns: 34% 33% 33%; border-bottom: 1px solid #e2e8f0; align-items: center; background: #ffffff;">
                        <div style="padding: 20px 24px; font-weight: 700; color: #475569; background: #f8fafc; height: 100%; display: flex; align-items: center; border-right: 1px solid #f1f5f9;">📉 Tingkat Inflasi Domestik</div>
                        <div style="padding: 20px; text-align: center; border-left: 1px solid #f1f5f9;">
                            <span style="font-weight: 800; color: #b45309; font-size: 16px; background: #fef3c7; padding: 4px 12px; border-radius: 6px; border: 1px solid #fde68a;">{{ $analysisA['inflation_rate'] }}%</span>
                            <div style="font-size: 11px; color: #64748b; font-weight: 600; margin-top: 6px;">Skor Beban: <span style="color:#ef4444;">{{ $analysisA['inflation_risk'] }}</span></div>
                        </div>
                        <div style="padding: 20px; text-align: center; border-left: 1px solid #f1f5f9;">
                            <span style="font-weight: 800; color: #b45309; font-size: 16px; background: #fef3c7; padding: 4px 12px; border-radius: 6px; border: 1px solid #fde68a;">{{ $analysisB['inflation_rate'] }}%</span>
                            <div style="font-size: 11px; color: #64748b; font-weight: 600; margin-top: 6px;">Skor Beban: <span style="color:#ef4444;">{{ $analysisB['inflation_risk'] }}</span></div>
                        </div>
                    </div>

                    <!-- 4. WEATHER CONDITION (CYAN & METEO THEME) -->
                    <div style="display: grid; grid-template-columns: 34% 33% 33%; border-bottom: 1px solid #e2e8f0; align-items: center; background: #ffffff;">
                        <div style="padding: 20px 24px; font-weight: 700; color: #475569; background: #f8fafc; height: 100%; display: flex; align-items: center; border-right: 1px solid #f1f5f9;">☀️ Kondisi Satelit & Cuaca Live</div>
                        <div style="padding: 20px; text-align: center; border-left: 1px solid #f1f5f9;">
                            <span style="background: #e0f2fe; color: #0369a1; padding: 5px 14px; border-radius: 8px; font-weight: 800; font-size: 14px; border: 1px solid #bae6fd;">
                                🌡️ {{ $analysisA['temperature'] }}°C
                            </span>
                            <div style="font-size: 11px; color: #0284c7; margin-top: 6px; font-weight: 600;">💨 Angin: {{ $analysisA['windspeed'] }} km/h</div>
                        </div>
                        <div style="padding: 20px; text-align: center; border-left: 1px solid #f1f5f9;">
                            <span style="background: #e0f2fe; color: #0369a1; padding: 5px 14px; border-radius: 8px; font-weight: 800; font-size: 14px; border: 1px solid #bae6fd;">
                                🌡️ {{ $analysisB['temperature'] }}°C
                            </span>
                            <div style="font-size: 11px; color: #0284c7; margin-top: 6px; font-weight: 600;">💨 Angin: {{ $analysisB['windspeed'] }} km/h</div>
                        </div>
                    </div>

                    <!-- 5. NEWS GEOPOLITICAL SENTIMENT (VIBRANT BADGES) -->
                    <div style="display: grid; grid-template-columns: 34% 33% 33%; border-bottom: 1px solid #e2e8f0; align-items: center; background: #ffffff;">
                        <div style="padding: 20px 24px; font-weight: 700; color: #475569; background: #f8fafc; height: 100%; display: flex; align-items: center; border-right: 1px solid #f1f5f9;">📰 Risiko Sentimen Berita AI</div>
                        <div style="padding: 20px; text-align: center; border-left: 1px solid #f1f5f9;">
                            <span style="font-weight: 800; font-size: 13px; padding: 6px 16px; border-radius: 8px; background: {{ $analysisA['news_risk'] >= 50 ? '#ffe4e6' : '#e0e7ff' }}; color: {{ $analysisA['news_risk'] >= 50 ? '#e11d48' : '#4f46e5' }}; border: 1px solid {{ $analysisA['news_risk'] >= 50 ? '#fda4af' : '#a5b4fc' }}; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                                Skor Sentimen: {{ $analysisA['news_risk'] }}
                            </span>
                        </div>
                        <div style="padding: 20px; text-align: center; border-left: 1px solid #f1f5f9;">
                            <span style="font-weight: 800; font-size: 13px; padding: 6px 16px; border-radius: 8px; background: {{ $analysisB['news_risk'] >= 50 ? '#ffe4e6' : '#e0e7ff' }}; color: {{ $analysisB['news_risk'] >= 50 ? '#e11d48' : '#4f46e5' }}; border: 1px solid {{ $analysisB['news_risk'] >= 50 ? '#fda4af' : '#a5b4fc' }}; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                                Skor Sentimen: {{ $analysisB['news_risk'] }}
                            </span>
                        </div>
                    </div>

                    <!-- 6. CURRENCY VARIATION (MONO TINT CORNER) -->
                    <div style="display: grid; grid-template-columns: 34% 33% 33%; align-items: center; background: #ffffff;">
                        <div style="padding: 20px 24px; font-weight: 700; color: #475569; background: #f8fafc; height: 100%; display: flex; align-items: center; border-right: 1px solid #f1f5f9;">💱 Mata Uang & Risiko Kurs</div>
                        <div style="padding: 20px; text-align: center; border-left: 1px solid #f1f5f9;">
                            <span style="background: #f1f5f9; color: #1e293b; padding: 5px 14px; border-radius: 6px; font-weight: 700; font-family: monospace; font-size: 13px; border: 1px solid #cbd5e1;">
                                💵 {{ $analysisA['model']->currency ?? 'Local Currency' }}
                            </span>
                            <div style="font-size: 11px; color: #64748b; margin-top: 6px; font-weight: 600;">Volatilitas Deviasi: <span style="color:#7c3aed;">{{ $analysisA['currency_risk'] }}</span></div>
                        </div>
                        <div style="padding: 20px; text-align: center; border-left: 1px solid #f1f5f9;">
                            <span style="background: #f1f5f9; color: #1e293b; padding: 5px 14px; border-radius: 6px; font-weight: 700; font-family: monospace; font-size: 13px; border: 1px solid #cbd5e1;">
                                💵 {{ $analysisB['model']->currency ?? 'Local Currency' }}
                            </span>
                            <div style="font-size: 11px; color: #64748b; margin-top: 6px; font-weight: 600;">Volatilitas Deviasi: <span style="color:#7c3aed;">{{ $analysisB['currency_risk'] }}</span></div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
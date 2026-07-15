<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        .watchlist-card {
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .watchlist-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 22px 35px -5px rgba(99, 102, 241, 0.15), 0 10px 20px -5px rgba(59, 130, 246, 0.1) !important;
            border-color: #6366f1 !important;
        }
        /* Efek kilau gradien di atas kartu saat di-hover */
        .watchlist-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #6366f1, #ec4899);
            opacity: 0.7;
            transition: opacity 0.3s;
        }
        .watchlist-card:hover::before {
            opacity: 1;
        }
        .btn-monitor {
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            transition: all 0.25s ease;
        }
        .btn-monitor:hover {
            background: linear-gradient(135deg, #1d4ed8, #4338ca);
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
            transform: scale(1.02);
        }
        .pulse-dot {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(34, 197, 94, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            {{ __('Daftar Pantau Supply Chain') }}
        </h2>
    </x-slot>

    <div style="padding: 48px 0; background-color: #f1f5f9; min-height: 85vh; font-family: 'Plus Jakarta Sans', system-ui, sans-serif;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 24px;">
            
            <div style="background-color: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.02); padding: 40px;">
                
                <div style="margin-bottom: 36px; border-bottom: 1px solid #f1f5f9; padding-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                            <span style="font-size: 20px;">🛡️</span>
                            <h3 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.02em;">
                                Radar Pengawasan Rantai Pasok
                            </h3>
                        </div>
                        <p style="font-size: 14px; color: #64748b; margin: 0; line-height: 1.5;">
                            Memantau metrik risiko, sentimen berita AI, dan gangguan logistik global secara real-time.
                        </p>
                    </div>
                    <div style="background-color: #eff6ff; border: 1px solid #bfdbfe; padding: 6px 16px; border-radius: 9999px; display: flex; align-items: center; gap: 8px;">
                        <span class="pulse-dot" style="width: 8px; height: 8px; background-color: #22c55e; border-radius: 50%; display: inline-block;"></span>
                        <span style="font-size: 12px; font-weight: 700; color: #1e40af; text-transform: uppercase; letter-spacing: 0.05em;">
                            Sistem Monitoring Aktif
                        </span>
                    </div>
                </div>

                @if($watchedCountries->isEmpty())
                    <div style="text-align: center; padding: 80px 24px; background: linear-gradient(135deg, #f8fafc, #f1f5f9); border-radius: 16px; border: 2px dashed #cbd5e1;">
                        <div style="font-size: 48px; margin-bottom: 16px; filter: drop-shadow(0 10px 15px rgba(99,102,241,0.15));">✨</div>
                        <h4 style="font-size: 18px; font-weight: 700; color: #334155; margin: 0 0 8px 0;">Radar Pengawasan Masih Bersih</h4>
                        <p style="color: #64748b; font-size: 14px; max-width: 440px; margin: 0 auto 24px auto; line-height: 1.6;">
                            Belum ada wilayah logistik yang ditambahkan. Aktifkan deteksi risiko dengan memasukkan negara prioritas Anda.
                        </p>
                        <a href="{{ route('countries.index') }}" style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #1e293b, #0f172a); color: #ffffff; font-size: 13px; font-weight: 600; padding: 12px 24px; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 12px rgba(15,23,42,0.15); transition: opacity 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            Mulai Cari Negara <span style="font-size: 14px;">→</span>
                        </a>
                    </div>
                @else
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 28px;">
                        @foreach($watchedCountries as $item)
                            <div class="watchlist-card" style="border: 1px solid #e2e8f0; border-radius: 16px; padding: 26px; background-color: #ffffff; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.01), 0 2px 4px -1px rgba(0,0,0,0.01);">
                                
                                <div style="display: flex; align-items: flex-start; gap: 18px; margin-bottom: 24px;">
                                    @if($item->flag)
                                        <img src="{{ $item->flag }}" style="width: 60px; height: 42px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 6px 10px rgba(0,0,0,0.08);">
                                    @else
                                        <div style="width: 60px; height: 42px; background: linear-gradient(135deg, #e2e8f0, #cbd5e1); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px; border: 1px solid #cbd5e1;">🌐</div>
                                    @endif
                                    
                                    <div style="flex: 1;">
                                        <h4 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0 0 6px 0; line-height: 1.3; letter-spacing: -0.01em;">
                                            {{ $item->name }}
                                        </h4>
                                        <span style="display: inline-block; font-size: 10px; font-weight: 800; color: #4338ca; background-color: #e0e7ff; padding: 3px 10px; border-radius: 6px; text-transform: uppercase; font-family: monospace; letter-spacing: 0.05em;">
                                            ISO: {{ $item->code }}
                                        </span>
                                    </div>
                                </div>

                                <div style="border-top: 1px solid #f1f5f9; padding-top: 18px; display: flex; justify-content: space-between; align-items: center;">
                                    <div style="display: flex; flex-direction: column; gap: 4px;">
                                        <span style="font-size: 10px; color: #94a3b8; text-transform: uppercase; font-weight: 700; letter-spacing: 0.08em;">Wilayah Operasi</span>
                                        <span style="font-size: 12px; color: #065f46; background-color: #d1fae5; padding: 4px 10px; border-radius: 6px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                            🗺️ {{ $item->region ?? 'Global Zone' }}
                                        </span>
                                    </div>
                                    
                                    <div>
                                        <a href="{{ route('countries.show', $item->id) }}" class="btn-monitor"
                                           style="color: #ffffff; font-size: 12px; font-weight: 700; padding: 10px 18px; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                                            Analisis Risiko 📊
                                        </a>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
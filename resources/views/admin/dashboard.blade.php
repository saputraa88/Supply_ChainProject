<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight" style="font-family: system-ui, sans-serif; letter-spacing: -0.5px;">
                🛡️ Control Center <span style="font-size: 13px; font-weight: 700; color: #ffffff; margin-left: 10px; vertical-align: middle; background: #4f46e5; padding: 6px 14px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Administrator Mode</span>
            </h2>
        </div>
    </x-slot>

    <div style="padding: 40px 0; background-color: #f8fafc; min-height: 90vh; font-family: system-ui, -apple-system, sans-serif;">
        <div style="max-width: 1040px; margin: 0 auto; padding: 0 24px;">
            
            <!-- 1. STATIS EXECUTIVE GRID METRIC CARDS (KONTRAS WARNA DIPERTINGGI) -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 24px; margin-bottom: 36px;">
                
                <!-- Total Pengguna -->
                <div style="background: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 5px solid #2563eb;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Total Pengguna</div>
                        <span style="font-size: 18px; background: #dbeafe; padding: 8px; border-radius: 10px;">👥</span>
                    </div>
                    <div style="font-size: 36px; font-weight: 800; color: #1e3a8a; margin-top: 8px; letter-spacing: -1px;">{{ $stats['total_users'] }}</div>
                    <div style="font-size: 12px; color: #64748b; margin-top: 4px; font-weight: 500;">Operator terdaftar di sistem</div>
                </div>

                <!-- Dataset Negara -->
                <div style="background: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 5px solid #10b981;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Dataset Negara</div>
                        <span style="font-size: 18px; background: #d1fae5; padding: 8px; border-radius: 10px;">🌐</span>
                    </div>
                    <div style="font-size: 36px; font-weight: 800; color: #065f46; margin-top: 8px; letter-spacing: -1px;">{{ $stats['total_countries'] }}</div>
                    <div style="font-size: 12px; color: #10b981; margin-top: 4px; font-weight: 700;">✓ Terintegrasi Live REST API</div>
                </div>

                <!-- Infrastruktur Pelabuhan -->
                <div style="background: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 5px solid #f59e0b;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Infrastruktur Pelabuhan</div>
                        <span style="font-size: 18px; background: #fef3c7; padding: 8px; border-radius: 10px;">⚓</span>
                    </div>
                    <div style="font-size: 36px; font-weight: 800; color: #9a3412; margin-top: 8px; letter-spacing: -1px;">{{ $stats['total_ports'] }}</div>
                    <div style="font-size: 12px; color: #64748b; margin-top: 4px; font-weight: 500;">Simpul logistik maritim</div>
                </div>

                <!-- Status Sistem (Cyber Dark Flat - Dipertajam Kontrasnya) -->
                <div style="background: #0f172a; padding: 24px; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); color: #ffffff; border: 1px solid #1e293b;">
                    <div style="font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em;">Status Core Engine</div>
                    <div style="margin-top: 12px;">
                        <span style="font-size: 14px; font-weight: 700; color: #4ade80; background: #064e3b; padding: 6px 16px; border-radius: 8px; border: 1px solid #047857; display: inline-flex; align-items: center; gap: 8px;">
                            <span style="width: 8px; height: 8px; background: #4ade80; border-radius: 50%; display: inline-block;"></span>
                            {{ strtoupper($stats['system_status']) }}
                        </span>
                    </div>
                    <div style="font-size: 11px; color: #94a3b8; margin-top: 14px; font-family: monospace; letter-spacing: 0.5px;">AI Lexicon Engine: Online</div>
                </div>
            </div>

            <!-- 2. MANAJEMEN PENGGUNA TABEL DENGAN HEADER GELAP (DARK HEADER STYLE) -->
            <div style="background: #ffffff; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 36px;">
                <div style="padding: 24px 30px; border-bottom: 2px solid #e2e8f0; background: linear-gradient(to right, #ffffff, #f8fafc);">
                    <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; letter-spacing: -0.3px;">👥 Otoritas Manajemen Pengguna</h3>
                    <p style="font-size: 12px; color: #64748b; margin-top: 2px;">Daftar otentikasi resmi tingkat hak akses kontroler dalam jaringan suplai perusahaan.</p>
                </div>
                
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                        <thead>
                            <!-- Perubahan Utama: Menggunakan Background Gelap agar Tabel Terlihat Tegas & Mahal -->
                            <tr style="background: #1e293b; color: #ffffff; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">
                                <th style="padding: 16px 30px; border-right: 1px solid #334155;">Nama Terdaftar</th>
                                <th style="padding: 16px 30px; border-right: 1px solid #334155;">Alamat Email</th>
                                <th style="padding: 16px 30px; border-right: 1px solid #334155;">Tanggal Registrasi</th>
                                <th style="padding: 16px 30px; text-align: center;">Tingkat Otoritas (Role)</th>
                            </tr>
                        </thead>
                        <tbody style="color: #334155;">
                            @foreach($users as $user)
                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                <td style="padding: 16px 30px; font-weight: 700; color: #0f172a;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 34px; height: 34px; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 12px; color: #1e293b; font-weight: 800; font-family: monospace;">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td style="padding: 16px 30px; font-family: monospace; color: #334155; font-weight: 500;">{{ $user->email }}</td>
                                <td style="padding: 16px 30px; color: #475569; font-weight: 500;">{{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}</td>
                                
                                <td style="padding: 16px 30px; text-align: center;">
                                    @if($user->role === 'admin')
                                        <span style="font-size: 12px; font-weight: 700; background: #f5f3ff; color: #5b21b6; padding: 6px 16px; border-radius: 6px; border: 1px solid #ddd6fe; box-shadow: 0 1px 2px rgba(0,0,0,0.05); display: inline-block;">
                                            👑 Admin Access
                                        </span>
                                    @else
                                        <span style="font-size: 12px; font-weight: 700; background: #f0fdf4; color: #166534; padding: 6px 16px; border-radius: 6px; border: 1px solid #bbf7d0; box-shadow: 0 1px 2px rgba(0,0,0,0.05); display: inline-block;">
                                            👤 User Operator
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div style="padding: 16px 30px; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                    {{ $users->links() }}
                </div>
            </div>

            <!-- 3. TIMELINE LOG INTEGRASI ENGINE AI (KONTRAS TINGGI & SOLID) -->
            <div style="background: #ffffff; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; overflow: hidden;">
                <div style="padding: 24px 30px; border-bottom: 2px solid #e2e8f0; background: linear-gradient(to right, #ffffff, #f8fafc);">
                    <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; letter-spacing: -0.3px;">🤖 Log Otomatisasi & Aktivitas Engine AI</h3>
                    <p style="font-size: 12px; color: #64748b; margin-top: 2px;">Rekam jejak pipa data (*AI Data Pipeline*) dan sinkronisasi berkala dari API eksternal.</p>
                </div>
                
                <div style="padding: 30px; background: #ffffff;">
                    <div style="border-left: 3px solid #cbd5e1; margin-left: 8px; padding-left: 24px; display: flex; flex-direction: column; gap: 24px;">
                        @foreach($systemLogs as $log)
                        <div style="position: relative;">
                            <!-- Titik Bulat Dipertebal dengan Outline Solid -->
                            <div style="position: absolute; left: -31px; top: 4px; width: 12px; height: 12px; background: {{ $log['color'] }}; border: 2px solid #ffffff; border-radius: 50%;"></div>
                            
                            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-start; gap: 8px; background: #f8fafc; padding: 16px 20px; border-radius: 10px; border: 1px solid #e2e8f0;">
                                <div style="flex: 1; min-width: 250px;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <span style="font-size: 11px; font-family: monospace; font-weight: 700; color: #ffffff; background: #475569; padding: 3px 8px; border-radius: 4px;">
                                            {{ $log['timestamp'] }}
                                        </span>
                                        <span style="font-size: 14px; font-weight: 800; color: #0f172a;">
                                            {{ $log['service'] }}
                                        </span>
                                    </div>
                                    <p style="font-size: 13px; color: #1e293b; margin-top: 8px; line-height: 1.5; font-weight: 500;">
                                        {{ $log['message'] }}
                                    </p>
                                </div>
                                
                                <span style="font-size: 11px; font-weight: 800; color: #ffffff; background: {{ $log['color'] }}; padding: 4px 12px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.05em; border: 1px solid rgba(0,0,0,0.1);">
                                    {{ $log['type'] }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
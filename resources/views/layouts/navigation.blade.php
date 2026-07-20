<nav style="width: 265px; height: 100vh; background-color: #0b1120; color: #e2e8f0; display: flex; flex-direction: column; justify-content: space-between; border-right: 1px solid #1e293b; box-sizing: border-box; flex-shrink: 0; z-index: 99; font-family: 'Figtree', system-ui, -apple-system, sans-serif;">
    
    <!-- BAGIAN ATAS: Branding & List Navigasi Menu -->
    <div style="display: flex; flex-direction: column;">
        
        <!-- Header Brand Aplikasi (Sudut Rounded & Soft) -->
        <div style="padding: 28px 24px; display: flex; align-items: center; gap: 14px;">
            <div style="width: 44px; height: 44px; background: linear-gradient(135deg, #3b82f6, #06b6d4); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; box-shadow: 0 4px 20px rgba(59, 130, 246, 0.25);">
                ⚓
            </div>
            <div style="display: flex; flex-direction: column; gap: 3px;">
                <h1 style="color: #ffffff; font-size: 15px; font-weight: 800; margin: 0; line-height: 1.2; letter-spacing: 0.8px;">PORTAL MARITIM</h1>
                <span style="color: #06b6d4; font-size: 10px; font-weight: 700; margin: 0; letter-spacing: 0.5px;">CONTROL DASHBOARD</span>
            </div>
        </div>

        <!-- Wadah Link Navigasi Menurun (Sudut Diperlembut ke 14px) -->
        <div style="padding: 10px 16px; display: flex; flex-direction: column; gap: 6px;">

            @if(Auth::user()->role === 'admin')
                <!-- MENU ADMIN -->
                <a href="{{ route('admin.dashboard') }}" 
                   style="display: flex; align-items: center; gap: 14px; padding: 12px 18px; border-radius: 14px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.25s; {{ request()->routeIs('admin.dashboard') ? 'background: linear-gradient(135deg, #3b82f6, #8b5cf6); color: #ffffff; box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35); font-weight: 800;' : 'color: #cbd5e1;' }}"
                   @if(!request()->routeIs('admin.dashboard')) onmouseover="this.style.backgroundColor='#1e293b'; this.style.color='#ffffff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#cbd5e1';" @endif>
                    <i class="bi bi-shield-lock-fill" style="font-size: 16px; color: #f43f5e;"></i>
                    <span>Panel Admin</span>
                </a>
            @else
                <!-- MENU USER BIASA -->
                
                <!-- 1. Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   style="display: flex; align-items: center; gap: 14px; padding: 12px 18px; border-radius: 14px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.25s; {{ request()->routeIs('dashboard') ? 'background: linear-gradient(135deg, #3b82f6, #8b5cf6); color: #ffffff; box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35); font-weight: 800;' : 'color: #cbd5e1;' }}"
                   @if(!request()->routeIs('dashboard')) onmouseover="this.style.backgroundColor='#1e293b'; this.style.color='#ffffff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#cbd5e1';" @endif>
                    <i class="bi bi-grid-1x2-fill" style="font-size: 16px; color: {{ request()->routeIs('dashboard') ? '#ffffff' : '#06b6d4' }};"></i>
                    <span>Dashboard</span>
                </a>

                <!-- 2. Negara -->
                <a href="{{ route('countries.index') }}" 
                   style="display: flex; align-items: center; gap: 14px; padding: 12px 18px; border-radius: 14px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.25s; {{ (request()->routeIs('countries.*') && !request()->routeIs('countries.comparison')) ? 'background: linear-gradient(135deg, #3b82f6, #8b5cf6); color: #ffffff; box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35); font-weight: 800;' : 'color: #cbd5e1;' }}"
                   @if(!(request()->routeIs('countries.*') && !request()->routeIs('countries.comparison'))) onmouseover="this.style.backgroundColor='#1e293b'; this.style.color='#ffffff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#cbd5e1';" @endif>
                    <i class="bi bi-flag-fill" style="font-size: 16px; color: {{ (request()->routeIs('countries.*') && !request()->routeIs('countries.comparison')) ? '#ffffff' : '#10b981' }};"></i>
                    <span>Negara</span>
                </a>

                <!-- 3. Daftar Pantau -->
                <a href="{{ route('watchlist.index') }}" 
                   style="display: flex; align-items: center; gap: 14px; padding: 12px 18px; border-radius: 14px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.25s; {{ request()->routeIs('watchlist.index') ? 'background: linear-gradient(135deg, #3b82f6, #8b5cf6); color: #ffffff; box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35); font-weight: 800;' : 'color: #cbd5e1;' }}"
                   @if(!request()->routeIs('watchlist.index')) onmouseover="this.style.backgroundColor='#1e293b'; this.style.color='#ffffff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#cbd5e1';" @endif>
                    <i class="bi bi-eye-fill" style="font-size: 16px; color: {{ request()->routeIs('watchlist.index') ? '#ffffff' : '#f59e0b' }};"></i>
                    <span>Daftar Pantau</span>
                </a>

                <!-- 4. Pelabuhan -->
                <a href="{{ route('ports.index') }}" 
                   style="display: flex; align-items: center; gap: 14px; padding: 12px 18px; border-radius: 14px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.25s; {{ request()->routeIs('ports.*') ? 'background: linear-gradient(135deg, #3b82f6, #8b5cf6); color: #ffffff; box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35); font-weight: 800;' : 'color: #cbd5e1;' }}"
                   @if(!request()->routeIs('ports.*')) onmouseover="this.style.backgroundColor='#1e293b'; this.style.color='#ffffff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#cbd5e1';" @endif>
                    <i class="bi bi-compass-fill" style="font-size: 16px; color: {{ request()->routeIs('ports.*') ? '#ffffff' : '#3b82f6' }};"></i>
                    <span>Pelabuhan</span>
                </a>

                <!-- 5. Bandingkan -->
                <a href="{{ route('countries.comparison') }}" 
                   style="display: flex; align-items: center; gap: 14px; padding: 12px 18px; border-radius: 14px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.25s; {{ request()->routeIs('countries.comparison') ? 'background: linear-gradient(135deg, #3b82f6, #8b5cf6); color: #ffffff; box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35); font-weight: 800;' : 'color: #cbd5e1;' }}"
                   @if(!request()->routeIs('countries.comparison')) onmouseover="this.style.backgroundColor='#1e293b'; this.style.color='#ffffff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#cbd5e1';" @endif>
                    <i class="bi bi-arrow-left-right" style="font-size: 16px; color: {{ request()->routeIs('countries.comparison') ? '#ffffff' : '#d946ef' }};"></i>
                    <span>Bandingkan</span>
                </a>

                <!-- 6. Daftar Kurs -->
                <a href="{{ route('currency.index') }}" 
                   style="display: flex; align-items: center; gap: 14px; padding: 12px 18px; border-radius: 14px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.25s; {{ request()->routeIs('currency.index') ? 'background: linear-gradient(135deg, #3b82f6, #8b5cf6); color: #ffffff; box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35); font-weight: 800;' : 'color: #cbd5e1;' }}"
                   @if(!request()->routeIs('currency.index')) onmouseover="this.style.backgroundColor='#1e293b'; this.style.color='#ffffff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#cbd5e1';" @endif>
                    <i class="bi bi-cash-coin" style="font-size: 16px; color: {{ request()->routeIs('currency.index') ? '#ffffff' : '#f97316' }};"></i>
                    <span>Daftar Kurs</span>
                </a>

                <!-- 7. Visualisasi Data -->
                <a href="{{ route('historical.index') }}" 
                   style="display: flex; align-items: center; gap: 14px; padding: 12px 18px; border-radius: 14px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.25s; {{ request()->routeIs('historical.index') ? 'background: linear-gradient(135deg, #3b82f6, #8b5cf6); color: #ffffff; box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35); font-weight: 800;' : 'color: #cbd5e1;' }}"
                   @if(!request()->routeIs('historical.index')) onmouseover="this.style.backgroundColor='#1e293b'; this.style.color='#ffffff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#cbd5e1';" @endif>
                    <i class="bi bi-bar-chart-line-fill" style="font-size: 16px; color: {{ request()->routeIs('historical.index') ? '#ffffff' : '#f43f5e' }};"></i>
                    <span>Visualisasi Data</span>
                </a>
            @endif

        </div>
    </div>

    <!-- BAGIAN BAWAH: Profil Pengguna & Sistem Keluar (Clean & Smooth) -->
    <div style="padding: 20px 16px; background-color: #070a13; display: flex; flex-direction: column; gap: 12px;">
        
        <!-- Informasi User Terhubung -->
        <div style="display: flex; align-items: center; gap: 12px; padding: 0 8px;">
            <div style="width: 40px; height: 40px; border-radius: 12px; background-color: #2563eb; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 16px; text-transform: uppercase; border: 1px solid rgba(255,255,255,0.15);">
                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
            </div>
            <div style="display: flex; flex-direction: column; min-width: 0; flex: 1; overflow: hidden;">
                <p style="color: #ffffff; font-size: 14px; font-weight: 800; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ Auth::user()->name }}</p>
                <span style="color: #64748b; font-size: 11px; font-weight: 600; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ Auth::user()->email }}</span>
            </div>
        </div>

        <!-- Link Pengaturan Profil & Keluar -->
        <div style="display: flex; flex-direction: column; gap: 4px;">
            <a href="{{ route('profile.edit') }}" 
               style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; color: #cbd5e1; text-decoration: none; font-size: 13px; font-weight: 700; border-radius: 12px; transition: all 0.2s;"
               onmouseover="this.style.backgroundColor='#1e293b'; this.style.color='#ffffff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#cbd5e1';">
                <i class="bi bi-person-circle" style="color: #3b82f6; font-size: 15px;"></i>
                <span>Pengaturan Profil</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" style="margin: 0; padding: 0;">
                @csrf
                <button type="submit" 
                        style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; color: #cbd5e1; text-decoration: none; font-size: 13px; font-weight: 700; border-radius: 12px; transition: all 0.2s; width: 100%; border: none; background: transparent; text-align: left; cursor: pointer; font-family: inherit;"
                        onmouseover="this.style.backgroundColor='rgba(239,68,68,0.08)'; this.style.color='#ef4444';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#cbd5e1';">
                    <i class="bi bi-box-arrow-right" style="color: #ef4444; font-size: 15px;"></i>
                    <span>Keluar Aplikasi</span>
                </button>
            </form>
        </div>
    </div>

</nav>
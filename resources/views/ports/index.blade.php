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

    <div style="padding: 40px 0; background-color: #f3f4f6; min-height: 85vh;">
        <div style="max-width: 1024px; margin: 0 auto; padding: 0 20px;">

            @if(session('success'))
                <div style="background-color: #ecfdf5; border-left: 4px solid #10b981; color: #065f46; padding: 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px; font-weight: 500;">
                    🎉 {{ session('success') }}
                </div>
            @endif

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
</x-app-layout>
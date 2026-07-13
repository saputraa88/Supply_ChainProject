<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pantau Supply Chain') }}
        </h2>
    </x-slot>

    <div style="padding: 32px 0; background-color: #f3f4f6; min-height: 80vh;">
        <div style="max-width: 1024px; margin: 0 auto; padding: 0 16px;">
            <div style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); padding: 32px;">
                
                <h3 style="font-size: 18px; font-weight: 700; color: #111827; margin-bottom: 6px;">
                    Negara dalam Pengawasan Khusus
                </h3>
                <p style="font-size: 14px; color: #6b7280; margin-bottom: 24px;">
                    Berikut adalah daftar wilayah prioritas monitoring rantai pasok global Anda yang aktif.
                </p>

                @if($watchedCountries->isEmpty())
                    <div style="text-align: center; padding: 48px; background-color: #f9fafb; border-radius: 8px; border: 2px dashed #e5e7eb;">
                        <span style="font-size: 24px;">⭐</span>
                        <p style="color: #6b7280; font-size: 14px; margin: 12px 0 0 0; font-weight: 500;">
                            Belum ada negara yang dipantau. 
                        </p>
                        <a href="{{ route('countries.index') }}" style="display: inline-block; margin-top: 12px; font-size: 13px; color: #2563eb; font-weight: 600; text-decoration: none;">
                            Cari Negara untuk Dipantau →
                        </a>
                    </div>
                @else
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                        @foreach($watchedCountries as $item)
                            <div style="border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; background-color: #ffffff; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: box-shadow 0.2s;"
                                 onmouseover="this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.1)'"
                                 onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'">
                                
                                <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px;">
                                    @if($item->flag)
                                        <img src="{{ $item->flag }}" style="width: 48px; height: auto; border-radius: 6px; border: 1px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    @else
                                        <div style="width: 48px; height: 32px; background-color: #e5e7eb; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #9ca3af;">No Flag</div>
                                    @endif
                                    
                                    <div>
                                        <h4 style="font-size: 16px; font-weight: 700; color: #111827; margin: 0;">
                                            {{ $item->name }}
                                        </h4>
                                        <span style="display: inline-block; font-size: 11px; font-weight: 600; color: #4b5563; background-color: #f3f4f6; padding: 2px 6px; border-radius: 4px; margin-top: 4px;">
                                            {{ $item->code }}
                                        </span>
                                    </div>
                                </div>

                                <div style="border-top: 1px solid #f3f4f6; padding-top: 12px; display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 12px; color: #6b7280;">
                                        Reg: <strong>{{ $item->region ?? '-' }}</strong>
                                    </span>
                                    
                                    <div style="display: flex; gap: 8px;">
                                        <a href="{{ route('countries.show', $item->id) }}" 
                                           style="background-color: #2563eb; color: #ffffff; font-size: 12px; font-weight: 600; padding: 6px 14px; border-radius: 6px; text-decoration: none; transition: background 0.2s;"
                                           onmouseover="this.style.backgroundColor='#1d4ed8'"
                                           onmouseout="this.style.backgroundColor='#2563eb'">
                                            Buka Monitor
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
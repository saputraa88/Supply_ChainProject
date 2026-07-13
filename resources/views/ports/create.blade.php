<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('⚓ Registrasi Gerbang Pelabuhan Baru') }}
        </h2>
    </x-slot>

    <div style="padding: 40px 0; background-color: #f3f4f6; min-height: 85vh;">
        <div style="max-width: 600px; margin: 0 auto; padding: 0 20px;">
            
            <div style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 32px;">
                <form action="{{ route('ports.store') }}" method="POST">
                    @csrf

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 6px;">Nama Pelabuhan</label>
                        <input type="text" name="name" required placeholder="Contoh: Port of Tanjung Priok" style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 10px 12px; font-size: 14px;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 6px;">Kode Protokol (LOCODE)</label>
                        <input type="text" name="code" placeholder="Contoh: IDTPP" style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 10px 12px; font-size: 14px;">
                    </div>

                    <div style="margin-bottom: 28px;">
                        <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 6px;">Negara Pemilik Wilayah</label>
                        <select name="country_id" required style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 10px 12px; font-size: 14px; background-color: #fff;">
                            <option value="">-- Pilih Negara Koordinat --</option>
                            @foreach(\App\Models\Country::orderBy('name')->get() as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 12px;">
                        <a href="{{ route('ports.index') }}" style="background-color: #e5e7eb; color: #374151; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none;">Batal</a>
                        <button type="submit" style="background-color: #10b981; color: #ffffff; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; border: none; cursor: pointer;">Simpan Infrastruktur</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
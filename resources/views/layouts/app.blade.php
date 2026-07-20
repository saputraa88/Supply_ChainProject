<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body style="margin: 0; padding: 0; font-family: 'Figtree', sans-serif; background-color: #f1f5f9; -webkit-font-smoothing: antialiased;">
        
        <div style="display: flex; width: 100vw; height: 100vh; overflow: hidden; box-sizing: border-box;">
            
            <!-- KOLOM KIRI: Sidebar Premium -->
            @include('layouts.navigation')

            <!-- KOLOM KANAN: Area Kerja Konten (Bebas dari Kotak Kaku) -->
            <div style="flex: 1; display: flex; flex-direction: column; min-width: 0; height: 100vh; overflow: hidden;">
                
                <!-- Area Konten Utama yang Menyatu dengan Header -->
                <main style="flex: 1; overflow-y: auto; padding: 40px; box-sizing: border-box;">
                    <div style="max-width: 1200px; margin: 0 auto; display: flex; flex-direction: column; gap: 28px;">
                        
                        <!-- Judul Halaman yang Seamless & Elegan -->
                        @isset($header)
                            <div style="margin-bottom: 4px;">
                                <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; tracking: -0.5px; margin: 0;">
                                    {{ $header }}
                                </h2>
                            </div>
                        @endisset

                        <!-- Tempat Komponen Kartu & Peta -->
                        <div style="display: flex; flex-direction: column; gap: 28px;">
                            {{ $slot }}
                        </div>
                        
                    </div>
                </main>
                
            </div>
        </div>
    </body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAKAD — Nothing OS / Teenage Engineering Aesthetic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Space Grotesk"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        void: '#000000',
                        signal: '#ff3b30',
                        cobalt: '#0047ff',
                        surface: '#f4f4f6',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #f4f4f6;
            color: #111827;
            font-family: 'Space Grotesk', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        /* Subtle Engineering Dot Grid */
        .bg-engineering-grid {
            background-image: radial-gradient(#d1d5db 1px, transparent 1px);
            background-size: 20px 20px;
        }
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: #f4f4f6; }
        ::-webkit-scrollbar-thumb { background: #000000; border-radius: 2px; }
        ::-webkit-scrollbar-thumb:hover { background: #ff3b30; }
    </style>
</head>
<body class="min-h-screen bg-engineering-grid flex selection:bg-void selection:text-white" 
      x-data="{ 
          tab: 'overview',
          time: '09:05:00',
          selectedClass: '1A',
          rooms: [
              { code: '1A', name: 'Kelas 1 Alpha', teacher: 'Ibu Kartini, S.Pd', present: 30, sick: 2, alpha: 0, total: 32 },
              { code: '2B', name: 'Kelas 2 Beta', teacher: 'Bpk. Hendra, M.Pd', present: 32, sick: 0, alpha: 0, total: 32 },
              { code: '3A', name: 'Kelas 3 Alpha', teacher: 'Bpk. Surya, S.Pd', present: 31, sick: 1, alpha: 0, total: 32 },
              { code: '4A', name: 'Kelas 4 Alpha', teacher: 'Ibu Ratna, S.Pd', present: 29, sick: 3, alpha: 0, total: 32 },
              { code: '5B', name: 'Kelas 5 Beta', teacher: 'Bpk. Gunawan, S.Pd', present: 30, sick: 1, alpha: 1, total: 32 },
              { code: '6A', name: 'Kelas 6 Senior', teacher: 'Bpk. Budi Santoso, S.Pd', present: 32, sick: 0, alpha: 0, total: 32 }
          ]
      }" 
      x-init="setInterval(() => { time = new Date().toLocaleTimeString('id-ID', { hour12: false }) }, 1000)">

    <!-- SIDEBAR NAVIGATION (Pure White & Solid Black, Zero Gradients) -->
    <aside class="w-64 fixed inset-y-0 left-0 bg-white border-r border-black/10 p-6 flex flex-col justify-between z-50 select-none shadow-[4px_0_30px_rgba(0,0,0,0.02)]">
        <div class="space-y-8">
            <!-- Brand Logo -->
            <div class="flex items-center gap-3 px-1">
                <div class="w-10 h-10 rounded-xl bg-void text-white font-mono font-black text-sm flex items-center justify-center shrink-0 tracking-tighter">
                    SD1
                </div>
                <div>
                    <span class="font-extrabold tracking-tight text-void block text-sm leading-none">DURIAN GADANG</span>
                    <span class="text-[9px] font-mono uppercase tracking-[0.25em] text-signal font-bold block mt-1">System v3.0</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-1.5">
                <div class="px-3 pb-2 text-[10px] font-mono font-bold uppercase tracking-[0.25em] text-gray-400">Architecture</div>
                
                <button @click="tab = 'overview'" :class="tab === 'overview' ? 'bg-void text-white font-bold shadow-md' : 'text-gray-600 hover:text-void hover:bg-gray-100 font-medium'" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs transition-all text-left">
                    <i class="bi bi-grid-fill text-sm"></i>
                    <span>Matrix Overview</span>
                </button>

                <button @click="tab = 'pixels'" :class="tab === 'pixels' ? 'bg-void text-white font-bold shadow-md' : 'text-gray-600 hover:text-void hover:bg-gray-100 font-medium'" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs transition-all text-left">
                    <i class="bi bi-broadcast text-sm"></i>
                    <span>Live Running Text</span>
                </button>

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:text-void hover:bg-gray-100 font-medium text-xs transition-all">
                    <i class="bi bi-people-fill text-sm text-gray-400"></i>
                    <span>Peserta Didik</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:text-void hover:bg-gray-100 font-medium text-xs transition-all">
                    <i class="bi bi-person-badge-fill text-sm text-gray-400"></i>
                    <span>Tenaga Pendidik</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:text-void hover:bg-gray-100 font-medium text-xs transition-all">
                    <i class="bi bi-journal-text text-sm text-gray-400"></i>
                    <span>Kurikulum Merdeka</span>
                </a>
            </nav>
        </div>

        <!-- Bottom Sidebar Action -->
        <div class="pt-6 border-t border-black/10 space-y-4">
            <div class="p-3.5 rounded-xl bg-gray-50 border border-black/5 font-mono text-[11px]">
                <div class="flex items-center justify-between text-gray-500 mb-1.5 font-bold">
                    <span>STATUS</span>
                    <span class="text-signal flex items-center gap-1.5 font-bold">
                        <span class="w-2 h-2 rounded-full bg-signal animate-ping inline-block"></span> REC
                    </span>
                </div>
                <div class="text-void font-extrabold truncate">LIVE DAPODIK STREAM</div>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-white hover:bg-void text-void hover:text-white font-bold text-xs transition-all border border-black/10 shadow-xs group">
                <i class="bi bi-arrow-left text-sm transition-transform group-hover:-translate-x-1"></i>
                <span>Kembali ke Live Data</span>
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <main class="ml-64 flex-1 min-h-screen flex flex-col">

        <!-- TOP TICKER BAR HEADER -->
        <header class="h-20 bg-white/95 backdrop-blur-md border-b border-black/10 px-10 flex items-center justify-between sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <div class="w-3 h-3 rounded-full bg-signal animate-pulse"></div>
                <div>
                    <h1 class="text-xl font-black text-void tracking-tight uppercase">SIAKAD — TELEMETRY MATRIX v3.0</h1>
                    <span class="text-[11px] font-mono text-gray-500 block">DESIGNED FOR SDN 01 DURIAN GADANG // NO AI SLOP // NO GRADIENTS</span>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <!-- Live Digital Clock -->
                <div class="hidden sm:flex items-center gap-3 px-4 py-2 rounded-xl bg-gray-100 border border-black/10 font-mono text-sm font-black text-void">
                    <i class="bi bi-clock-fill text-signal"></i>
                    <span x-text="time">09:05:00</span>
                    <span class="text-[10px] text-gray-400">WIB</span>
                </div>

                <!-- User profile -->
                <div class="flex items-center gap-3 pl-4 border-l border-black/10">
                    <div class="w-10 h-10 rounded-xl bg-void text-white font-mono font-bold text-xs flex items-center justify-center">
                        KS
                    </div>
                </div>
            </div>
        </header>

        <!-- DASHBOARD CONTENT -->
        <div class="p-10 max-w-[1500px] w-full mx-auto space-y-8">

            <!-- TAB 1: OVERVIEW MATRIX (Modular Teenage Engineering Style) -->
            <div x-show="tab === 'overview'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-8">
                
                <!-- TOP HERO BENTO STRIP -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                    
                    <!-- Left Big Stat (Span 5) - Pitch Black Solid Modular Card -->
                    <div class="lg:col-span-5 bg-void text-white rounded-3xl p-8 shadow-xl flex flex-col justify-between border border-black">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-mono font-bold uppercase tracking-[0.2em] text-gray-400">Okupansi Kehadiran</span>
                            <span class="w-3 h-3 rounded-full bg-signal animate-pulse" title="Live Recording"></span>
                        </div>

                        <div class="my-6">
                            <div class="flex items-baseline gap-2">
                                <span class="text-7xl font-black font-mono tracking-tighter text-white">96.8</span>
                                <span class="text-3xl font-mono font-bold text-signal">%</span>
                            </div>
                            <p class="text-xs font-mono text-gray-400 mt-3 uppercase tracking-wider">
                                352 / 364 SISWA TERKONFIRMASI HADIR DI KELAS HARI INI.
                            </p>
                        </div>

                        <div class="pt-6 border-t border-white/20 flex items-center justify-between">
                            <span class="text-xs font-mono text-white font-bold">12 ROMBEL AKTIF</span>
                            <button @click="tab = 'pixels'" class="px-5 py-2.5 rounded-xl bg-white text-void font-bold text-xs hover:bg-signal hover:text-white transition-colors inline-flex items-center gap-2">
                                <span>BEDAH DENAH PIXEL</span>
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Right Modular Stats Grid (Span 7) -->
                    <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">
                        
                        <!-- Modular Card A -->
                        <div class="bg-white rounded-3xl p-8 border border-black/10 shadow-xs flex flex-col justify-between">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-mono font-bold uppercase tracking-widest text-gray-400">Total Peserta Didik</span>
                                <i class="bi bi-people-fill text-void text-xl"></i>
                            </div>
                            <div class="my-4">
                                <span class="text-5xl font-black font-mono tracking-tight text-void">364</span>
                                <span class="text-sm font-bold text-gray-400 ml-1">Siswa</span>
                            </div>
                            <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs font-mono font-bold text-gray-600">
                                <span>LAKI: 186</span>
                                <span>•</span>
                                <span>PEREMPUAN: 178</span>
                            </div>
                        </div>

                        <!-- Modular Card B -->
                        <div class="bg-white rounded-3xl p-8 border border-black/10 shadow-xs flex flex-col justify-between">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-mono font-bold uppercase tracking-widest text-gray-400">Tenaga Pendidik</span>
                                <i class="bi bi-person-badge-fill text-void text-xl"></i>
                            </div>
                            <div class="my-4">
                                <span class="text-5xl font-black font-mono tracking-tight text-void">24</span>
                                <span class="text-sm font-bold text-gray-400 ml-1">Guru</span>
                            </div>
                            <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs font-mono font-bold text-cobalt">
                                <span>RASIO IDEAL 1 : 15</span>
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <!-- TAB 2: PIXEL SEAT DENAH INSPECTOR -->
            <div x-show="tab === 'pixels'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="bg-white rounded-3xl p-8 border border-black/10 shadow-xs space-y-6">
                <div class="flex items-center justify-between pb-6 border-b border-gray-100">
                    <div>
                        <h3 class="text-xl font-black text-void uppercase">INSPEKSI DENAH PIXEL MENDALAM</h3>
                        <p class="text-xs font-mono text-gray-500 mt-1">Pemetaan bangku secara visual untuk analisis perilaku dan kehadiran peserta didik.</p>
                    </div>
                    <button @click="tab = 'overview'" class="px-5 py-2.5 rounded-xl bg-void text-white font-bold text-xs hover:bg-signal transition-colors inline-flex items-center gap-2">
                        <i class="bi bi-arrow-left"></i>
                        <span>KEMBALI KE MATRIX</span>
                    </button>
                </div>
                <div class="p-16 text-center text-gray-400 font-mono text-sm border-2 border-dashed border-gray-300 rounded-2xl bg-gray-50">
                    [ INTERACTIVE SEAT INSPECTION ACTIVE — ALL 364 SEATS SYNCHRONIZED ]
                </div>
            </div>

        </div>

    </main>

</body>
</html>

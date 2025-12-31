@php
    $navMenus = [
        [
            'label' => 'Dashboard',
            'icon'  => 'fa-house',
            'route' => 'dashboard',
            'active' => request()->routeIs('dashboard')
        ],
        [
            'label' => 'Riwayat',
            'icon'  => 'fa-history',
            'route' => 'riwayat.index',
            'active' => request()->routeIs('riwayat.*')
        ],
        //[
           // 'label' => 'Laporan',
            //'icon'  => 'fa-chart-line',
            //'route' => 'laporan.index',
            //'active' => request()->routeIs('laporan.*')
       // ],
    ];
@endphp

<aside id="sidebar" class="fixed left-0 top-0 h-full w-72 bg-[#4f46e5] shadow-2xl z-50 flex flex-col transition-all duration-300">
        <div class="p-8">
            <h1 class="text-2xl font-black text-white tracking-tighter italic">AturUangmu</h1>
        </div>
        <nav class="flex-1 px-4 space-y-2">
            @foreach($navMenus as $menu)
                <a href="{{ route($menu['route']) }}" 
                class="flex items-center px-6 py-4 rounded-2xl font-bold transition-all border 
                {{ $menu['active'] 
                        ? 'bg-white/20 text-white border-white/20 shadow-lg' 
                        : 'text-indigo-100 hover:bg-white/5 border-transparent' 
                }}">
                    <i class="fa-solid {{ $menu['icon'] }} mr-4 text-lg"></i> 
                    <span class="nav-text">{{ $menu['label'] }}</span>
                </a>
            @endforeach
        </nav>
        <div class="p-6 border-t border-white/10 bg-indigo-700/30">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-indigo-600 font-black shadow-lg">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div class="ml-4">
                    <p class="text-sm font-black text-white leading-none mb-1">{{ Auth::user()->name }}</p>
                    
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-red-900/20">
                    <i class="fa-solid fa-power-off mr-2"></i> Keluar
                </button>
            </form>
        </div>
</aside>
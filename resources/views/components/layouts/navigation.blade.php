<aside id="sidebar"
    class="fixed left-0 top-0 h-screen w-72 bg-[#4f46e5] shadow-2xl z-50 flex flex-col transition-all duration-300 overflow-hidden">
    
    <div class="p-8 flex-shrink-0">
        <h1 class="text-2xl font-black text-white tracking-tighter italic">AturUangmu</h1>
    </div>

    <nav class="flex-1 px-4 space-y-2 overflow-y-auto custom-scrollbar pb-10">
        @foreach (config('menus.navMenus') as $menu)
            <a href="{{ route($menu['route']) }}"
                class="flex items-center px-6 py-4 rounded-2xl font-bold transition-all border 
               {{ request()->routeIs($menu['active'])
                   ? 'bg-white/20 text-white border-white/20 shadow-lg'
                   : 'text-indigo-100 hover:bg-white/5 border-transparent' }}">
                <i class="fa-solid {{ $menu['icon'] }} mr-4 text-lg"></i>
                <span class="nav-text">{{ __($menu['label']) }}</span>
            </a>
        @endforeach

        <div x-data="{ open: false }" class="mt-4">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-6 py-4 rounded-2xl font-bold transition-all border border-transparent text-indigo-100 hover:bg-white/5">
                <div class="flex items-center">
                    <i class="fa-solid fa-gear mr-4 text-lg"></i>
                    <span>{{ __('messages.settings') }}</span>
                </div>
                <i class="fa-solid fa-chevron-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
            </button>

            <div x-show="open" x-transition class="mt-2 ml-6 space-y-4 border-l-2 border-white/10 pl-4 pb-4">
                <div>
                    <p class="text-[10px] text-indigo-200 font-bold mb-2 tracking-widest uppercase">
                        <i class="fa-solid fa-language"></i> {{ __('messages.language') }}
                    </p>
                    <div class="flex gap-2">
                        <a href="{{ route('lang.switch', 'id') }}"
                            class="text-xs px-3 py-1.5 rounded-lg font-bold transition-all {{ app()->getLocale() == 'id' ? 'bg-white text-indigo-600' : 'text-white hover:bg-white/10' }}">ID</a>
                        <a href="{{ route('lang.switch', 'en') }}"
                            class="text-xs px-3 py-1.5 rounded-lg font-bold transition-all {{ app()->getLocale() == 'en' ? 'bg-white text-indigo-600' : 'text-white hover:bg-white/10' }}">EN</a>
                    </div>
                </div>
                
                <div>
                     <p class="text-[10px] text-indigo-200 font-bold mb-2 tracking-widest uppercase flex items-center">
                        <i class="fa-solid fa-coins mr-2"></i> {{ __('messages.currency') }}
                    </p>
                    <div class="flex gap-2">
                        <a href="{{ route('currency.switch', 'IDR') }}"
                            class="flex-1 flex items-center justify-center py-2 rounded-lg text-xs font-bold transition-all
                            {{ session('currency', 'IDR') == 'IDR' ? 'bg-white text-indigo-600' : 'text-white border border-white/10' }}">
                            IDR
                        </a>
                        <a href="{{ route('currency.switch', 'USD') }}"
                            class="flex-1 flex items-center justify-center py-2 rounded-lg text-xs font-bold transition-all
                            {{ session('currency') == 'USD' ? 'bg-white text-indigo-600' : 'text-white border border-white/10' }}">
                            USD
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="p-6 border-t border-white/10 bg-indigo-700/30 flex-shrink-0">
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
            <button type="submit"
                class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-red-900/20">
                <i class="fa-solid fa-power-off mr-2"></i>{{ __('messages.btn_logout') }}
            </button>
        </form>
    </div>
</aside>
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
</style>
<div 
    x-data="{ show: true }" 
    x-init="setTimeout(() => show = false, 4000)"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-[-20px]"
    x-transition:enter-end="opacity-100 translate-y-0"
    class="fixed top-6 right-6 z-[9999] flex flex-col gap-3"
>
    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="flex items-center p-4 space-x-4 bg-white rounded-2xl shadow-xl border-l-4 border-emerald-500 min-w-[300px]">
            <div class="flex-shrink-0 w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500 font-bold">✓</div>
            <div class="flex-1">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Berhasil</p>
                <p class="text-sm font-bold text-slate-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Notifikasi Gagal --}}
    @if(session('error'))
        <div class="flex items-center p-4 space-x-4 bg-white rounded-2xl shadow-xl border-l-4 border-rose-500 min-w-[300px]">
            <div class="flex-shrink-0 w-10 h-10 bg-rose-50 rounded-xl flex items-center justify-center text-rose-500 font-bold">✕</div>
            <div class="flex-1">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Gagal</p>
                <p class="text-sm font-bold text-slate-800">{{ session('error') }}</p>
            </div>
        </div>
    @endif
</div>
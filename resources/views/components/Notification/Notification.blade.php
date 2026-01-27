<div 
    x-data="{ show: true }" 
    x-init="setTimeout(() => show = false, 5000)"
    x-show="show"
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 transform translate-x-12"
    x-transition:enter-end="opacity-100 transform translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform translate-x-0"
    x-transition:leave-end="opacity-0 transform translate-x-12"
    class="fixed top-6 right-6 z-[9999] flex flex-col gap-3"
>
    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="flex items-center p-4 bg-white rounded-2xl shadow-2xl border-l-4 border-emerald-500 min-w-[320px]">
            <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 font-bold">✓</div>
            <div class="ml-4">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Berhasil</p>
                <p class="text-sm font-bold text-slate-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Notifikasi Error (Session atau Validasi) --}}
    @if(session('error') || $errors->any())
        <div class="flex items-center p-4 bg-white rounded-2xl shadow-2xl border-l-4 border-rose-500 min-w-[320px]">
            <div class="flex-shrink-0 w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center text-rose-600 font-bold">✕</div>
            <div class="ml-4">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Perhatian</p>
                <p class="text-sm font-bold text-slate-800">
                    {{ session('error') ?? 'Ada kesalahan pada input data.' }}
                </p>
            </div>
        </div>
    @endif
</div>
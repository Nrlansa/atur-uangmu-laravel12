<x-app-layout>
    <main class="ml-72 min-h-screen bg-slate-50/50 p-8 transition-all duration-300" id="main-content">
        
        <div
            class="flex items-center justify-between mb-12 bg-white/60 backdrop-blur-md p-6 rounded-[2.5rem] border border-white shadow-sm">
            <div class="flex items-center gap-6">
                <button onclick="toggleSidebar()"
                    class="mr-6 bg-white p-3 rounded-2xl shadow-sm border border-slate-100 text-indigo-600 hover:bg-indigo-50 transition-all cursor-pointer">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight leading-none">{{ __('messages.lable_QM') }}</h2>
                    <p
                        class="text-indigo-600 font-bold mt-2 uppercase text-[9px] tracking-[0.3em] flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                        {{ __('messages.otomatedQM') }}
                    </p>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-3 bg-slate-50 px-5 py-3 rounded-2xl border border-slate-100">
                <i class="fa-solid fa-calendar-check text-indigo-500"></i>
                <span
                    class="text-xs font-black text-slate-600 uppercase tracking-tighter">{{ now()->format('D, d M Y') }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 max-w-7xl">
            <div class="lg:col-span-7 space-y-6">
                <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm p-8">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                            <i class="fa-solid fa-file-invoice"></i>
                        </div>
                        <h2 class="text-lg font-black text-slate-800">{{  __('messages.reportQM') }}</h2>
                    </div>

                    <form action="{{ route('whatsapp.send') }}" method="GET" target="_blank">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label class="block font-bold text-[10px] text-slate-400 uppercase tracking-widest mb-3 ml-1">{{ __('messages.Mperiode') }} (DD-MM-YYYY)</label>
                                <input type="date" name="start_date" value="{{ $startDate ?? now()->startOfMonth()->format('Y-m-d') }}"
                                    class="w-full bg-slate-50 border-none focus:ring-2 focus:ring-indigo-500/20 rounded-2xl py-4 px-6 font-bold text-slate-700 transition-all">
                            </div>
                            <div>
                                <label class="block font-bold text-[10px] text-slate-400 uppercase tracking-widest mb-3 ml-1">{{ __('messages.Nperiode') }} (DD-MM-YYYY)</label>
                                <input type="date" name="end_date" value="{{ $endDate ?? now()->format('Y-m-d') }}"
                                    class="w-full bg-slate-50 border-none focus:ring-2 focus:ring-indigo-500/20 rounded-2xl py-4 px-6 font-bold text-slate-700 transition-all">
                            </div>
                        </div>

                        <button type="submit" 
                            class="w-full bg-slate-900 hover:bg-black text-white font-black py-4 rounded-2xl shadow-lg transition-all active:scale-95">
                            <i class="fa-brands fa-whatsapp"></i> {{ __('messages.sendQM') }} →
                        </button>
                    </form>
                </div>

                <div class="bg-indigo-600 rounded-[32px] p-8 text-white shadow-xl">
                    <div class="flex items-center gap-3 mb-6">
                       <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center shadow-inner">
                            <i class="fa-solid fa-lightbulb"></i>
                        </div>
                         <span class="text-[10px] font-black uppercase tracking-[0.3em] opacity-60">{{ __('messages.Lable_guide') }}</span>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-indigo-500/50 p-4 rounded-xl text-sm font-medium">01. {{ __('messages.title01_guide') }}</div>
                        <div class="bg-indigo-500/50 p-4 rounded-xl text-sm font-medium">02. {{ __('messages.title03_guide') }}</div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="sticky top-8">
                     <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-2">{{ __('messages.preview') }}</p>
                     
                     <div class="bg-white rounded-[30px] shadow-lg border border-slate-100 overflow-hidden">
                         <div class="bg-[#075e54] p-4 flex items-center gap-3">
                             <div class="w-10 h-10 bg-slate-300 rounded-full"></div>
                             <span class="text-white font-bold text-sm">AturUangmu Bot</span>
                         </div>
                         
                         <div class="bg-[#e5ddd5] p-6 min-h-[350px]">
                             <div class="bg-white p-4 rounded-xl rounded-tl-none shadow-sm text-[11px] font-mono text-slate-700 leading-relaxed">
                                 {{ $previewMessage ?? __('messages.PreviewQM') }}
                             </div>
                         </div>
                     </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
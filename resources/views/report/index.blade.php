<x-app-layout>
    <main class="ml-72 p-10 transition-all duration-300 min-h-screen bg-[#fcfdfe]" id="main-content">
        {{-- Header --}}
        <div
            class="flex items-center justify-between mb-12 bg-white/60 backdrop-blur-md p-6 rounded-[2.5rem] border border-white shadow-sm">
            <div class="flex items-center gap-6">
                <button onclick="toggleSidebar()"
                    class="mr-6 bg-white p-3 rounded-2xl shadow-sm border border-slate-100 text-indigo-600 hover:bg-indigo-50 transition-all cursor-pointer">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight leading-none">{{ __('messages.lable_report') }}</h2>
                    <p
                        class="text-indigo-600 font-bold mt-2 uppercase text-[9px] tracking-[0.3em] flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                        {{ __('messages.otomated') }}
                    </p>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-3 bg-slate-50 px-5 py-3 rounded-2xl border border-slate-100">
                <i class="fa-solid fa-calendar-check text-indigo-500"></i>
                <span
                    class="text-xs font-black text-slate-600 uppercase tracking-tighter">{{ now()->format('D, d M Y') }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">

            <div class="lg:col-span-7 space-y-10">
                {{-- Form Card --}}
                <div
                    class="relative bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-[3.5rem] p-10 border border-slate-50 overflow-hidden">
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-indigo-50 rounded-full blur-3xl opacity-50">
                    </div>

                    <div class="relative space-y-10">
                        <div class="flex items-center gap-5">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-indigo-600 to-blue-700 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-indigo-200">
                                <i class="fa-solid fa-file-invoice-dollar text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-900 tracking-tight">{{ __('messages.title_report') }}</h3>
                                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">{{ __('messages.label_btnexp') }}</p>
                            </div>
                        </div>

                        <form action="{{ route('report.download') }}" method="POST" class="space-y-8">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                {{-- Start Period --}}
                                <div class="group space-y-3">
                                    <label
                                        class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2 group-focus-within:text-indigo-600 transition-colors italic">
                                        {{ __('messages.Mperiode') }}<span class="text-indigo-500 font-black">(DD-MM-YYYY)</span>
                                    </label>
                                    <input type="date" name="start_date"
                                        value="{{ now()->startOfMonth()->format('Y-m-d') }}" placeholder="DD-MM-YYYY"
                                        class="w-full bg-slate-50/50 border-none ring-1 ring-slate-100 rounded-[1.5rem] px-6 py-5 focus:ring-2 focus:ring-indigo-600 transition-all font-bold text-slate-700 shadow-sm appearance-none"
                                        required>
                                </div>

                                {{-- End Period --}}
                                <div class="group space-y-3">
                                    <label
                                        class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2 group-focus-within:text-indigo-600 transition-colors italic">
                                       {{ __('messages.Nperiode') }}<span class="text-indigo-500 font-black">(DD-MM-YYYY)</span>
                                    </label>
                                    <input type="date" name="end_date" value="{{ now()->format('Y-m-d') }}"
                                        placeholder="DD-MM-YYYY"
                                        class="w-full bg-slate-50/50 border-none ring-1 ring-slate-100 rounded-[1.5rem] px-6 py-5 focus:ring-2 focus:ring-indigo-600 transition-all font-bold text-slate-700 shadow-sm appearance-none"
                                        required>
                                </div>
                            </div>

                            <button type="submit"
                                class="group relative w-full bg-slate-900 hover:bg-indigo-600 text-white py-6 rounded-[1.5rem] font-black text-[11px] uppercase tracking-[0.4em] shadow-2xl shadow-slate-200 transition-all duration-500 overflow-hidden active:scale-95">
                                <span class="relative z-10 flex items-center justify-center gap-3">
                                   {{ __('messages.btnR') }}
                                    <i
                                        class="fa-solid fa-arrow-right-long group-hover:translate-x-2 transition-transform"></i>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Activity Feed --}}
                <div class="space-y-6">
                    <div class="flex items-center justify-between px-4">
                        <h4 class="font-black text-slate-900 text-xs uppercase tracking-[0.3em]">{{ __('messages.transaction') }}
                        </h4>
                        <div class="h-px flex-1 mx-6 bg-slate-100"></div>
                        <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">{{ __('messages.title_tab') }}</span>
                    </div>

                    <div class="grid gap-4">
                        @forelse($recentTransactions ?? [] as $trx)
                            <div
                                class="group flex items-center justify-between p-6 bg-white hover:bg-purple-100 rounded-[2.5rem] border border-slate-50 transition-all duration-500 hover:shadow-2xl hover:shadow-slate-200 hover:-translate-y-1">
                                <div class="flex items-center gap-6">
                                
                                    <div
                                        class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl transition-all duration-500 {{ $trx->type == 'income' ? 'bg-emerald-50 text-emerald-500 group-hover:bg-emerald-400 group-hover:text-white' : 'bg-rose-50 text-rose-500 group-hover:bg-rose-400 group-hover:text-white' }}">
                                        <i
                                            class="fa-solid {{ $trx->category->icon ?? ($trx->type == 'income' ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down') }}"></i>
                                    </div>

                                    <div>
                                        <p
                                            class="text-sm font-black text-slate-900 group-hover:text-black transition-colors tracking-tight">
                                            {{ $trx->description }}
                                        </p>
                                        <p
                                            class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] mt-1 group-hover:text-slate-500 transition-colors">
                                            {{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }} •
                                            {{ $trx->category->name ?? 'General' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <p
                                        class="text-base font-black tracking-tighter {{ $trx->type == 'income' ? 'text-emerald-500' : 'text-rose-500' }} group-hover:scale-110 transition-transform">
                                        {{ $trx->type == 'income' ? '+' : '-' }}
                                        {{ format_uang($trx->amount, session('currency', 'IDR')) }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div
                                class="bg-slate-50/50 border-2 border-dashed border-slate-100 rounded-[3rem] p-16 text-center">
                                <div
                                    class="w-16 h-16 bg-white rounded-3xl shadow-sm flex items-center justify-center mx-auto mb-6">
                                    <i class="fa-solid fa-box-open text-slate-200 text-2xl"></i>
                                </div>
                                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em]">{{ __('messages.title_no_data') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 space-y-8 lg:sticky lg:top-10">
                <div
                    class="bg-gradient-to-br from-indigo-600 to-blue-800 rounded-[3.5rem] p-10 text-white shadow-2xl shadow-indigo-200">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center shadow-inner">
                            <i class="fa-solid fa-lightbulb"></i>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-[0.3em] opacity-60">{{ __('messages.Lable_guide') }}</span>
                    </div>

                    <h4 class="text-2xl font-black mb-6 italic tracking-tighter leading-tight">{{  __('messages.title_guide') }}</h4>

                    <div class="space-y-6">
                        <div
                            class="flex gap-5 p-5 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 transition-colors">
                            <span class="text-2xl font-black opacity-20 italic">01</span>
                            <p class="text-xs font-medium leading-relaxed">{{ __('messages.title01_guide') }}</p>
                        </div>
                        <div
                            class="flex gap-5 p-5 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 transition-colors">
                            <span class="text-2xl font-black opacity-20 italic">02</span>
                            <p class="text-xs font-medium leading-relaxed">{{ __('messages.title02_guide') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>

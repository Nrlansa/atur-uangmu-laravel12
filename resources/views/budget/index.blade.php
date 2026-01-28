<x-app-layout>
    <main class="ml-72 min-h-screen bg-slate-50/50 p-8 transition-all duration-300" id="main-content">

        <div class="flex items-center justify-between mb-10">
            <div class="flex items-center gap-5">
                <button onclick="toggleSidebar()"
                    class="bg-white p-3 rounded-2xl shadow-sm border border-slate-100 text-slate-600 hover:text-indigo-600 transition-all">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <div>
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight">
                        {{ __('messages.monitoring_title') }}
                    </h1>
                    <p class="text-slate-500 font-bold text-sm mt-1 flex items-center gap-2">
                        <i class="fa-regular fa-calendar text-indigo-500"></i>
                        {{ \Carbon\Carbon::parse($month . '-01')->translatedFormat('F Y') }}
                    </p>
                </div>
            </div>

            <form action="{{ route('budget.index') }}" method="GET" id="monthFilterForm"
                class="flex items-center gap-3 bg-white p-2 rounded-2xl border border-slate-100 shadow-sm">
                <input type="month" name="month" value="{{ $month }}" onchange="this.form.submit()"
                    class="bg-transparent border-none focus:ring-0 font-black text-slate-700 cursor-pointer">
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Limit</p>
                <p class="text-2xl font-black text-slate-800">
                    {{ format_uang($budgets->sum('amount'), session('currency', 'IDR')) }}</p>
            </div>
            <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Terpakai</p>
                <p class="text-2xl font-black text-indigo-600">
                    {{ format_uang($budgets->sum('total_spent'), session('currency', 'IDR')) }}</p>
            </div>
            <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Sisa Anggaran</p>
                <p class="text-2xl font-black text-emerald-500">
                    {{ format_uang($budgets->sum('amount') - $budgets->sum('total_spent'), session('currency', 'IDR')) }}
                </p>
            </div>
        </div>

        <div class="w-auto">
            <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm p-8 mb-10">
                <div class="flex items-center gap-3 mb-8">
                    <h2 class="text-lg font-black text-slate-800">{{ __('messages.set_new_budget') }}</h2>
                </div>

                <form action="{{ route('budget.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="month" value="{{ $month }}">

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                        <div class="md:col-span-5">
                            <label
                                class="block font-bold text-[12px] text-slate-400 uppercase tracking-widest mb-3 ml-1">
                                {{ __('messages.category_label') }}
                            </label>
                            <select name="category_id"
                                class="w-full bg-slate-50 border-none focus:ring-2 focus:ring-indigo-500/20 rounded-2xl py-4 px-6 font-bold text-slate-700 transition-all cursor-pointer">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-4">
                            <label
                                class="block font-bold text-[12px] text-slate-400 uppercase tracking-widest mb-3 ml-1">
                                {{ __('messages.nominal_label') }}
                            </label>
                            <input type="number" name="amount"
                                class="w-full bg-slate-50 border-none focus:ring-2 focus:ring-indigo-500/20 rounded-2xl py-4 px-6 font-bold text-slate-700 transition-all"
                                placeholder="{{ __('messages.budgets_placeholder') }}" required>
                        </div>
                        <div class="md:col-span-3">
                            <button type="submit"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-indigo-100 transition-all active:scale-95">
                                <i class="fa-solid fa-plus text-sm px-3"></i>{{ __('messages.save_button') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="space-y-4">
                <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] mt-4 mb-4 ml-2">
                    {{ __('messages.usage_detail') }}
                </h3>

                @forelse($budgets as $budget)
                    {{-- FIRM: Semua data status, percent, dan spent sekarang diambil dari objek yang sudah di-map Service --}}
                    <div class="bg-white rounded-[28px] border border-slate-100 p-6 shadow-sm mb-4">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                {{-- Warna dinamis dari Service --}}
                                <div
                                    class="w-12 h-12 {{ $budget->health['light_bg'] }} rounded-2xl flex items-center justify-center {{ $budget->health['text'] }}">
                                    <i class="fa-solid fa-layer-group"></i>
                                </div>
                                <div>
                                    <h4 class="text-base font-black text-slate-800">{{ $budget->category->name }}</h4>
                                    <span
                                        class="text-[10px] font-black uppercase px-2 py-0.5 rounded-md {{ $budget->health['light_bg'] }} {{ $budget->health['text'] }}">
                                        {{ $budget->health['label'] }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button
                                    onclick="openEditModal('{{ $budget->id }}', '{{ $budget->category_id }}', '{{ $budget->amount }}')"
                                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <form action="{{ route('budget.destroy', $budget->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus anggaran ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition-all">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Progress Bar --}}
                        <div
                            class="relative w-full bg-slate-100 rounded-full h-4 overflow-hidden shadow-inner p-0.5 mt-2">
                            <div class="{{ $budget->health['bg'] }} h-full rounded-full transition-all duration-1000 shadow-[0_0_10px_rgba(0,0,0,0.1)]"
                                style="width: {{ min($budget->percentage, 100) }}%">
                            </div>
                        </div>

                        <div class="flex justify-between mt-2 px-1">
                            <span class="text-[10px] font-bold text-slate-400">0%</span>
                            <span class="text-[10px] font-black {{ $budget->health['text'] }}">
                                {{ $budget->percentage }}%
                                ({{ format_uang($budget->total_spent, session('currency', 'IDR')) }})
                            </span>
                            <span class="text-[10px] font-bold text-slate-400">
                                {{ __('messages.limit') }}:
                                {{ format_uang($budget->amount, session('currency', 'IDR')) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-white rounded-[28px] border border-dashed border-slate-200">
                        <p class="text-slate-400 font-bold">{{ __('messages.empty_data') }}</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div id="editBudgetModal"
            class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
            <div class="bg-white rounded-[32px] p-8 w-full max-w-lg shadow-2xl">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-black text-slate-800">{{ __('messages.btn_edit_budgets') }}</h2>
                    <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <form id="editBudgetForm" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="category_id" id="edit_category_id">

                    <div class="space-y-6">
                        <div>
                            <label
                                class="block font-bold text-[12px] text-slate-400 uppercase tracking-widest mb-3 ml-1">
                                {{ __('messages.nominal_label') }}
                            </label>
                            <input type="number" name="amount" id="edit_amount" required
                                class="w-full bg-slate-50 border-none focus:ring-2 focus:ring-indigo-500/20 rounded-2xl py-4 px-6 font-bold text-slate-700 transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <button type="button" onclick="closeEditModal()"
                                class="w-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-black py-4 rounded-2xl transition-all">
                                {{ __('messages.btn_cancel') }}
                            </button>
                            <button type="submit"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-indigo-100 transition-all">
                                {{ __('messages.save_button') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</x-app-layout>

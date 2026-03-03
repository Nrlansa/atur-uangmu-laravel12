<x-app-layout>
    <main class="ml-72 p-10 transition-all duration-300">
        <div class="flex items-start justify-between mb-12">
            <div class="flex items-start">
                <button onclick="toggleSidebar()"
                    class="mr-6 bg-white p-3 rounded-2xl shadow-sm border border-slate-100 text-indigo-600 hover:bg-indigo-50 transition-all cursor-pointer">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                @include('components.Notification.Notification')
                <div>
                    <h2 class="text-4xl font-black text-slate-800 tracking-tight leading-tight">
                        {{ __('messages.welcome') }}</h2>
                    <p class="text-slate-400 font-medium mt-1">
                        {{ __('messages.greeting', ['name' => Auth::user()->name]) }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <button
                    class="w-12 h-12 bg-white rounded-2xl shadow-sm border border-slate-200 flex items-center justify-center text-slate-400">
                    <i class="fa-solid fa-bell"></i>
                </button>
                <button onclick="openModal()"
                    class="bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition-all flex items-center transform active:scale-95">
                    <i class="fa-solid fa-plus mr-3 text-lg"></i>{{ __('messages.btn_add') }}
                </button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 relative overflow-hidden group">
                <div
                    class="absolute right-[-20px] top-[-20px] w-24 h-24 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-500">
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 relative">
                    {{ __('messages.card_balance') }}</p>
                <h3 class="text-3xl font-black text-slate-800 relative italic">
                    {{ format_uang($balance, $currency) }}</h3>
            </div>
            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 relative overflow-hidden group">
                <div
                    class="absolute right-[-20px] top-[-20px] w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-500">
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 relative">
                    {{ __('messages.card_income') }}</p>
                <h3 class="text-3xl font-black text-emerald-500 relative italic">
                    {{ format_uang($totalIncome, $currency) }}</h3>
            </div>

            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 relative overflow-hidden group">
                <div
                    class="absolute right-[-20px] top-[-20px] w-24 h-24 bg-rose-50 rounded-full group-hover:scale-150 transition-transform duration-500">
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 relative">
                    {{ __('messages.card_expense') }}</p>
                <h3 class="text-3xl font-black text-rose-500 relative italic">
                    {{ format_uang($totalExpense, $currency) }}</h3>
            </div>
        </div>
        {{-- Start Grafik --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <div class="lg:col-span-2 bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-black text-slate-800 uppercase text-xs tracking-[0.3em]">
                        {{ __('messages.cash_flow_title') ?? 'Arus Kas 7 Hari' }}
                    </h3>
                </div>
                <div id="chart-arus-kas" class="w-full" data-income='@json($incomeData)'
                    data-expense='@json($expenseData)' data-labels='@json($labels)'
                    data-currency="{{ $currency }}" data-label-income="{{ __('messages.income') }}"
                    data-label-expense="{{ __('messages.expense') }}">
                </div>
            </div>
             {{-- grafik category & budget  --}}
            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 flex flex-col justify-between">
                <h3 class="font-black text-slate-800 uppercase text-xs tracking-[0.3em] mb-6">
                    {{ __('messages.expense_by_category') ?? 'Kategori Pengeluaran' }}
                </h3>
               <div id="chart-kategori" 
                data-total="{{ $totalAmount }}" 
                data-values="{{ json_encode($categoryValues) }}"
                data-labels="{{ json_encode($categoryLabels) }}"
                data-currency="{{ $currency }}">
                </div>

                <div class="mt-8 space-y-6">
                    @foreach ($expenseDist as $item)
                        <div class="group">
                            <div class="flex justify-between items-end mb-2">
                                <div>
                                    <h4 class="text-sm font-black text-slate-700 uppercase tracking-wide">
                                        {{ $item['category_name'] }}
                                    </h4>
                                    <p class="text-[10px] font-bold {{ $item['health']['text'] }} uppercase">
                                        {{ $item['health']['label'] }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-black text-slate-800 italic">
                                        {{ format_uang($item['amount'], $currency,1) }}
                                    </span>
                                    <p class="text-[10px] text-slate-400 font-medium">
                                        Sisa: {{ format_uang($item['remaining'], $currency,1 ) }}
                                    </p>
                                </div>
                            </div>

                            {{-- progress bar mini --}}
                            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                <div class="{{ $item['health']['bg'] }} h-full transition-all duration-500"
                                    style="width: {{ min(($item['amount'] / max($item['limit'], 1)) * 100, 100) }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- End Grafik --}}
        <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 p-8">
            <div class="flex justify-between items-center mb-8">
                <h3 class="font-black text-slate-800 uppercase text-xs tracking-[0.3em]">
                    {{ __('messages.latest_transactions') }}</h3>
                <a href="#"
                    class="text-xs font-bold text-indigo-600 hover:underline">{{ __('messages.view_all') }}</a>
            </div>

            <div class="space-y-4">
                @forelse($transactions as $trx)
                    <div
                        class="group flex justify-between items-center p-4 hover:bg-slate-50 rounded-2xl transition-all border border-transparent hover:border-slate-100">
                        <div class="flex items-center">
                            {{-- Icons by category --}}
                            <div
                                class="w-10 h-10 rounded-xl flex items-center justify-center mr-4 {{ $trx->type == 'income' ? 'bg-emerald-50 text-emerald-500' : 'bg-rose-50 text-rose-500' }}">
                                <i
                                    class="fa-solid {{ $trx->category->icon ?? ($trx->type == 'income' ? 'fa-arrow-down' : 'fa-arrow-up') }}"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">{{ $trx->description }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">
                                    {{ $trx->date->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            {{-- Nominal: Use the format_money helper so that it can change between IDR and USD. --}}
                            <p
                                class="font-black italic {{ $trx->type == 'income' ? 'text-emerald-500' : 'text-rose-500' }}">
                                {{ $trx->type == 'income' ? '+' : '-' }}
                                {{ format_uang($trx->amount, session('currency', 'IDR'), $trx->exchange_rate) }}
                            </p>

                            <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST"
                                onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-300 hover:text-rose-500 transition-colors">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-slate-400 italic py-10">{{ __('messages.no_transactions') }}</p>
                @endforelse
            </div>
        </div>
    </main>
    <x-transaction-modal :categories="$categories" />
</x-app-layout>

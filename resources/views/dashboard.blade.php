<x-app-layout>
<main class="ml-72 p-10 transition-all duration-300">   
        <div class="flex items-start justify-between mb-12">
            <div class="flex items-start">
                <button onclick="toggleSidebar()" class="mr-6 bg-white p-3 rounded-2xl shadow-sm border border-slate-100 text-indigo-600 hover:bg-indigo-50 transition-all cursor-pointer">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                @include('components.Notification.Notification')
                <div>
                    <h2 class="text-4xl font-black text-slate-800 tracking-tight leading-tight">{{ __('messages.welcome') }}</h2>
                    <p class="text-slate-400 font-medium mt-1">{{ __('messages.greeting', ['name' => Auth::user()->name]) }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <button class="w-12 h-12 bg-white rounded-2xl shadow-sm border border-slate-200 flex items-center justify-center text-slate-400">
                    <i class="fa-solid fa-bell"></i>
                </button>
                <button onclick="openModal()" class="bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition-all flex items-center transform active:scale-95">
                    <i class="fa-solid fa-plus mr-3 text-lg"></i>{{ __('messages.btn_add') }}
                </button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 relative overflow-hidden group">
                <div class="absolute right-[-20px] top-[-20px] w-24 h-24 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 relative">{{ __('messages.card_balance') }}</p>
                <h3 class="text-3xl font-black text-slate-800 relative italic">{{ format_uang($balance, session('currency', 'IDR')) }}</h3>
            </div>
            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 relative overflow-hidden group">
                <div class="absolute right-[-20px] top-[-20px] w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 relative">{{ __('messages.card_income') }}</p>
                <h3 class="text-3xl font-black text-emerald-500 relative italic">{{ format_uang($totalIncome, session('currency', 'IDR')) }}</h3>
            </div>

            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 relative overflow-hidden group">
                <div class="absolute right-[-20px] top-[-20px] w-24 h-24 bg-rose-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 relative">{{ __('messages.card_expense') }}</p>
                <h3 class="text-3xl font-black text-rose-500 relative italic">{{ format_uang($totalExpense, session('currency', 'IDR')) }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 p-8">
            <div class="flex justify-between items-center mb-8">
                <h3 class="font-black text-slate-800 uppercase text-xs tracking-[0.3em]">{{ __('messages.latest_transactions') }}</h3>
                <a href="#" class="text-xs font-bold text-indigo-600 hover:underline">{{ __('messages.view_all') }}</a>
            </div>
            
            <div class="space-y-4">
                @forelse($transactions as $trx)
                    <div class="group flex justify-between items-center p-4 hover:bg-slate-50 rounded-2xl transition-all border border-transparent hover:border-slate-100">
                        <div class="flex items-center">
                            {{-- Icons by category --}}
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-4 {{ $trx->type == 'income' ? 'bg-emerald-50 text-emerald-500' : 'bg-rose-50 text-rose-500' }}">
                                <i class="fa-solid {{ $trx->category->icon ?? ($trx->type == 'income' ? 'fa-arrow-down' : 'fa-arrow-up') }}"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">{{ $trx->description }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">
                                    {{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            {{-- Nominal: Use the format_money helper so that it can change between IDR and USD. --}}
                            <p class="font-black italic {{ $trx->type == 'income' ? 'text-emerald-500' : 'text-rose-500' }}">
                                {{ $trx->type == 'income' ? '+' : '-' }} {{ format_uang($trx->amount) }}
                            </p>
                            
                            <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
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
    {{-- modal add transactions --}}
<div id="modalTransaksi" class="fixed inset-0 z-[60] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity">
    </div>
    <div class="flex min-h-full items-center justify-center p-4 text-center">
        <div class="relative transform overflow-visible rounded-[40px] bg-white p-8 text-left shadow-2xl transition-all w-full max-w-lg border border-slate-100">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-2xl font-black text-slate-800 italic">{{ __('messages.btn_add_modal') }}</h3>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">{{ __('messages.modal_sub') }}</p>
                </div>
                <button onclick="closeModal()" class="text-slate-300 hover:text-rose-500 transition-colors">
                    <i class="fa-solid fa-circle-xmark text-3xl"></i>
                </button>
            </div>
            <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <label class="relative">
                        <input type="radio" name="type" value="income" class="peer sr-only" checked>
                        <div class="p-4 border-2 border-slate-100 rounded-2xl text-center cursor-pointer peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all">
                            <i class="fa-solid fa-arrow-down text-emerald-500 mb-1"></i>
                            <p class="text-xs font-black uppercase text-slate-600">{{ __('messages.btn_income_modal') }}</p>
                        </div>
                    </label>
                    <label class="relative">
                        <input type="radio" name="type" value="expense" class="peer sr-only">
                        <div class="p-4 border-2 border-slate-100 rounded-2xl text-center cursor-pointer peer-checked:border-rose-500 peer-checked:bg-rose-50 transition-all">
                            <i class="fa-solid fa-arrow-up text-rose-500 mb-1"></i>
                            <p class="text-xs font-black uppercase text-slate-600">{{ __('messages.btn_expense_modal') }}</p>
                        </div>
                    </label>
                </div>
                <div x-data="{ 
                    rawAmount: '', 
                    get formattedAmount() {
                        if (!this.rawAmount) return '';
                        return new Intl.NumberFormat('id-ID').format(this.rawAmount);
                    },
                    updateAmount(val) {
                        this.rawAmount = val.replace(/\D/g, '');
                    }
                }">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">
                        {{ __('messages.label_amount') }}
                    </label>
                    
                    <input type="text" 
                        :value="formattedAmount"
                        @input="updateAmount($event.target.value)"
                        placeholder="{{ __('messages.placeholder_amount') }}" 
                        class="w-full mt-1 p-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-700">
                    <input type="hidden" name="amount" :value="rawAmount">
                </div>
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">{{  __('messages.title_desc') }}</label>
                    <input type="text" name="description" placeholder="{{  __('messages.place_desc') }}" class="w-full mt-1 p-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-medium text-slate-700">
                </div>
                <div x-data="{ open: false, selectedName: '{{ __('messages.select_category')}}', selectedIcon: 'fa-tag', selectedId: '' }" class="relative">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">{{  __('messages.title_category') }}</label>
                    <button type="button" @click="open = !open" class="w-full mt-1 p-4 bg-slate-50 rounded-2xl flex items-center justify-between focus:ring-2 focus:ring-indigo-500">
                        <div class="flex items-center text-slate-700 font-medium">
                            <i :class="'fa-solid ' + selectedIcon" class="mr-3 text-indigo-500"></i>
                            <span x-text="selectedName"></span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-slate-400 text-xs"></i>
                    </button>
                    <div x-show="open" 
                        x-transition 
                        @click.outside="open = false" 
                        class="absolute z-[100] w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-2xl max-h-60 overflow-y-auto">
                        @foreach($categories as $category)
                            <div @click="selectedName = '{{ __('messages.' . $category->name) }}'; selectedIcon = '{{ $category->icon }}'; selectedId = '{{ $category->id }}'; open = false" 
                                class="flex items-center p-4 hover:bg-indigo-50 cursor-pointer transition-colors">
                                <i class="fa-solid {{ $category->icon }} mr-3 text-indigo-500 w-5 text-center"></i>
                                <span class="text-slate-700 font-medium">{{ __('messages.' . $category->name) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <input type="hidden" name="category_id" :value="selectedId" required>
                </div>

                <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
                <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black uppercase tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all transform active:scale-95">
                    {{  __('messages.btn_save_modal') }}
                </button>
            </form>
        </div>
    </div>
</div>
    {{-- start script add transaction button --}}
    <script>
        const modal = document.getElementById('modalTransaksi');
        function openModal() {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Key to the back screen scroll
        }
        function closeModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Enable scrolling again
        }
        // Close the capital if you click outside the white area
        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
    {{-- end of add transaction button script --}}
</x-app-layout>
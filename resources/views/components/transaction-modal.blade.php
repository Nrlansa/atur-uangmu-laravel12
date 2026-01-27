@props(['categories'])

<div id="modalTransaksi"
     class="fixed inset-0 z-[70] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4"
     x-data="transactionForm"
     x-cloak>
    <div class="relative bg-white p-8 rounded-[40px] shadow-2xl w-full max-w-lg" @click.stop>
        
        {{-- Header Modal --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h3 class="text-2xl font-black text-slate-800 italic">{{ __('messages.btn_add_modal') }}</h3>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">{{ __('messages.modal_sub') }}</p>
            </div>
            <button type="button" onclick="closeModal()" class="text-slate-300 hover:text-rose-500">
                <i class="fa-solid fa-circle-xmark text-3xl"></i>
            </button>
        </div>

        <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Type Selection (Income/Expense) --}}
            <div class="grid grid-cols-2 gap-4">
                <label class="relative cursor-pointer">
                    <input type="radio" name="type" value="income" class="peer sr-only" checked>
                    <div class="p-4 border-2 border-slate-100 rounded-2xl text-center peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all">
                        <i class="fa-solid fa-arrow-down text-emerald-500 mb-1"></i>
                        <p class="text-xs font-black uppercase text-slate-600">{{ __('messages.btn_income_modal') }}</p>
                    </div>
                </label>
                <label class="relative cursor-pointer">
                    <input type="radio" name="type" value="expense" class="peer sr-only">
                    <div class="p-4 border-2 border-slate-100 rounded-2xl text-center peer-checked:border-rose-500 peer-checked:bg-rose-50 transition-all">
                        <i class="fa-solid fa-arrow-up text-rose-500 mb-1"></i>
                        <p class="text-xs font-black uppercase text-slate-600">{{ __('messages.btn_expense_modal') }}</p>
                    </div>
                </label>
            </div>

            {{-- Input Nominal --}}
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">{{ __('messages.label_amount') }}</label>
                <input type="text" :value="formattedAmount" @input="updateAmount($event.target.value)"
                    placeholder="{{ __('messages.placeholder_amount') }}"
                    class="w-full mt-1 p-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500">
                <input type="hidden" name="amount" :value="rawAmount">
            </div>

            {{-- Dropdown Kategori --}}
            <div class="relative">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">{{ __('messages.title_category') }}</label>
                <button type="button" @click="open = !open"
                    class="w-full mt-1 p-4 bg-slate-50 rounded-2xl flex items-center justify-between focus:ring-2 focus:ring-indigo-500 transition-all">
                    <div class="flex items-center">
                        <i :class="selectedIcon ? 'fa-solid ' + selectedIcon : 'fa-solid fa-tag text-slate-300'" class="mr-3 text-indigo-500 w-5 text-center"></i>
                        <span x-text="selectedName ? selectedName : '{{ __('messages.select_category') }}'"
                            :class="selectedName ? 'text-slate-700 font-medium' : 'text-slate-400 font-medium'">
                        </span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" @click.outside="open = false" style="display: none;"
                    class="absolute z-[100] w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-2xl max-h-60 overflow-y-auto">
                    @foreach ($categories as $category)
                        <div @click="selectCategory('{{ $category->id }}', '{{ addslashes(__('messages.' . $category->name)) }}', '{{ $category->icon }}')"
                            class="flex items-center p-4 hover:bg-indigo-50 cursor-pointer group transition-colors border-b border-slate-50 last:border-none">
                            <i class="fa-solid {{ $category->icon }} mr-3 text-indigo-500 w-5 text-center group-hover:scale-110 transition-transform"></i>
                            <span class="text-slate-700 font-bold text-sm">{{ __('messages.' . $category->name) }}</span>
                        </div>
                    @endforeach
                </div>
                <input type="hidden" name="category_id" :value="selectedId">
            </div>

            {{-- Description --}}
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">{{ __('messages.title_desc') }}</label>
                <input type="text" name="description" placeholder="{{ __('messages.place_desc') }}"
                    class="w-full mt-1 p-4 bg-slate-50 border-none rounded-2xl font-medium text-slate-700 focus:ring-2 focus:ring-indigo-500">
            </div>

            <input type="hidden" name="date" value="{{ date('Y-m-d') }}">

            <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black uppercase tracking-widest shadow-xl hover:bg-indigo-700 transition-all active:scale-95">
                {{ __('messages.btn_save_modal') }}
            </button>
        </form>
    </div>
</div>
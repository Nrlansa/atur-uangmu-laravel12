<x-app-layout>
<main class="ml-72 p-10 transition-all duration-300">   
        <div class="flex items-start justify-between mb-12">
            <div class="flex items-start">
                <button onclick="toggleSidebar()" class="mr-6 bg-white p-3 rounded-2xl shadow-sm border border-slate-100 text-indigo-600 hover:bg-indigo-50 transition-all cursor-pointer">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-500 text-white rounded-2xl shadow-lg shadow-emerald-100 flex items-center">
                        <i class="fa-solid fa-check-circle mr-3 text-xl"></i>
                        <span class="font-bold">{{ session('success') }}</span>
                    </div>
                @endif
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
                <h3 class="text-3xl font-black text-slate-800 relative italic">Rp {{ number_format($balance, 0, ',', '.') }}</h3>
            </div>

            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 relative overflow-hidden group">
                <div class="absolute right-[-20px] top-[-20px] w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 relative">{{ __('messages.card_income') }}</p>
                <h3 class="text-3xl font-black text-emerald-500 relative italic">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
            </div>

            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 relative overflow-hidden group">
                <div class="absolute right-[-20px] top-[-20px] w-24 h-24 bg-rose-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 relative">{{ __('messages.card_expense') }}</p>
                <h3 class="text-3xl font-black text-rose-500 relative italic">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
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
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-4 {{ $trx->type == 'income' ? 'bg-emerald-50 text-emerald-500' : 'bg-rose-50 text-rose-500' }}">
                                <i class="fa-solid {{ $trx->type == 'income' ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">{{ $trx->description }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">{{ $trx->date }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <p class="font-black italic {{ $trx->type == 'income' ? 'text-emerald-500' : 'text-rose-500' }}">
                                {{ $trx->type == 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
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
    {{-- modal tambah transaksi --}}
    <div id="modalTransaksi" class="fixed inset-0 z-[60] hidden overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity">
        </div>
        <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="relative transform overflow-hidden rounded-[40px] bg-white p-8 text-left shadow-2xl transition-all w-full max-w-lg border border-slate-100">
                    
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h3 class="text-2xl font-black text-slate-800 italic">Tambah Transaksi</h3>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Catat pengeluaran/pemasukan</p>
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
                                    <p class="text-xs font-black uppercase text-slate-600">Pemasukan</p>
                                </div>
                            </label>
                            <label class="relative">
                                <input type="radio" name="type" value="expense" class="peer sr-only">
                                <div class="p-4 border-2 border-slate-100 rounded-2xl text-center cursor-pointer peer-checked:border-rose-500 peer-checked:bg-rose-50 transition-all">
                                    <i class="fa-solid fa-arrow-up text-rose-500 mb-1"></i>
                                    <p class="text-xs font-black uppercase text-slate-600">Pengeluaran</p>
                                </div>
                            </label>
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Nominal (Rp)</label>
                            <input type="number" name="amount" placeholder="Contoh: 50000" class="w-full mt-1 p-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-700">
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Keterangan</label>
                            <input type="text" name="description" placeholder="Makan siang, Gaji, dll" class="w-full mt-1 p-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-medium text-slate-700">
                        </div>

                        <input type="hidden" name="category" value="Umum">
                        <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
                        <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black uppercase tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all transform active:scale-95">
                            Simpan Transaksi
                        </button>
                    </form>
                </div>
        </div>
    </div>
    {{-- mulai scrip tombol tambah transaksi --}}
    <script>
        const modal = document.getElementById('modalTransaksi');

        function openModal() {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Kunci scroll layar belakang
        }

        function closeModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Aktifkan scroll lagi
        }

        // Menutup modal jika klik di luar area putih
        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
    {{-- akhir scrip tombol tambah transaksi --}}
</x-app-layout>
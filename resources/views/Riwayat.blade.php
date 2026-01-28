<x-app-layout>
    <main class="ml-72 p-10 transition-all duration-300">
        {{-- Header Section --}}
        <div class="flex items-start justify-between mb-12">
            <div class="flex items-start">
                <button onclick="toggleSidebar()"
                    class="mr-6 bg-white p-3 rounded-2xl shadow-sm border border-slate-100 text-indigo-600 hover:bg-indigo-50 transition-all cursor-pointer">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <div>
                    <h2 class="text-4xl font-black text-slate-800 tracking-tight leading-tight">
                        {{ __('messages.history') }}</h2>
                    <p class="text-slate-400 font-medium mt-1">{{ __('messages.title_history') }}</p>
                </div>
            </div>

            {{-- Filter Section --}}
            <form action="{{ route('transactions.index') }}" method="GET"
                class="flex gap-3 bg-white p-2 rounded-3xl shadow-sm border border-slate-100">
                {{-- Filter Month --}}
                <select name="month" onchange="this.form.submit()"
                    class="bg-transparent border-none text-sm font-bold text-slate-600 focus:ring-0 cursor-pointer">
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>

                {{-- Filter Year --}}
                <select name="year" onchange="this.form.submit()"
                    class="bg-transparent border-none text-sm font-bold text-slate-600 focus:ring-0 cursor-pointer">
                    @php $currentYear = now()->year; @endphp
                    @foreach (range($currentYear - 2, $currentYear) as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>

                {{-- Keep the filter type if there is one. --}}
                @if (request('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
            </form>
        </div>

        {{-- Tabel History --}}
        <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-black text-slate-800 uppercase text-xs tracking-[0.3em]">
                    {{ __('messages.Table_history') }}</h3>
                <span class="px-4 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold">
                    {{ __('messages.transaction') }}: {{ $transactions->count() }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-slate-400 text-xs uppercase tracking-widest border-b border-slate-50">
                            <th class="px-8 py-5 font-bold">{{ __('messages.date') }}</th>
                            <th class="px-8 py-5 font-bold">{{ __('messages.description_tbl') }}</th>
                            <th class="px-8 py-5 font-bold">{{ __('messages.tbl_category') }}</th>
                            <th class="px-8 py-5 font-bold">{{ __('messages.nominal_label') }}</th>
                            <th class="px-8 py-5 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($transactions as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-5">
                                    <span class="text-sm font-semibold text-slate-600">
                                        {{ $item->date->format('d M Y') }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <p class="text-sm font-bold text-slate-800">{{ $item->description }}</p>
                                </td>
                                <td class="px-8 py-5">
                                    <span
                                        class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-500">
                                        {{ $item->category->name }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <span
                                        class="text-sm font-black {{ $item->type == 'income' ? 'text-emerald-500' : 'text-rose-500' }}">
                                        {{ $item->type == 'income' ? '+' : '-' }} Rp
                                        {{ number_format($item->amount, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex justify-center gap-2">
                                        {{-- Confirm Delete button --}}
                                        <form action="{{ route('transactions.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fa-solid fa-folder-open text-5xl text-slate-200 mb-4"></i>
                                        <p class="text-slate-400 font-medium">{{ __('messages.no_transactions') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if (method_exists($transactions, 'links'))
                <div class="p-8 border-t border-slate-50">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </main>
</x-app-layout>

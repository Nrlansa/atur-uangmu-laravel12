<x-app-layout>
    <main class="ml-72 p-10 transition-all duration-300">
        {{-- Header Section --}}
        <div class="flex items-start justify-between mb-12">
            <div class="p-8">
                <div class="max-w-2xl bg-indigo-900 border border-indigo-700 rounded-3xl p-8 shadow-2xl">
                    <h2 class="text-2xl font-black text-white mb-6 italic">{{ __('messages.wa_title') }}</h2>

                    <form action="{{ route('whatsapp.send') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-white font-bold mb-2">{{ __('messages.wa_name') }}</label>
                            <input type="text" name="name"
                                class="w-full bg-white text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-400"
                                placeholder="{{__('messages.Wa_name_cust')}}" required>
                        </div>

                        <div>
                            <label class="block text-white font-bold mb-2">{{ __('messages.wa_message') }}</label>
                            <textarea name="message" rows="4"
                                class="w-full bg-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-400" placeholder="{{  __('messages.WA_desc') }}" required></textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-[#25D366] hover:bg-[#128C7E] text-white font-black py-4 rounded-xl transition-all shadow-lg flex items-center justify-center gap-3">
                            <i class="fa-brands fa-whatsapp text-2xl"></i>
                            {{ __('messages.wa_btn') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>

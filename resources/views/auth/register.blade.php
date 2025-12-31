<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - AturUangmu</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-indigo-600 to-violet-700 min-h-screen flex items-center justify-center p-6 py-10">

    <div class="bg-white p-8 md:p-10 rounded-[40px] shadow-2xl w-full max-w-md">
        <div class="text-center mb-8">
            <div class="bg-indigo-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-user-plus text-indigo-600 text-2xl"></i>
            </div>
            <h2 class="text-3xl font-black text-gray-800">Buat Akun</h2>
            <p class="text-gray-400 text-sm mt-1 font-medium">Mulai catat keuanganmu sekarang!</p>
        </div>
    {{-- messages error --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl">
                <ul class="list-disc list-inside text-xs text-rose-600 font-medium space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1 tracking-widest">Nama Lengkap</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <i class="fa-solid fa-user text-xs"></i>
                    </span>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                        class="w-full pl-10 pr-4 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all font-medium text-gray-700" 
                        placeholder="Nama Lengkap Anda">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1 tracking-widest">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <i class="fa-solid fa-envelope text-xs"></i>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                        class="w-full pl-10 pr-4 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all font-medium text-gray-700" 
                        placeholder="nama@email.com">
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1 tracking-widest">Password</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <i class="fa-solid fa-lock text-xs"></i>
                    </span>
                    <input type="password" name="password" id="password" required 
                        class="w-full pl-10 pr-12 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all font-medium text-gray-700" 
                        placeholder="Min. 8 Karakter">
                    
                    <button type="button" onclick="togglePassword('password', 'eye-icon')" 
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-indigo-600 transition-colors">
                        <i id="eye-icon" class="fa-solid fa-eye text-xs"></i>
                    </button>
                </div>
                <p class="text-[9px] text-slate-400 mt-2 ml-1 leading-relaxed">
                    *Wajib kombinasi: <span class="text-indigo-600 font-bold">Huruf Besar, Kecil, Angka, & Simbol.</span>
                </p>
            </div>
           <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1 tracking-widest">Konfirmasi Password</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <i class="fa-solid fa-check-double text-xs"></i>
                    </span>
                    <input type="password" name="password_confirmation" id="password_confirmation" required 
                        class="w-full pl-10 pr-12 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all font-medium text-gray-700" 
                        placeholder="Ulangi Password">
                    
                    <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-confirm')" 
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-indigo-600 transition-colors">
                        <i id="eye-icon-confirm" class="fa-solid fa-eye text-xs"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all mt-4">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-8 text-center border-t border-gray-100 pt-6">
            <p class="text-xs text-gray-400 font-medium">Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:underline">Masuk di Sini</a>
            </p>
        </div>
    </div>
    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>

</body>
</html>
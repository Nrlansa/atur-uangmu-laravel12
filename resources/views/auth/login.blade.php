<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AturUangmu</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-indigo-600 to-violet-700 h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 md:p-10 rounded-[40px] shadow-2xl w-full max-w-md">
        <div class="text-center mb-8">
            <div class="bg-indigo-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-wallet text-indigo-600 text-2xl"></i>
            </div>
            <h2 class="text-3xl font-black text-gray-800">AturUangmu</h2>
            <p class="text-gray-400 text-sm mt-1 font-medium">Masuk untuk kelola keuanganmu</p>
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-xl text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1 tracking-widest">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <i class="fa-solid fa-envelope text-xs"></i>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus 
                        class="w-full pl-10 pr-4 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all font-medium text-gray-700 placeholder:text-gray-300" 
                        placeholder="nama@email.com">
                </div>
                @error('email')
                    <p class="text-red-500 text-[10px] mt-1 ml-1 font-bold italic">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1 tracking-widest">Password</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <i class="fa-solid fa-lock text-xs"></i>
                    </span>
                    <input type="password" name="password" id="login-password" required 
                        class="w-full pl-10 pr-12 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all font-medium text-gray-700 placeholder:text-gray-300" 
                        placeholder="••••••••">
                    
                    <button type="button" onclick="togglePassword('login-password', 'eye-icon-login')" 
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-indigo-600 transition-colors">
                        <i id="eye-icon-login" class="fa-solid fa-eye text-xs"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-[10px] mt-1 ml-1 font-bold italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between px-1 text-xs">
                <label class="flex items-center text-gray-500 cursor-pointer">
                    <input type="checkbox" name="remember" class="mr-2 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    Ingat saya
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="font-bold text-indigo-600 hover:text-indigo-800">Lupa password?</a>
                @endif
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black uppercase tracking-[0.2em] hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all transform active:scale-95 mt-4">
                Masuk
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-xs text-gray-400 font-medium">Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:underline">Buat Akun Sekarang</a>
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

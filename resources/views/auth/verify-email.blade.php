<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - AturUangmu</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-indigo-600 to-violet-700 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white p-8 md:p-10 rounded-[40px] shadow-2xl w-full max-w-md text-center">
        <div class="bg-indigo-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fa-solid fa-envelope-open-text text-indigo-600 text-3xl"></i>
        </div>

        <h2 class="text-2xl font-black text-gray-800 mb-4">Verifikasi Email Anda</h2>
        
        <p class="text-gray-500 text-sm leading-relaxed mb-8">
            Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan. Jika Anda tidak menerima email, kami akan mengirimkan yang baru.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 font-bold text-sm text-green-600 bg-green-50 p-4 rounded-2xl">
                Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
            </div>
        @endif

        <div class="space-y-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all transform active:scale-95">
                    Kirim Ulang Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm font-bold text-gray-400 hover:text-red-500 transition-colors uppercase tracking-tight">
                    <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Keluar / Batal
                </button>
            </form>
        </div>
    </div>

</body>
</html>
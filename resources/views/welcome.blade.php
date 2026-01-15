<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Stockify</title>

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center">

<div class="max-w-4xl w-full px-6">

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden grid md:grid-cols-2">

        <!-- LEFT -->
        <div class="p-10 flex flex-col justify-center">
            <h1 class="text-3xl md:text-4xl font-bold text-blue-700 mb-4">
                Selamat Datang di <span class="text-blue-500">Stockify</span>
            </h1>

            <p class="text-gray-600 mb-6">
                Aplikasi manajemen stok yang membantu Admin, Manajer Gudang,
                dan Staff Gudang dalam mengelola barang masuk, keluar, dan stok opname
                secara efisien.
            </p>

            <div class="flex gap-3">
                <a href="{{ route('login') }}"
                   class="px-5 py-2.5 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                    Login
                </a>

                <a href="{{ route('register') }}"
                   class="px-5 py-2.5 rounded-lg border border-blue-600 text-blue-600 font-medium hover:bg-blue-50 transition">
                    Register
                </a>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="hidden md:flex items-center justify-center bg-blue-600 p-10">
            <div class="text-center text-white">
                <svg class="w-32 h-32 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M20 7h-3V4H7v3H4v13h16V7Z"/>
                </svg>
                <h2 class="text-xl font-semibold">Kelola Stok Lebih Mudah</h2>
                <p class="text-blue-100 text-sm mt-2">
                    Cepat • Akurat • Terstruktur
                </p>
            </div>
        </div>

    </div>

    <!-- BUTTON -->
    <div class="mt-6 text-center">
        <button id="btnCreator"
                class="px-5 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
            Pembuat Web
        </button>
    </div>

    <!-- FOOTER -->
    <p class="text-center text-sm text-gray-500 mt-6">
        © {{ date('Y') }} Stockify. All rights reserved.
    </p>

</div>

<script>
document.getElementById('btnCreator').addEventListener('click', function () {
    Swal.fire({
        title: "Pembuat Web",
        html: `
            <b>Backend:</b> Fariduddin Syah Attar<br>
            <b>Frontend:</b> Ayeisha Xiarra Hanummitha<br>
            <b>Aplikasi:</b> Stockify<br>
            <b>Fitur:</b> Manajemen Stok Gudang
        `,
        width: 600,
        padding: "2em",
        color: "#716add",
        background: "#fff url(https://sweetalert2.github.io/images/trees.png)",
        backdrop: `
          rgba(0,0,123,0.4)
          url("https://sweetalert2.github.io/images/nyan-cat.gif")
          left top
          no-repeat
        `
    });
});
</script>


</body>
</html>

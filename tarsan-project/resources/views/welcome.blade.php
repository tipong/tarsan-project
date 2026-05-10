<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700,800&display=swap" rel="stylesheet" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Title --}}
    <title>Tarsan Homestay</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('tarsanhomestay.png') }}">
    {{-- atau jika pakai ico --}}
    {{-- <link rel="icon" href="{{ asset('favicon.ico') }}"> --}}

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-[Figtree] text-slate-800 antialiased selection:bg-slate-200 selection:text-slate-900">

{{-- NAVBAR --}}
<nav class="bg-white/90 backdrop-blur-md shadow fixed w-full z-50 transition-all border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        {{-- LOGO --}}
        <a href="{{ url('/') }}" class="flex items-center gap-3 transition-transform hover:scale-105">
            <img src="{{ asset('images/tarsanhomestay.png') }}" class="h-16 object-contain">
            <span class="font-[Playfair_Display] font-bold text-xl tracking-tight text-slate-900">Tarsan Homestay</span>
        </a>

        {{-- MENU --}}
        <div class="hidden md:flex items-center space-x-8 text-sm font-medium">
            <a href="#beranda" class="text-slate-600 hover:text-slate-900 transition-colors">Home</a>
            <a href="#tentang" class="text-slate-600 hover:text-slate-900 transition-colors">About</a>
            <a href="#fasilitas" class="text-slate-600 hover:text-slate-900 transition-colors">Facilities</a>
            <a href="{{ route('kamar.index') }}" class="text-slate-600 hover:text-slate-900 transition-colors">Kamar</a>
            <a href="#kontak" class="text-slate-600 hover:text-slate-900 transition-colors">Contact</a>

            @auth
                <a href="{{ route('tamu.notifications.index') }}" class="relative text-slate-600 hover:text-slate-900 transition-colors">
                    Notifikasi
                    <span id="notif-badge" class="absolute -top-2 -right-3 bg-red-500 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center hidden"></span>
                </a>
                <a href="{{ route('tamu.orders') }}" class="text-slate-600 hover:text-slate-900 transition-colors">
                    Pesanan Saya
                </a>
            @endauth
        </div>

        {{-- AUTH --}}
        <div class="flex items-center space-x-4">
            @guest
                <a href="{{ route('login') }}"
                   class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="px-5 py-2 bg-slate-900 text-white text-sm font-medium rounded-full hover:bg-slate-800 transition-colors shadow-md hover:shadow-lg">
                    Register
                </a>
            @else
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="text-sm font-medium text-red-600 hover:text-red-700 transition-colors">
                        Logout
                    </button>
                </form>
            @endguest
        </div>
    </div>
</nav>

{{-- HERO SECTION --}}
<section id="beranda"
    class="relative min-h-screen flex items-center justify-center text-white pt-20"
    style="background-image: url('{{ asset('images/hero.png') }}'); background-size: cover; background-position: center;"
>

    {{-- Overlay gelap --}}
    <div class="absolute inset-0 bg-slate-900/60"></div>

    {{-- Konten --}}
    <div class="relative z-10 max-w-4xl mx-auto text-center px-6">
        <h1 class="text-5xl md:text-7xl font-[Playfair_Display] font-bold mb-6 leading-tight tracking-tight drop-shadow-md">
            The Best Stay Experience<br>In Labuan Bajo
        </h1>
        <p class="mb-12 text-lg md:text-xl text-slate-200 font-light max-w-2xl mx-auto drop-shadow">
            Book your room easily, quickly, and securely directly with us.
        </p>

        {{-- SEARCH BOX --}}
        <div class="bg-white/10 backdrop-blur-md p-2 rounded-2xl shadow-2xl flex flex-col md:flex-row gap-2 text-slate-800 max-w-2xl mx-auto border border-white/20">
            <input type="date" class="border-none focus:ring-2 focus:ring-indigo-600 p-3 rounded-xl w-full bg-white text-slate-900 text-sm">
            <input type="date" class="border-none focus:ring-2 focus:ring-indigo-600 p-3 rounded-xl w-full bg-white text-slate-900 text-sm">
            <button class="bg-slate-900 text-white px-8 py-3 rounded-xl font-medium hover:bg-slate-800 transition-colors shadow-md">
                Search
            </button>
        </div>
    </div>
</section>


<section id="tentang" class="bg-white py-24 border-b border-slate-200">
    <div class="max-w-4xl mx-auto text-center px-6">
        <h2 class="text-slate-500 uppercase tracking-[0.2em] text-sm font-semibold mb-4">
            Welcome to
        </h2>

        <h2 class="text-4xl md:text-5xl font-[Playfair_Display] font-bold mb-10 text-slate-900">
            Tarsan Homestay
        </h2>

        <div class="space-y-6 text-slate-600 text-lg font-light leading-relaxed">
            <p>
                Tarsan Homestay is located at Labuan Bajo, West Manggarai Regency, East Nusa Tenggara, designed to meet the needs of travelers for comfortable, affordable, and accessible accommodation. As one of Indonesia's leading tourist destinations and the gateway to Komodo National Park, Labuan Bajo experiences a steadily increasing number of tourist visits each year, making the need for professional accommodation services increasingly crucial.
            </p>
            <p>
                Tarsan Homestay offers a variety of rooms designed to provide comfort for both domestic and international guests. Each room is equipped with basic amenities to ensure a comfortable stay, as well as a clean and safe environment. Prioritizing friendly and responsive service, Tarsan Homestay is committed to providing a pleasant and memorable stay for every guest.
            </p>
            <p class="font-medium text-slate-800">
                We hope all our guests enjoy and are comfortable with the facilities we offer. Have a great holiday! Thank you 😍
            </p>
        </div>
    </div>
</section>

<section id="keunggulan" class="bg-gray-50 py-24">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-[Playfair_Display] font-bold text-center mb-16 text-slate-900">
            Advantages of Direct Booking
        </h2>

        <div class="grid md:grid-cols-3 gap-8 text-center">
            <div class="bg-white p-8 rounded-2xl shadow border border-slate-200 hover:shadow-md transition-shadow duration-300">
                <div class="w-12 h-12 bg-slate-100 text-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-semibold text-lg text-slate-900 mb-3">Transparent Price</h3>
                <p class="text-slate-500 font-light leading-relaxed">
                    Room prices are displayed directly without any additional fees from third parties.
                </p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow border border-slate-200 hover:shadow-md transition-shadow duration-300">
                <div class="w-12 h-12 bg-slate-100 text-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="font-semibold text-lg text-slate-900 mb-3">Fast Order</h3>
                <p class="text-slate-500 font-light leading-relaxed">
                    Orders can be made quickly through a web-based system.
                </p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow border border-slate-200 hover:shadow-md transition-shadow duration-300">
                <div class="w-12 h-12 bg-slate-100 text-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h3 class="font-semibold text-lg text-slate-900 mb-3">Full Control</h3>
                <p class="text-slate-500 font-light leading-relaxed">
                    You can monitor the order status independently via the dashboard.
                </p>
            </div>
        </div>
    </div>
</section>

<section id="fasilitas" class="bg-white py-24">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-[Playfair_Display] font-bold text-center mb-16 text-slate-900">
            Our Facilities
        </h2>

        <div class="grid md:grid-cols-3 gap-10">
            {{-- KAMAR --}}
            <div class="text-center group">
                <div class="overflow-hidden rounded-2xl mb-6 shadow border border-slate-200">
                    <img src="{{ asset('images/room.png') }}" class="w-full h-80 object-cover transform transition-transform duration-700 group-hover:scale-105">
                </div>
                <h3 class="text-2xl font-[Playfair_Display] font-semibold mb-3 text-slate-900">
                    Rooms & Suites
                </h3>
                <p class="text-slate-500 font-light leading-relaxed mb-6">
                    Comfortable rooms with modern design are equipped with supporting facilities to provide the best possible stay.
                </p>
                <a href="{{ route('kamar.index') }}"
                   class="inline-block px-8 py-2.5 rounded-full border border-slate-300 text-slate-700 hover:border-slate-900 hover:bg-slate-900 hover:text-white transition-colors font-medium text-sm">
                    Explore
                </a>
            </div>

            {{-- FASILITAS --}}
            <div class="text-center group">
                <div class="overflow-hidden rounded-2xl mb-6 shadow border border-slate-200">
                    <img src="{{ asset('images/facility.jpg') }}" class="w-full h-80 object-cover transform transition-transform duration-700 group-hover:scale-105">
                </div>
                <h3 class="text-2xl font-[Playfair_Display] font-semibold mb-3 text-slate-900">
                    Homestay Facilities
                </h3>
                <p class="text-slate-500 font-light leading-relaxed mb-6">
                    Supporting facilities are available such as a relaxation area, Wi-Fi, billiards, motorbike rental, and a comfortable environment for resting.
                </p>
                <a href="#"
                   class="inline-block px-8 py-2.5 rounded-full border border-slate-300 text-slate-700 hover:border-slate-900 hover:bg-slate-900 hover:text-white transition-colors font-medium text-sm">
                    Explore
                </a>
            </div>

            {{-- KULINER --}}
            <div class="text-center group">
                <div class="overflow-hidden rounded-2xl mb-6 shadow border border-slate-200">
                    <img src="{{ asset('images/dining.jpg') }}" class="w-full h-80 object-cover transform transition-transform duration-700 group-hover:scale-105">
                </div>
                <h3 class="text-2xl font-[Playfair_Display] font-semibold mb-3 text-slate-900">
                    Dining Experience
                </h3>
                <p class="text-slate-500 font-light leading-relaxed mb-6">
                    A culinary experience with a selection of menus is prepared to enhance your comfort during your stay.
                </p>
                <a href="#"
                   class="inline-block px-8 py-2.5 rounded-full border border-slate-300 text-slate-700 hover:border-slate-900 hover:bg-slate-900 hover:text-white transition-colors font-medium text-sm">
                    Explore
                </a>
            </div>
        </div>
    </div>
</section>

<section class="bg-slate-900 py-20 text-center text-white relative overflow-hidden">
    <div class="relative z-10 max-w-2xl mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-[Playfair_Display] font-bold mb-6 tracking-wide drop-shadow">
            Ready for an unforgettable stay?
        </h2>
        <p class="mb-10 text-slate-400 font-light text-lg">
            Login or register to easily book a room and manage your reservations directly.
        </p>
        <a href="{{ route('login') }}"
           class="inline-block bg-white text-slate-900 px-10 py-3.5 rounded-full font-semibold shadow-lg hover:shadow-xl hover:bg-gray-50 hover:-translate-y-0.5 transition-all duration-300">
            Book Now
        </a>
    </div>
</section>

<footer id="kontak" class="bg-slate-950 text-slate-500 py-16">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-12 text-sm font-light">

        {{-- Informasi --}}
        <div>
            <h4 class="font-[Playfair_Display] text-xl font-semibold mb-6 text-white tracking-wide">
                Tarsan Homestay
            </h4>
            <a href="https://maps.app.goo.gl/7pmmdcZEvY4FtAEk6" target="_blank" class="hover:text-white transition-colors flex items-start gap-3">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>Labuan Bajo, Kec. Komodo, Kab. Manggarai Barat, Nusa Tenggara Timur</span>
            </a>
        </div>

        {{-- Kontak --}}
        <div>
            <h4 class="font-semibold mb-6 text-white uppercase tracking-wider">Contact</h4>
            <ul class="space-y-4">
                <li>
                    <a href="mailto:tarsanhomestay@gmail.com" class="hover:text-white transition-colors flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        tarsanhomestay@gmail.com
                    </a>
                </li>
                <li>
                    <a href="tel:082146562293" class="hover:text-white transition-colors flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        0821-4656-2293
                    </a>
                </li>
            </ul>
        </div>

        {{-- Navigasi --}}
        <div>
            <h4 class="font-semibold mb-6 text-white uppercase tracking-wider">Navigation</h4>
            <ul class="space-y-3">
                <li><a href="#beranda" class="hover:text-white transition-colors">Home</a></li>
                <li><a href="{{ route('kamar.index') }}" class="hover:text-white transition-colors">Rooms</a></li>
                <li><a href="{{ route('tamu.orders') }}" class="hover:text-white transition-colors">My Orders</a></li>
            </ul>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 mt-16 pt-8 border-t border-slate-800 text-center text-xs tracking-wider">
        © {{ date('Y') }} Tarsan Homestay. All rights reserved.
    </div>
</footer>

@auth
<script>
// Load unread notification count setiap 30 detik
document.addEventListener('DOMContentLoaded', function() {
    loadUnreadCount();
    setInterval(loadUnreadCount, 30000);
});

function loadUnreadCount() {
    fetch('{{ route("tamu.notifications.unread-count") }}')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notif-badge');
            if (data.count > 0) {
                badge.textContent = data.count > 99 ? '99+' : data.count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        });
}
</script>
@endauth
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
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

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-[Figtree]">

{{-- NAVBAR --}}
<nav class="bg-white shadow-md fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        {{-- LOGO --}}
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/tarsanhomestay.png') }}" class="h-14">
            <span class="font-bold text-lg">Tarsan Homestay</span>
        </a>

        {{-- MENU --}}
        <div class="flex items-center space-x-6">
            <a href="#home" class="hover:text-blue-600">Home</a>
            <a href="#about" class="hover:text-blue-600">About</a>
            <a href="#facilities" class="hover:text-blue-600">Facilities</a>
            <a href="#contact" class="hover:text-blue-600">Contact</a>
        </div>

        {{-- AUTH AREA --}}
        <div class="relative flex items-center gap-4">
            @guest
                {{-- BELUM LOGIN --}}
                <a href="{{ route('login') }}"
                   class="px-4 py-2 border rounded hover:bg-gray-100">
                    Login
                </a>

                <a href="{{ route('register') }}"
                   class="ml-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Register
                </a>
            @endguest

            @auth
                {{-- SUDAH LOGIN --}}
                <a href="{{ route('tamu.booking.index') }}"
                    class="mr-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Book
                </a>
                <div class="group relative inline-block">
                    <button class="flex items-center gap-2 focus:outline-none">
                    <img
    src="{{ Auth::user()->photo
        ? asset('storage/' . Auth::user()->photo)
        : asset('images/default-avatar.png') }}"
    class="h-10 w-10 rounded-full object-cover">

                        <span class="font-medium">
                            {{ auth()->user()->name }}
                        </span>
                    </button>

                    {{-- DROPDOWN --}}
                    <div
                        class="absolute right-0 mt-3 w-48 bg-white border rounded shadow-md
                               opacity-0 invisible group-hover:opacity-100
                               group-hover:visible transition-all duration-200">

                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-2 hover:bg-gray-100">
                            Edit Profile
                        </a>

                        <a href="{{ route('tamu.orders') }}"
                           class="block px-4 py-2 hover:bg-gray-100">
                            My Order
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>


{{-- HERO SECTION --}}
<section id="beranda"
    class="relative min-h-screen flex items-center justify-center text-white"
    style="background-image: url('{{ asset('images/hero.png') }}'); background-size: cover; background-position: center;"
>

    {{-- Overlay gelap --}}
    <div class="absolute inset-0 bg-black/50"></div>

    {{-- Konten --}}
    <div class="relative z-10 max-w-4xl mx-auto text-center px-6">
    <h1 class="text-5xl md:text-6xl font-[Playfair_Display] font-bold mb-6 leading-tight tracking-wide">
    The Best Stay Experience<br>In Labuan Bajo
</h1>

<p class="mb-10 text-lg text-gray-200">
    Book your room easily, quickly, and securely directly with us.
</p>


        {{-- SEARCH BOX --}}
        <form
            action="{{ route('tamu.booking.index') }}"
            method="GET"
            class="bg-white p-4 rounded shadow-md flex flex-col md:flex-row gap-4 text-black">

            <input
                type="date"
                name="check_in"
                class="border p-2 rounded w-full">

            <input
                type="date"
                name="check_out"
                class="border p-2 rounded w-full">

            <button
                type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Search
            </button>
        </form>


</section>


<section id="tentang" class="bg-white py-20">
    <div class="max-w-4xl mx-auto text-center px-6">
    <h2 class="text-gray-500 uppercase tracking-widest mb-3">
    Welcome to
</h2>

<h2 class="text-6xl font-[Playfair_Display] font-bold mb-10 tracking-wide">
    Tarsan Homestay
</h2>


        <p class="text-gray-700 leading-relaxed mb-4">
        Tarsan Homestay is located at Labuan Bajo, West Manggarai Regency, East Nusa Tenggara, designed to meet the needs of travelers for comfortable, affordable, and accessible accommodation. As one of Indonesia's leading tourist destinations and the gateway to Komodo National Park, Labuan Bajo experiences a steadily increasing number of tourist visits each year, making the need for professional accommodation services increasingly crucial.        </p>

        <p class="text-gray-700 leading-relaxed mb-4">
        Tarsan Homestay offers a variety of rooms designed to provide comfort for both domestic and international guests. Each room is equipped with basic amenities to ensure a comfortable stay, as well as a clean and safe environment. Prioritizing friendly and responsive service, Tarsan Homestay is committed to providing a pleasant and memorable stay for every guest.        </p>

        <p class="text-gray-700 leading-relaxed">
        We hope all our guests enjoy and are comfortable with the facilities we offer. Have a great holiday! Thank you 😍        </p>
    </div>
</section>

<section id="keunggulan" class="bg-gray-100 py-20">
    <div class="max-w-6xl mx-auto px-6">
    <h2 class="text-4xl font-[Playfair_Display] font-bold text-center mb-14">
    Advantages of Direct Booking
</h2>


        <div class="grid md:grid-cols-3 gap-8 text-center">
            <div class="bg-white p-6 rounded shadow">
            <h3 class="font-semibold mb-2">Transparent Price</h3>


                <p class="text-gray-600">
                    Room prices are displayed directly without any additional fees from third parties.
                </p>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h3 class="font-semibold mb-2">Fast Order</h3>
                <p class="text-gray-600">
                    Orders can be made quickly through a web-based system.
                </p>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h3 class="font-semibold mb-2">Full Control</h3>
                <p class="text-gray-600">
                    You can monitor the order status independently via the dashboard.
                </p>
            </div>
        </div>
    </div>
</section>

<section id="fasilitas" class="bg-white py-24">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-4xl font-[Playfair_Display] font-bold text-center mb-16">
        Our Facilities
        </h2>

        <div class="grid md:grid-cols-3 gap-10">
            {{-- KAMAR --}}
            <div class="text-center">
                <img src="{{ asset('images/room.png') }}"
                     class="w-full h-80 object-cover rounded mb-6">

                     <h3 class="text-2xl font-[Playfair_Display] font-semibold mb-3">
                        Rooms & Suites
                    </h3>


                <p class="text-gray-600 mb-4">
                    Comfortable rooms with modern design are equipped with supporting facilities to provide the best possible stay.
                </p>

                <a href="{{ route('tamu.rooms') }}"
                   class="inline-block px-6 py-2 border rounded hover:bg-gray-100">
                    Explore
                </a>
            </div>

            {{-- FASILITAS --}}
            <div class="text-center">
                <img src="{{ asset('images/facility.jpg') }}"
                     class="w-full h-80 object-cover rounded mb-6">

                <h3 class="text-xl font-semibold mb-2">Homestay Facilities</h3>

                <p class="text-gray-600 mb-4">
                    Supporting facilities are available such as a relaxation area, Wi-Fi, billiards, motorbike rental, and a comfortable environment for resting.
                </p>

                <a href="#"
                   class="inline-block px-6 py-2 border rounded hover:bg-gray-100">
                    Explore
                </a>
            </div>

            {{-- KULINER --}}
            <div class="text-center">
                <img src="{{ asset('images/dining.jpg') }}"
                     class="w-full h-80 object-cover rounded mb-6">

                <h3 class="text-xl font-semibold mb-2">Dining Experience</h3>

                <p class="text-gray-600 mb-4">
                    A culinary experience with a selection of menus is prepared to enhance your comfort during your stay.
                </p>

                <a href="#"
                   class="inline-block px-6 py-2 border rounded hover:bg-gray-100">
                    Explore
                </a>
            </div>
        </div>
    </div>
</section>

<section class="bg-blue-600 py-16 text-center text-white">
    <h2 class="text-4xl font-[Playfair_Display] font-bold mb-4 tracking-wide">
        Get Your Room Now!
    </h2>

    <p class="mb-6">
        Login or register to easily book a room.
    </p>

    <a href="{{ route('tamu.booking.index') }}"
       class="bg-white text-blue-600 px-6 py-3 rounded font-semibold">
        Book Now
    </a>
</section>

<footer class="bg-gray-900 text-gray-300 py-8">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-8 text-sm">

        {{-- Informasi --}}
        <div>
            <h4 class="font-[Playfair_Display] text-lg font-semibold mb-2 text-white">
                Tarsan Homestay
            </h4>

            <a 
                href="https://maps.app.goo.gl/7pmmdcZEvY4FtAEk6"
                target="_blank"
                class="hover:text-white underline"
            >
                Labuan Bajo, Kec. Komodo, Kab. Manggarai Barat, Nusa Tenggara Timur
            </a>
        </div>

        {{-- Kontak --}}
        <div>
            <h4 class="font-semibold mb-2 text-white">Contact</h4>
            <p>Email: 
                <a href="mailto:tarsanhomestay@gmail.com" class="hover:text-white underline">
                    tarsanhomestay@gmail.com
                </a>
            </p>
            <p>Phone: 
                <a href="tel:082146562293" class="hover:text-white underline">
                    0821-4656-2293
                </a>
            </p>
        </div>

        {{-- Navigasi --}}
        <div>
            <h4 class="font-semibold mb-2 text-white">Navigation</h4>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('beranda') }}" class="hover:text-white">
                        Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('kamar.index') }}" class="hover:text-white">
                        Rooms
                    </a>
                </li>
                <li>
                    <a href="{{ route('pesanan.saya') }}" class="hover:text-white">
                        My Orders
                    </a>
                </li>
            </ul>
        </div>

    </div>

    <div class="text-center text-xs text-gray-400 mt-8 border-t border-gray-700 pt-4">
        © {{ date('Y') }} Tarsan Homestay. All rights reserved.
    </div>
</footer>



</body>
</html>

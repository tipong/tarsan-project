<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dining Experience – Tarsan Homestay</title>
    <meta name="description" content="Discover the dining experience at Tarsan Homestay – a culinary journey with a selection of menus to enhance your comfort in Labuan Bajo.">
    <link rel="icon" type="image/png" href="{{ asset('tarsanhomestay.png') }}">
    @include('layouts.assets')
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f8f5ef; color: #2a2a2a; overflow-x: hidden; }

        /* NAVBAR */
        .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 20px 48px; display: flex; align-items: center; justify-content: space-between; background: transparent; transition: background 0.4s ease, padding 0.4s ease; }
        .navbar.scrolled { background: rgba(248,245,239,0.96); backdrop-filter: blur(12px); padding: 14px 48px; box-shadow: 0 1px 0 rgba(0,0,0,0.08); }
        .navbar-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .navbar-logo img { height: 44px; object-fit: contain; }
        .navbar-logo span { font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 600; color: #fff; transition: color 0.4s; }
        .navbar.scrolled .navbar-logo span { color: #2a2a2a; }
        .navbar-links { display: flex; align-items: center; gap: 36px; }
        .navbar-links a { font-size: 13px; font-weight: 400; letter-spacing: 0.08em; text-transform: uppercase; color: rgba(255,255,255,0.85); text-decoration: none; transition: color 0.3s; }
        .navbar-links a:hover { color: #fff; }
        .navbar.scrolled .navbar-links a { color: #555; }
        .navbar.scrolled .navbar-links a:hover { color: #2a2a2a; }
        .navbar-cta { padding: 9px 22px; border: 1px solid rgba(255,255,255,0.5); color: #fff; font-size: 12px; font-weight: 500; letter-spacing: 0.1em; text-transform: uppercase; text-decoration: none; transition: all 0.3s; }
        .navbar-cta:hover { background: rgba(255,255,255,0.15); }
        .navbar.scrolled .navbar-cta { border-color: #2a2a2a; color: #2a2a2a; }
        .navbar.scrolled .navbar-cta:hover { background: #2a2a2a; color: #fff; }

        /* HERO */
        .hero { position: relative; height: 100vh; min-height: 600px; overflow: hidden; display: flex; align-items: flex-end; }
        .hero-bg { position: absolute; inset: 0; background-image: url('{{ asset('images/dining.jpg') }}'); background-size: cover; background-position: center; transform: scale(1.05); transition: transform 8s ease; }
        .hero-bg.loaded { transform: scale(1); }
        .hero-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.72) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0.05) 100%); }
        .hero-content { position: relative; z-index: 2; width: 100%; padding: 0 72px 72px; display: flex; justify-content: space-between; align-items: flex-end; }
        .hero-title { font-family: 'Playfair Display', serif; font-size: clamp(52px, 7vw, 90px); font-weight: 400; font-style: italic; color: #fff; line-height: 1.05; letter-spacing: -0.02em; max-width: 600px; }
        .hero-meta { text-align: right; color: rgba(255,255,255,0.75); }
        .hero-meta p { font-size: 13px; letter-spacing: 0.15em; text-transform: uppercase; font-weight: 300; max-width: 260px; }
        .scroll-indicator { position: absolute; bottom: 32px; left: 50%; transform: translateX(-50%); display: flex; flex-direction: column; align-items: center; gap: 8px; color: rgba(255,255,255,0.6); font-size: 11px; letter-spacing: 0.15em; text-transform: uppercase; z-index: 2; animation: bounce 2s infinite; }
        .scroll-indicator svg { width: 20px; height: 20px; }
        @keyframes bounce { 0%, 100% { transform: translateX(-50%) translateY(0); } 50% { transform: translateX(-50%) translateY(6px); } }

        /* INTRO */
        .intro-section { background: #f4f0e6; padding: 100px 48px; text-align: center; }
        .section-tag { display: inline-block; font-size: 11px; font-weight: 600; letter-spacing: 0.25em; text-transform: uppercase; color: #8a7a65; margin-bottom: 24px; }
        .intro-title { font-family: 'Playfair Display', serif; font-size: clamp(36px, 5vw, 64px); font-weight: 400; color: #1a1a1a; line-height: 1.15; max-width: 700px; margin: 0 auto 28px; }
        .intro-title em { font-style: italic; color: #6b5c47; }
        .intro-text { font-size: 17px; font-weight: 300; line-height: 1.85; color: #5a5a5a; max-width: 600px; margin: 0 auto; }

        /* SPLIT */
        .split-section { display: grid; grid-template-columns: 1fr 1fr; min-height: 80vh; }
        .split-section.reverse { direction: rtl; }
        .split-section.reverse > * { direction: ltr; }
        .split-text { background: #f4f0e6; padding: 80px 64px; display: flex; flex-direction: column; justify-content: center; }
        .split-number { font-family: 'Playfair Display', serif; font-size: 96px; font-weight: 300; color: rgba(0,0,0,0.06); line-height: 1; margin-bottom: -20px; }
        .split-label { font-size: 11px; font-weight: 600; letter-spacing: 0.25em; text-transform: uppercase; color: #8a7a65; margin-bottom: 20px; }
        .split-title { font-family: 'Playfair Display', serif; font-size: clamp(28px, 3.5vw, 44px); font-weight: 400; color: #1a1a1a; line-height: 1.2; margin-bottom: 20px; }
        .split-title em { font-style: italic; color: #6b5c47; }
        .split-desc { font-size: 15px; font-weight: 300; line-height: 1.9; color: #5a5a5a; margin-bottom: 36px; }
        .split-features { list-style: none; display: flex; flex-direction: column; gap: 12px; margin-bottom: 36px; }
        .split-features li { display: flex; align-items: center; gap: 12px; font-size: 14px; color: #4a4a4a; font-weight: 400; }
        .split-features li::before { content: ''; width: 20px; height: 1px; background: #8a7a65; flex-shrink: 0; }
        .split-image { position: relative; overflow: hidden; }
        .split-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.8s ease; }
        .split-section:hover .split-image img { transform: scale(1.03); }

        /* MENU CARDS */
        .menu-section { background: #fff; padding: 100px 48px; }
        .section-header { text-align: center; margin-bottom: 64px; }
        .section-title { font-family: 'Playfair Display', serif; font-size: clamp(32px, 4.5vw, 56px); font-weight: 400; color: #1a1a1a; line-height: 1.15; margin-bottom: 16px; }
        .section-title em { font-style: italic; color: #6b5c47; }
        .section-subtitle { font-size: 15px; font-weight: 300; color: #888; max-width: 480px; margin: 0 auto; line-height: 1.7; }
        .menu-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px; }
        .menu-card { position: relative; overflow: hidden; cursor: pointer; aspect-ratio: 3/4; }
        .menu-card img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.7s ease; }
        .menu-card:hover img { transform: scale(1.07); }
        .menu-card-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0) 55%); display: flex; flex-direction: column; justify-content: flex-end; padding: 32px 28px; }
        .menu-card-tag { font-size: 10px; font-weight: 600; letter-spacing: 0.2em; text-transform: uppercase; color: rgba(255,255,255,0.65); margin-bottom: 8px; }
        .menu-card-title { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 500; color: #fff; line-height: 1.2; }
        .menu-card-desc { font-size: 13px; font-weight: 300; color: rgba(255,255,255,0.75); margin-top: 8px; line-height: 1.6; opacity: 0; transform: translateY(8px); transition: all 0.4s ease; }
        .menu-card:hover .menu-card-desc { opacity: 1; transform: translateY(0); }

        /* GALLERY */
        .gallery-section { background: #f4f0e6; padding: 100px 48px; }
        .gallery-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 48px; }
        .gallery-title { font-family: 'Playfair Display', serif; font-size: clamp(28px, 4vw, 48px); font-weight: 400; color: #1a1a1a; line-height: 1.15; }
        .gallery-title em { font-style: italic; color: #6b5c47; }
        .gallery-subtitle { font-size: 14px; font-weight: 300; color: #888; max-width: 320px; text-align: right; line-height: 1.7; }
        .gallery-grid { display: grid; grid-template-columns: repeat(12, 1fr); gap: 10px; }
        .gallery-item { overflow: hidden; cursor: pointer; position: relative; }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
        .gallery-item:hover img { transform: scale(1.06); }
        .g1 { grid-column: 1 / 7; height: 360px; }
        .g2 { grid-column: 7 / 10; height: 360px; }
        .g3 { grid-column: 10 / 13; height: 360px; }
        .g4 { grid-column: 1 / 4; height: 280px; }
        .g5 { grid-column: 4 / 9; height: 280px; }
        .g6 { grid-column: 9 / 13; height: 280px; }

        /* CTA */
        .cta-section { position: relative; height: 520px; overflow: hidden; display: flex; align-items: center; justify-content: center; }
        .cta-bg { position: absolute; inset: 0; background-image: url('{{ asset('images/dining.jpg') }}'); background-size: cover; background-position: center 40%; filter: brightness(0.4); }
        .cta-content { position: relative; z-index: 2; text-align: center; padding: 0 32px; }
        .cta-tag { font-size: 11px; font-weight: 600; letter-spacing: 0.3em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 20px; }
        .cta-title { font-family: 'Playfair Display', serif; font-size: clamp(36px, 6vw, 80px); font-weight: 400; font-style: italic; color: #fff; line-height: 1.1; margin-bottom: 36px; }
        .cta-btn { display: inline-block; padding: 14px 40px; border: 1px solid rgba(255,255,255,0.6); color: #fff; font-size: 12px; font-weight: 500; letter-spacing: 0.2em; text-transform: uppercase; text-decoration: none; transition: all 0.3s; }
        .cta-btn:hover { background: rgba(255,255,255,0.12); border-color: #fff; }

        /* FOOTER */
        .page-footer { background: #1a1a1a; color: rgba(255,255,255,0.5); padding: 48px; display: flex; justify-content: space-between; align-items: center; font-size: 13px; }
        .footer-logo { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 500; color: #fff; }
        .footer-links { display: flex; gap: 28px; }
        .footer-links a { color: rgba(255,255,255,0.5); text-decoration: none; font-size: 12px; letter-spacing: 0.1em; text-transform: uppercase; transition: color 0.3s; }
        .footer-links a:hover { color: #fff; }

        /* ANIMATIONS */
        .fade-up { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .navbar { padding: 16px 24px; }
            .navbar.scrolled { padding: 12px 24px; }
            .navbar-links { display: none; }
            .hero-content { padding: 0 32px 48px; flex-direction: column; align-items: flex-start; gap: 20px; }
            .hero-meta { text-align: left; }
            .split-section { grid-template-columns: 1fr; }
            .split-section.reverse { direction: ltr; }
            .split-image { height: 50vw; min-height: 280px; }
            .split-text { padding: 56px 32px; }
            .menu-grid { grid-template-columns: 1fr; }
            .menu-card { aspect-ratio: 4/3; }
            .gallery-grid { grid-template-columns: 1fr 1fr; }
            .g1,.g2,.g3,.g4,.g5,.g6 { grid-column: auto; height: 200px; }
            .gallery-header { flex-direction: column; align-items: flex-start; gap: 12px; }
            .gallery-subtitle { text-align: left; }
            .intro-section, .menu-section, .gallery-section { padding: 72px 24px; }
            .page-footer { flex-direction: column; gap: 24px; text-align: center; padding: 40px 24px; }
            .footer-links { flex-wrap: wrap; justify-content: center; }
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar" id="mainNav">
    <a href="{{ url('/') }}" class="navbar-logo">
        <img src="{{ asset('images/tarsanhomestay.png') }}" alt="Tarsan Homestay">
        <span>Tarsan Homestay</span>
    </a>
    <div class="navbar-links">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('/') }}#tentang">About</a>
        <a href="{{ url('/') }}#fasilitas">Facilities</a>
        <a href="{{ route('kamar.index') }}">Rooms</a>
        <a href="{{ url('/') }}#kontak">Contact</a>
    </div>
    @auth
        <a href="{{ route('tamu.booking.index') }}" class="navbar-cta">Book Now</a>
    @else
        <a href="{{ route('login') }}" class="navbar-cta">Sign In</a>
    @endauth
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="hero-bg" id="heroBg"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title">Dining<br><em>Experience</em></h1>
        <div class="hero-meta">
            <p>Culinary comfort<br>crafted for every<br>traveler's palate</p>
        </div>
    </div>
    <div class="scroll-indicator">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/></svg>
    </div>
</section>

{{-- INTRO --}}
<section class="intro-section">
    <span class="section-tag fade-up">Tarsan Homestay · Labuan Bajo</span>
    <h2 class="intro-title fade-up">Savour every<br>meal like a <em>memory</em></h2>
    <p class="intro-text fade-up">
        Our dining experience is thoughtfully curated to complement your stay. From hearty Indonesian breakfasts to light evening meals, every dish is prepared with fresh local ingredients to delight your senses.
    </p>
</section>

{{-- BREAKFAST --}}
<section class="split-section">
    <div class="split-text fade-up">
        <div class="split-number">01</div>
        <span class="split-label">Morning Ritual</span>
        <h2 class="split-title">A warm<br><em>breakfast</em> awaits</h2>
        <p class="split-desc">
            Start your day the right way with our wholesome breakfast offerings. Freshly prepared and served in a relaxed setting, our morning meals fuel your adventure through Komodo National Park.
        </p>
        <ul class="split-features">
            <li>Indonesian & Western options</li>
            <li>Fresh local ingredients</li>
            <li>Served daily every morning</li>
        </ul>
    </div>
    <div class="split-image">
        <img src="{{ asset('images/dining.jpg') }}" alt="Breakfast">
    </div>
</section>

{{-- LOCAL CUISINE --}}
<section class="split-section reverse">
    <div class="split-text fade-up">
        <div class="split-number">02</div>
        <span class="split-label">Authentic Flavours</span>
        <h2 class="split-title"><em>Local cuisine</em><br>done right</h2>
        <p class="split-desc">
            Taste the authentic flavours of East Nusa Tenggara with our handpicked local dishes. From fresh seafood to traditional Flores recipes, every meal tells a story of the region's rich culinary heritage.
        </p>
        <ul class="split-features">
            <li>Fresh seafood from local waters</li>
            <li>Traditional Flores recipes</li>
            <li>Seasonal local produce</li>
        </ul>
    </div>
    <div class="split-image">
        <img src="{{ asset('images/hero.png') }}" alt="Local Cuisine">
    </div>
</section>

{{-- EVENING MEALS --}}
<section class="split-section">
    <div class="split-text fade-up">
        <div class="split-number">03</div>
        <span class="split-label">Evening Comfort</span>
        <h2 class="split-title">Relax over a<br><em>home-cooked</em> dinner</h2>
        <p class="split-desc">
            After a day of exploring, there's nothing better than sitting down to a satisfying home-cooked dinner. Our evening menu blends comfort and creativity to end your day perfectly.
        </p>
        <ul class="split-features">
            <li>Rotating daily menu</li>
            <li>Vegetarian-friendly options</li>
            <li>Made with care & fresh produce</li>
        </ul>
        @auth
        <a href="{{ route('tamu.booking.index') }}" style="display:inline-block; padding:12px 32px; border:1px solid #2a2a2a; color:#2a2a2a; font-size:12px; font-weight:500; letter-spacing:0.15em; text-transform:uppercase; text-decoration:none; transition:all 0.3s;" onmouseover="this.style.background='#2a2a2a'; this.style.color='#f4f0e6'" onmouseout="this.style.background=''; this.style.color='#2a2a2a'">Book Your Stay</a>
        @else
        <a href="{{ route('login') }}" style="display:inline-block; padding:12px 32px; border:1px solid #2a2a2a; color:#2a2a2a; font-size:12px; font-weight:500; letter-spacing:0.15em; text-transform:uppercase; text-decoration:none; transition:all 0.3s;" onmouseover="this.style.background='#2a2a2a'; this.style.color='#f4f0e6'" onmouseout="this.style.background=''; this.style.color='#2a2a2a'">Sign In to Book</a>
        @endauth
    </div>
    <div class="split-image">
        <img src="{{ asset('images/dining.jpg') }}" alt="Evening Meals">
    </div>
</section>

{{-- MENU SHOWCASE --}}
<section class="menu-section">
    <div class="section-header fade-up">
        <span class="section-tag">On The Menu</span>
        <h2 class="section-title">Our culinary<br><em>offerings</em></h2>
        <p class="section-subtitle">A selection of dishes crafted to satisfy every taste – from light snacks to full meals.</p>
    </div>
    <div class="menu-grid">
        <div class="menu-card">
            <img src="{{ asset('images/dining.jpg') }}" alt="Breakfast">
            <div class="menu-card-overlay">
                <span class="menu-card-tag">Morning</span>
                <h3 class="menu-card-title">Indonesian Breakfast</h3>
                <p class="menu-card-desc">Nasi goreng, mie goreng, fresh fruit and local favourites to start your day.</p>
            </div>
        </div>
        <div class="menu-card">
            <img src="{{ asset('images/hero.png') }}" alt="Seafood">
            <div class="menu-card-overlay">
                <span class="menu-card-tag">Local Catch</span>
                <h3 class="menu-card-title">Fresh Seafood</h3>
                <p class="menu-card-desc">Grilled fish, calamari and prawns sourced fresh from Labuan Bajo's waters.</p>
            </div>
        </div>
        <div class="menu-card">
            <img src="{{ asset('images/dining.jpg') }}" alt="Drinks">
            <div class="menu-card-overlay">
                <span class="menu-card-tag">Refreshments</span>
                <h3 class="menu-card-title">Tropical Beverages</h3>
                <p class="menu-card-desc">Fresh juices, coconut water and local herbal drinks to keep you refreshed.</p>
            </div>
        </div>
    </div>
</section>

{{-- GALLERY --}}
<section class="gallery-section">
    <div class="gallery-header fade-up">
        <h2 class="gallery-title">Dining<br><em>Gallery</em></h2>
        <p class="gallery-subtitle">A glimpse into the flavours and moments that make every meal at Tarsan Homestay special.</p>
    </div>
    <div class="gallery-grid">
        <div class="gallery-item g1"><img src="{{ asset('images/dining.jpg') }}" alt="Dining 1"></div>
        <div class="gallery-item g2"><img src="{{ asset('images/hero.png') }}" alt="Dining 2"></div>
        <div class="gallery-item g3"><img src="{{ asset('images/facility.jpg') }}" alt="Dining 3"></div>
        <div class="gallery-item g4"><img src="{{ asset('images/room.png') }}" alt="Dining 4"></div>
        <div class="gallery-item g5"><img src="{{ asset('images/dining.jpg') }}" alt="Dining 5"></div>
        <div class="gallery-item g6"><img src="{{ asset('images/hero.png') }}" alt="Dining 6"></div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="cta-bg"></div>
    <div class="cta-content fade-up">
        <p class="cta-tag">Stay & Dine With Us</p>
        <h2 class="cta-title">Reserve your<br>table & room</h2>
        @auth
            <a href="{{ route('tamu.booking.index') }}" class="cta-btn">Book Now</a>
        @else
            <a href="{{ route('login') }}" class="cta-btn">Get Started</a>
        @endauth
    </div>
</section>

{{-- FOOTER --}}
<footer class="page-footer" id="kontak">
    <div class="footer-logo">Tarsan Homestay</div>
    <div class="footer-links">
        <a href="{{ route('tamu.dashboard') }}">Home</a>
        <a href="{{ route('kamar.index') }}">Rooms</a>
        <a href="{{ route('tamu.facilities') }}">Facilities</a>
        <a href="{{ route('tamu.dining') }}">Dining</a>
        <a href="{{ route('tamu.dashboard') }}#kontak">Contact</a>
    </div>
    <p>© {{ date('Y') }} Tarsan Homestay</p>
</footer>

<script>
const nav = document.getElementById('mainNav');
window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 60);
});
window.addEventListener('load', () => {
    document.getElementById('heroBg').classList.add('loaded');
});
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
</script>
</body>
</html>

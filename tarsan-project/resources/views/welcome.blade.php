<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tarsan Homestay – Best Stay in Labuan Bajo</title>
    <meta name="description" content="Tarsan Homestay offers comfortable, affordable accommodation in Labuan Bajo, the gateway to Komodo National Park.">
    <link rel="icon" type="image/png" href="{{ asset('tarsanhomestay.png') }}">
    @include('layouts.assets')
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Inter',sans-serif;background:#f8f5ef;color:#2a2a2a;overflow-x:hidden}

/* NAVBAR */
.navbar{position:fixed;top:0;left:0;right:0;z-index:100;padding:20px 48px;display:flex;align-items:center;justify-content:space-between;transition:all .4s ease}
.navbar.scrolled{background:rgba(248,245,239,.96);backdrop-filter:blur(12px);padding:14px 48px;box-shadow:0 1px 0 rgba(0,0,0,.08)}
.nav-logo{display:flex;align-items:center;gap:10px;text-decoration:none}
.nav-logo img{height:42px;object-fit:contain}
.nav-logo span{font-family:'Playfair Display',serif;font-size:18px;font-weight:600;color:#fff;transition:color .4s}
.navbar.scrolled .nav-logo span{color:#2a2a2a}
.nav-links{display:flex;align-items:center;gap:32px}
.nav-links a{font-size:12px;font-weight:400;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.85);text-decoration:none;transition:color .3s}
.nav-links a:hover{color:#fff}
.navbar.scrolled .nav-links a{color:#555}
.navbar.scrolled .nav-links a:hover{color:#2a2a2a}
.nav-cta{padding:9px 22px;border:1px solid rgba(255,255,255,.5);color:#fff;font-size:11px;font-weight:500;letter-spacing:.12em;text-transform:uppercase;text-decoration:none;transition:all .3s}
.nav-cta:hover{background:rgba(255,255,255,.15)}
.navbar.scrolled .nav-cta{border-color:#2a2a2a;color:#2a2a2a}
.navbar.scrolled .nav-cta:hover{background:#2a2a2a;color:#fff}
.nav-auth{display:flex;align-items:center;gap:16px}

/* HERO */
.hero{position:relative;height:100vh;min-height:620px;overflow:hidden;display:flex;align-items:flex-end}
.hero-bg{position:absolute;inset:0;background-image:url('{{ asset('images/hero.png') }}');background-size:cover;background-position:center;transform:scale(1.05);transition:transform 8s ease}
.hero-bg.loaded{transform:scale(1)}
.hero-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.78) 0%,rgba(0,0,0,.35) 50%,rgba(0,0,0,.05) 100%)}
.hero-content{position:relative;z-index:2;width:100%;padding:0 72px 72px;display:flex;justify-content:space-between;align-items:flex-end;gap:24px}
.hero-title{font-family:'Playfair Display',serif;font-size:clamp(48px,7vw,88px);font-weight:400;font-style:italic;color:#fff;line-height:1.05;letter-spacing:-.02em;max-width:1000px}
.hero-right{text-align:right;color:rgba(255,255,255,.75);display:flex;flex-direction:column;align-items:flex-end;gap:24px}
.hero-sub{font-size:13px;letter-spacing:.15em;text-transform:uppercase;font-weight:300;max-width:240px;line-height:1.7}
.scroll-hint{position:absolute;bottom:32px;left:50%;transform:translateX(-50%);display:flex;flex-direction:column;align-items:center;gap:6px;color:rgba(255,255,255,.55);font-size:10px;letter-spacing:.2em;text-transform:uppercase;z-index:2;animation:bob 2.2s infinite}
@keyframes bob{0%,100%{transform:translateX(-50%) translateY(0)}50%{transform:translateX(-50%) translateY(7px)}}

/* SEARCH BOX */
.search-box{background:rgba(255,255,255,.12);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,.2);padding:6px;display:flex;gap:6px;align-items:center}
.search-box input{background:#fff;border:none;outline:none;padding:10px 14px;font-size:13px;color:#2a2a2a;font-family:'Inter',sans-serif;width:160px}
.search-box button{background:#fff;color:#2a2a2a;border:none;padding:10px 20px;font-size:11px;font-weight:600;letter-spacing:.12em;text-transform:uppercase;cursor:pointer;transition:all .3s;white-space:nowrap;font-family:'Inter',sans-serif}
.search-box button:hover{background:#f4f0e6}

/* SECTION SHARED */
.section-tag{display:inline-block;font-size:11px;font-weight:600;letter-spacing:.25em;text-transform:uppercase;color:#8a7a65;margin-bottom:20px}

/* ABOUT */
.about-section{background:#f4f0e6;padding:100px 48px;text-align:center}
.about-title{font-family:'Playfair Display',serif;font-size:clamp(36px,5vw,62px);font-weight:400;color:#1a1a1a;line-height:1.15;max-width:680px;margin:0 auto 28px}
.about-title em{font-style:italic;color:#6b5c47}
.about-text{font-size:16px;font-weight:300;line-height:1.9;color:#5a5a5a;max-width:640px;margin:0 auto 16px}

/* ADVANTAGES */
.adv-section{background:#fff;padding:100px 48px}
.adv-header{text-align:center;margin-bottom:64px}
.adv-title{font-family:'Playfair Display',serif;font-size:clamp(30px,4vw,52px);font-weight:400;color:#1a1a1a;line-height:1.15}
.adv-title em{font-style:italic;color:#6b5c47}
.adv-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1px;background:#e8e0d5}
.adv-card{background:#f4f0e6;padding:56px 40px;display:flex;flex-direction:column;gap:20px;transition:background .3s}
.adv-card:hover{background:#ece8de}
.adv-num{font-family:'Playfair Display',serif;font-size:48px;font-weight:300;color:rgba(0,0,0,.08);line-height:1}
.adv-label{font-size:11px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;color:#8a7a65}
.adv-name{font-family:'Playfair Display',serif;font-size:24px;font-weight:400;color:#1a1a1a;line-height:1.2}
.adv-desc{font-size:14px;font-weight:300;line-height:1.85;color:#5a5a5a}

/* FACILITIES */
.fac-section{background:#f4f0e6;padding:100px 48px}
.fac-header{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:56px}
.fac-title{font-family:'Playfair Display',serif;font-size:clamp(30px,4vw,52px);font-weight:400;color:#1a1a1a;line-height:1.15}
.fac-title em{font-style:italic;color:#6b5c47}
.fac-sub{font-size:13px;font-weight:300;color:#888;max-width:280px;text-align:right;line-height:1.7}
.fac-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:2px}
.fac-card{position:relative;overflow:hidden;cursor:pointer;height:480px}
.fac-card img{width:100%;height:100%;object-fit:cover;transition:transform .8s ease}
.fac-card:hover img{transform:scale(1.06)}
.fac-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.78) 0%,rgba(0,0,0,0) 55%);display:flex;flex-direction:column;justify-content:flex-end;padding:36px 32px;transition:all .3s}
.fac-card-tag{font-size:10px;font-weight:600;letter-spacing:.25em;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:10px}
.fac-card-name{font-family:'Playfair Display',serif;font-size:26px;font-weight:400;font-style:italic;color:#fff;line-height:1.2;margin-bottom:12px}
.fac-card-desc{font-size:13px;font-weight:300;color:rgba(255,255,255,.75);line-height:1.65;margin-bottom:24px;opacity:0;transform:translateY(8px);transition:all .4s}
.fac-card:hover .fac-card-desc{opacity:1;transform:translateY(0)}
.fac-card-link{display:inline-block;padding:10px 24px;border:1px solid rgba(255,255,255,.55);color:#fff;font-size:11px;font-weight:500;letter-spacing:.15em;text-transform:uppercase;text-decoration:none;transition:all .3s}
.fac-card-link:hover{background:rgba(255,255,255,.15);border-color:#fff}

/* CTA */
.cta-section{position:relative;height:500px;overflow:hidden;display:flex;align-items:center;justify-content:center}
.cta-bg{position:absolute;inset:0;background-image:url('{{ asset('images/room.png') }}');background-size:cover;background-position:center 40%;filter:brightness(.4)}
.cta-content{position:relative;z-index:2;text-align:center;padding:0 32px}
.cta-tag{font-size:11px;font-weight:600;letter-spacing:.3em;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:20px}
.cta-title{font-family:'Playfair Display',serif;font-size:clamp(36px,6vw,78px);font-weight:400;font-style:italic;color:#fff;line-height:1.1;margin-bottom:36px}
.cta-btn{display:inline-block;padding:14px 40px;border:1px solid rgba(255,255,255,.6);color:#fff;font-size:11px;font-weight:500;letter-spacing:.2em;text-transform:uppercase;text-decoration:none;transition:all .3s}
.cta-btn:hover{background:rgba(255,255,255,.12);border-color:#fff}
.cta-btn-outline{display:inline-block;padding:14px 40px;border:1px solid rgba(255,255,255,.4);color:rgba(255,255,255,.8);font-size:11px;font-weight:400;letter-spacing:.2em;text-transform:uppercase;text-decoration:none;transition:all .3s;margin-left:12px}
.cta-btn-outline:hover{border-color:rgba(255,255,255,.8);color:#fff}

/* FOOTER */
.footer{background:#1a1a1a;color:rgba(255,255,255,.45);padding:72px 48px 40px}
.footer-grid{display:grid;grid-template-columns:1.5fr 1fr 1fr;gap:48px;margin-bottom:56px}
.footer-brand{font-family:'Playfair Display',serif;font-size:22px;font-weight:500;color:#fff;margin-bottom:16px}
.footer-about{font-size:13px;font-weight:300;line-height:1.8;color:rgba(255,255,255,.45);margin-bottom:20px}
.footer-contact a{display:block;font-size:13px;color:rgba(255,255,255,.5);text-decoration:none;margin-bottom:8px;transition:color .3s}
.footer-contact a:hover{color:#fff}
.footer-col-title{font-size:11px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;color:rgba(255,255,255,.35);margin-bottom:20px}
.footer-col-links a{display:block;font-size:13px;font-weight:300;color:rgba(255,255,255,.5);text-decoration:none;margin-bottom:10px;transition:color .3s}
.footer-col-links a:hover{color:#fff}
.footer-bottom{border-top:1px solid rgba(255,255,255,.08);padding-top:28px;display:flex;justify-content:space-between;align-items:center;font-size:12px}

/* FADE-UP */
.fade-up{opacity:0;transform:translateY(28px);transition:opacity .7s ease,transform .7s ease}
.fade-up.visible{opacity:1;transform:translateY(0)}

/* RESPONSIVE */
@media(max-width:900px){
  .navbar,.navbar.scrolled{padding:16px 24px}
  .nav-links{display:none}
  .hero-content{padding:0 28px 48px;flex-direction:column;align-items:flex-start;gap:20px}
  .hero-right{align-items:flex-start;text-align:left}
  .about-section,.adv-section,.fac-section{padding:72px 24px}
  .adv-grid{grid-template-columns:1fr}
  .fac-grid{grid-template-columns:1fr}
  .fac-card{height:360px}
  .fac-header{flex-direction:column;align-items:flex-start;gap:12px}
  .fac-sub{text-align:left;max-width:100%}
  .footer{padding:56px 24px 32px}
  .footer-grid{grid-template-columns:1fr;gap:36px}
  .footer-bottom{flex-direction:column;gap:12px;text-align:center}
}
</style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar" id="mainNav">
    <a href="{{ url('/') }}" class="nav-logo">
        <img src="{{ asset('images/tarsanhomestay.png') }}" alt="Tarsan Homestay">
        <span>Tarsan Homestay</span>
    </a>
    <div class="nav-links">
        <a href="#beranda">Home</a>
        <a href="#tentang">About</a>
        <a href="#fasilitas">Facilities</a>
        <a href="{{ route('kamar.index') }}">Rooms</a>
        <a href="#kontak">Contact</a>
        @auth
        <a href="{{ route('tamu.notifications.index') }}" style="position:relative">
            Notifications
            <span id="notif-badge" style="position:absolute;top:-8px;right:-10px;background:#dc2626;color:#fff;font-size:10px;font-weight:700;border-radius:50%;width:16px;height:16px;display:none;align-items:center;justify-content:center"></span>
        </a>
        <a href="{{ route('tamu.orders') }}">My Orders</a>
        @endauth
    </div>
    <div class="nav-auth">
        @guest
            <a href="{{ route('login') }}" class="nav-cta">Login</a>
            <a href="{{ route('register') }}" class="nav-cta" >Register</a>
        @else
            <a href="{{ route('tamu.booking.index') }}" class="nav-cta">Book Now</a>
        @endguest
    </div>
</nav>

{{-- HERO --}}
<section class="hero" id="beranda">
    <div class="hero-bg" id="heroBg"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title">The Best Stay Experience<br>in <em>Labuan Bajo</em></h1>
        <div class="hero-right">
            <p class="hero-sub">Gateway to Komodo<br>National Park &<br>beyond</p>
            {{-- SEARCH BOX --}}
            @auth
            <form action="{{ route('tamu.booking.index') }}" method="GET" class="search-box">
                <input type="date" name="check_in" placeholder="Check In">
                <input type="date" name="check_out" placeholder="Check Out">
                <button type="submit">Search</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="nav-cta">Book Your Stay</a>
            @endauth
        </div>
    </div>
    <div class="scroll-hint">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/></svg>
    </div>
</section>

{{-- ABOUT --}}
<section class="about-section" id="tentang">
    <span class="section-tag fade-up">Welcome to</span>
    <h2 class="about-title fade-up">Tarsan <em>Homestay</em><br>Labuan Bajo</h2>
    <p class="about-text fade-up">
        Located in Labuan Bajo, West Manggarai Regency, East Nusa Tenggara — designed for travelers seeking comfortable, affordable, and accessible accommodation at the gateway to Komodo National Park.
    </p>
    <p class="about-text fade-up">
        Every room is equipped with essential amenities in a clean, welcoming environment. Friendly, responsive service is at the heart of everything we do. We hope you enjoy your stay. Have a wonderful holiday! 😍
    </p>
</section>

{{-- ADVANTAGES --}}
<section class="adv-section" id="keunggulan">
    <div class="adv-header fade-up">
        <span class="section-tag">Why book direct</span>
        <h2 class="adv-title">Advantages of<br><em>Direct Booking</em></h2>
    </div>
    <div class="adv-grid">
        <div class="adv-card fade-up">
            <div class="adv-num">01</div>
            <span class="adv-label">Pricing</span>
            <h3 class="adv-name">Transparent Price</h3>
            <p class="adv-desc">Room prices are displayed directly — no hidden fees or third-party markups.</p>
        </div>
        <div class="adv-card fade-up">
            <div class="adv-num">02</div>
            <span class="adv-label">Convenience</span>
            <h3 class="adv-name">Fast Booking</h3>
            <p class="adv-desc">Book quickly through our streamlined web-based reservation system.</p>
        </div>
        <div class="adv-card fade-up">
            <div class="adv-num">03</div>
            <span class="adv-label">Control</span>
            <h3 class="adv-name">Full Control</h3>
            <p class="adv-desc">Monitor your order status independently at any time from your personal dashboard.</p>
        </div>
    </div>
</section>

{{-- FACILITIES --}}
<section class="fac-section" id="fasilitas">
    <div class="fac-header fade-up">
        <h2 class="fac-title">Our<br><em>Offerings</em></h2>
        <p class="fac-sub">From comfortable rooms to curated experiences — everything you need for the perfect stay.</p>
    </div>
    <div class="fac-grid">
        {{-- ROOMS --}}
        <div class="fac-card">
            <img src="{{ asset('images/room.png') }}" alt="Rooms & Suites">
            <div class="fac-overlay">
                <span class="fac-card-tag">Accommodation</span>
                <h3 class="fac-card-name">Rooms & Suites</h3>
                <p class="fac-card-desc">Comfortable rooms with modern design and all essential amenities for the perfect stay.</p>
                <a href="{{ route('kamar.index') }}" class="fac-card-link">Explore Rooms</a>
            </div>
        </div>
        {{-- FACILITIES --}}
        <div class="fac-card">
            <img src="{{ asset('images/facility.jpg') }}" alt="Homestay Facilities">
            <div class="fac-overlay">
                <span class="fac-card-tag">Leisure</span>
                <h3 class="fac-card-name">Homestay Facilities</h3>
                <p class="fac-card-desc">Relaxation area, Wi-Fi, billiards, motorbike rental, and a comfortable environment for resting.</p>
                <a href="{{ route('tamu.facilities') }}" class="fac-card-link">Explore Facilities</a>
            </div>
        </div>
        {{-- DINING --}}
        <div class="fac-card">
            <img src="{{ asset('images/dining.jpg') }}" alt="Dining Experience">
            <div class="fac-overlay">
                <span class="fac-card-tag">Culinary</span>
                <h3 class="fac-card-name">Dining Experience</h3>
                <p class="fac-card-desc">A curated culinary experience with fresh local ingredients to enhance your comfort during your stay.</p>
                <a href="{{ route('tamu.dining') }}" class="fac-card-link">Explore Dining</a>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="cta-bg"></div>
    <div class="cta-content fade-up">
        <p class="cta-tag">Ready for your adventure?</p>
        <h2 class="cta-title">Book your<br>stay today</h2>
        @guest
            <a href="{{ route('login') }}" class="cta-btn">Login to Book</a>
            <a href="{{ route('register') }}" class="cta-btn-outline">Create Account</a>
        @else
            <a href="{{ route('tamu.booking.index') }}" class="cta-btn">Reserve Now</a>
        @endguest
    </div>
</section>

{{-- FOOTER --}}
<footer class="footer" id="kontak">
    <div class="footer-grid">
        <div>
            <div class="footer-brand">Tarsan Homestay</div>
            <p class="footer-about">Comfortable, affordable accommodation in Labuan Bajo — the gateway to Komodo National Park, East Nusa Tenggara.</p>
            <div class="footer-contact">
                <a href="https://maps.app.goo.gl/7pmmdcZEvY4FtAEk6" target="_blank">📍 Labuan Bajo, Kec. Komodo, Manggarai Barat, NTT</a>
                <a href="mailto:tarsanhomestay@gmail.com">✉ tarsanhomestay@gmail.com</a>
                <a href="tel:082146562293">☎ 0821-4656-2293</a>
            </div>
        </div>
        <div>
            <div class="footer-col-title">Explore</div>
            <div class="footer-col-links">
                <a href="#beranda">Home</a>
                <a href="{{ route('kamar.index') }}">Rooms</a>
                <a href="{{ route('tamu.facilities') }}">Facilities</a>
                <a href="{{ route('tamu.dining') }}">Dining</a>
                <a href="#kontak">Contact</a>
            </div>
        </div>
        <div>
            <div class="footer-col-title">Account</div>
            <div class="footer-col-links">
                @guest
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @else
                    <a href="{{ route('tamu.booking.index') }}">Book Now</a>
                    <a href="{{ route('tamu.orders') }}">My Orders</a>
                @endguest
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <span>© {{ date('Y') }} Tarsan Homestay. All rights reserved.</span>
        <span>Labuan Bajo, Indonesia</span>
    </div>
</footer>

@auth
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadUnreadCount();
    setInterval(loadUnreadCount, 30000);
});
function loadUnreadCount() {
    fetch('{{ route("tamu.notifications.unread-count") }}')
        .then(r => r.json())
        .then(data => {
            const b = document.getElementById('notif-badge');
            if (data.count > 0) {
                b.textContent = data.count > 99 ? '99+' : data.count;
                b.style.display = 'flex';
            } else { b.style.display = 'none'; }
        });
}
</script>
@endauth

<script>
const nav = document.getElementById('mainNav');
window.addEventListener('scroll', () => nav.classList.toggle('scrolled', scrollY > 60));
window.addEventListener('load', () => document.getElementById('heroBg').classList.add('loaded'));
const obs = new IntersectionObserver(entries => entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); }), {threshold:.1});
document.querySelectorAll('.fade-up').forEach(el => obs.observe(el));
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400;1,500&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tarsan Homestay')</title>
    <link rel="icon" type="image/png" href="{{ asset('tarsanhomestay.png') }}">
    @include('layouts.assets')
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Inter',sans-serif;background:#f8f5ef;color:#2a2a2a;overflow-x:hidden}
/* NAVBAR */
.nb{position:fixed;top:0;left:0;right:0;z-index:100;background:rgba(248,245,239,.96);backdrop-filter:blur(12px);box-shadow:0 1px 0 rgba(0,0,0,.08);padding:14px 48px;display:flex;align-items:center;justify-content:space-between}
.nb-logo{display:flex;align-items:center;gap:10px;text-decoration:none}
.nb-logo img{height:40px;object-fit:contain}
.nb-logo span{font-family:'Playfair Display',serif;font-size:18px;font-weight:600;color:#1a1a1a}
.nb-links{display:flex;align-items:center;gap:28px}
.nb-links a{font-size:12px;font-weight:400;letter-spacing:.1em;text-transform:uppercase;color:#555;text-decoration:none;transition:color .3s}
.nb-links a:hover,.nb-links a.active{color:#1a1a1a}
.nb-right{display:flex;align-items:center;gap:12px}
.btn-dark{padding:8px 22px;border:1px solid #1a1a1a;color:#1a1a1a;font-size:11px;font-weight:500;letter-spacing:.12em;text-transform:uppercase;text-decoration:none;transition:all .3s;background:transparent;cursor:pointer;font-family:'Inter',sans-serif;display:inline-block}
.btn-dark:hover{background:#1a1a1a;color:#fff}
.btn-fill{padding:8px 22px;border:1px solid #1a1a1a;background:#1a1a1a;color:#fff;font-size:11px;font-weight:500;letter-spacing:.12em;text-transform:uppercase;text-decoration:none;transition:all .3s;cursor:pointer;font-family:'Inter',sans-serif;display:inline-block}
.btn-fill:hover{background:#333;border-color:#333}
.aw{position:relative}
.ab{display:flex;align-items:center;gap:10px;background:rgba(0,0,0,.04);border:1px solid rgba(0,0,0,.1);padding:6px 14px 6px 6px;cursor:pointer;transition:all .3s;font-family:'Inter',sans-serif;background:transparent;border:none}
.ab img{width:32px;height:32px;border-radius:50%;object-fit:cover;border:1px solid rgba(0,0,0,.1)}
.ab span{font-size:13px;color:#1a1a1a;font-weight:400}
.dd{position:absolute;right:0;top:calc(100% + 8px);width:200px;background:#fff;border:1px solid rgba(0,0,0,.08);box-shadow:0 8px 32px rgba(0,0,0,.1);opacity:0;visibility:hidden;transition:all .25s;z-index:200}
.aw:hover .dd{opacity:1;visibility:visible}
.dd a,.dd button{display:block;width:100%;text-align:left;padding:12px 16px;font-size:13px;color:#444;text-decoration:none;background:none;border:none;cursor:pointer;font-family:'Inter',sans-serif;transition:background .2s}
.dd a:hover,.dd button:hover{background:#f4f0e6}
.dd hr{border:none;border-top:1px solid #f0ece5;margin:4px 0}
.dd .out{color:#dc2626}
.mob-toggle{display:none;background:none;border:none;cursor:pointer;padding:8px;color:#1a1a1a}
/* PAGE HEADER */
.ph{background:#1a1a1a;padding:96px 48px 56px;margin-top:68px}
.ph-tag{font-size:11px;font-weight:600;letter-spacing:.25em;text-transform:uppercase;color:rgba(255,255,255,.45);margin-bottom:14px;display:block}
.ph-title{font-family:'Playfair Display',serif;font-size:clamp(36px,5vw,64px);font-weight:400;font-style:italic;color:#fff;line-height:1.1}
.ph-sub{font-size:14px;font-weight:300;color:rgba(255,255,255,.5);margin-top:14px;max-width:480px;line-height:1.7}
/* MAIN CONTENT */
.main{max-width:1200px;margin:0 auto;padding:64px 48px}
/* LUXURY CARD */
.lcard{background:#fff;border:1px solid rgba(0,0,0,.07);transition:box-shadow .3s,border-color .3s}
.lcard:hover{box-shadow:0 8px 40px rgba(0,0,0,.08);border-color:rgba(0,0,0,.12)}
/* SECTION TITLE */
.stag{display:inline-block;font-size:11px;font-weight:600;letter-spacing:.25em;text-transform:uppercase;color:#8a7a65;margin-bottom:16px}
.stitle{font-family:'Playfair Display',serif;font-size:clamp(28px,4vw,48px);font-weight:400;color:#1a1a1a;line-height:1.15}
.stitle em{font-style:italic;color:#6b5c47}
/* FILTER BAR */
.filter-bar{background:#fff;border:1px solid rgba(0,0,0,.07);padding:28px 32px;margin-bottom:36px}
.filter-bar label{font-size:11px;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:#8a7a65;display:block;margin-bottom:8px}
.filter-bar input,.filter-bar select{width:100%;background:#f8f5ef;border:1px solid rgba(0,0,0,.1);padding:10px 14px;font-size:13px;color:#2a2a2a;font-family:'Inter',sans-serif;outline:none;transition:border-color .3s}
.filter-bar input:focus,.filter-bar select:focus{border-color:#6b5c47}
/* STATUS BADGES */
.badge{display:inline-block;padding:4px 12px;font-size:11px;font-weight:600;letter-spacing:.1em;text-transform:uppercase}
.badge-pending{background:#fef3c7;color:#92400e}
.badge-confirmed{background:#d1fae5;color:#065f46}
.badge-cancelled{background:#fee2e2;color:#991b1b}
.badge-paid{background:#d1fae5;color:#065f46}
.badge-new{background:#dbeafe;color:#1e40af}
/* FOOTER */
.foot{background:#1a1a1a;padding:56px 48px 32px}
.fg{display:grid;grid-template-columns:1.4fr 1fr 1fr;gap:44px;margin-bottom:48px}
.fbrand{font-family:'Playfair Display',serif;font-size:20px;font-weight:500;color:#fff;margin-bottom:12px}
.fabout{font-size:13px;font-weight:300;line-height:1.8;color:rgba(255,255,255,.4);margin-bottom:16px}
.fcon a{display:block;font-size:13px;color:rgba(255,255,255,.45);text-decoration:none;margin-bottom:6px;transition:color .3s}
.fcon a:hover{color:#fff}
.fct{font-size:11px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:16px}
.fcl a{display:block;font-size:13px;font-weight:300;color:rgba(255,255,255,.45);text-decoration:none;margin-bottom:8px;transition:color .3s}
.fcl a:hover{color:#fff}
.fbot{border-top:1px solid rgba(255,255,255,.07);padding-top:24px;display:flex;justify-content:space-between;font-size:12px;color:rgba(255,255,255,.3);font-family:'Inter',sans-serif}
/* MOBILE */
.mob-menu{display:none;position:fixed;inset:0;background:#f4f0e6;z-index:200;flex-direction:column;padding:72px 36px 36px;gap:2px}
.mob-menu.open{display:flex}
.mob-menu a,.mob-menu button{font-size:14px;letter-spacing:.08em;text-transform:uppercase;color:#2a2a2a;text-decoration:none;padding:13px 0;border-bottom:1px solid rgba(0,0,0,.06);background:none;text-align:left;cursor:pointer;font-family:'Inter',sans-serif;width:100%}
.mob-close{position:absolute;top:22px;right:22px;background:none;border:none;cursor:pointer;font-size:22px;color:#2a2a2a}
@media(max-width:900px){
  .nb{padding:14px 20px}
  .nb-links{display:none}
  .mob-toggle{display:block}
  .ph{padding:88px 24px 48px;margin-top:60px}
  .main{padding:40px 20px}
  .foot{padding:44px 20px 28px}
  .fg{grid-template-columns:1fr;gap:28px}
  .fbot{flex-direction:column;gap:8px}
  .filter-bar{padding:20px}
}
/* FLASH MESSAGES */
.flash-success{background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:14px 20px;margin-bottom:24px;font-size:14px}
.flash-error{background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:14px 20px;margin-bottom:24px;font-size:14px}
/* EMPTY STATE */
.empty{text-align:center;padding:72px 24px;background:#fff;border:1px solid rgba(0,0,0,.07)}
.empty-icon{font-size:48px;margin-bottom:16px;opacity:.4}
.empty-title{font-family:'Playfair Display',serif;font-size:24px;font-weight:400;color:#1a1a1a;margin-bottom:8px}
.empty-sub{font-size:14px;font-weight:300;color:#888;margin-bottom:28px}
/* PAGINATION override */
.pagination{display:flex;gap:4px;justify-content:center;margin-top:48px}
.pagination a,.pagination span{padding:8px 14px;border:1px solid rgba(0,0,0,.1);font-size:13px;color:#555;text-decoration:none;transition:all .2s;background:#fff}
.pagination a:hover{background:#f4f0e6;border-color:rgba(0,0,0,.2);color:#1a1a1a}
.pagination .active,.pagination [aria-current]{background:#1a1a1a;color:#fff;border-color:#1a1a1a}
</style>
@stack('styles')
</head>
<body>
{{-- MOBILE MENU --}}
<div class="mob-menu" id="mobMenu">
    <button class="mob-close" onclick="document.getElementById('mobMenu').classList.remove('open')">✕</button>
    <a href="{{ route('tamu.dashboard') }}">Home</a>
    <a href="{{ url('/') }}#tentang">About</a>
    <a href="{{ route('tamu.facilities') }}">Facilities</a>
    <a href="{{ route('kamar.index') }}">Rooms</a>
    <a href="{{ url('/') }}#kontak">Contact</a>
    @auth
        <a href="{{ route('tamu.booking.index') }}">Book Now</a>
        <a href="{{ route('tamu.orders') }}">My Orders</a>
        <a href="{{ route('tamu.notifications.index') }}">Notifications</a>
        <a href="{{ route('profile.edit') }}">Profile</a>
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" style="color:#dc2626">Logout</button>
        </form>
    @else
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Register</a>
    @endauth
</div>

{{-- NAVBAR --}}
<nav class="nb">
    <a href="{{ url('/') }}" class="nb-logo">
        <img src="{{ asset('images/tarsanhomestay.png') }}" alt="Tarsan Homestay">
        <span>Tarsan Homestay</span>
    </a>
    <div class="nb-links">
        <a href="{{ url('/') }}" @class(['active' => request()->routeIs('tamu.dashboard')])>Home</a>
        <a href="{{ route('tamu.facilities') }}" @class(['active' => request()->routeIs('tamu.facilities')])>Facilities</a>
        <a href="{{ route('kamar.index') }}" @class(['active' => request()->routeIs('kamar.*')])>Rooms</a>
        @auth
            <a href="{{ route('tamu.booking.index') }}" @class(['active' => request()->routeIs('tamu.booking.*')])>Book</a>
            <a href="{{ route('tamu.orders') }}" @class(['active' => request()->routeIs('tamu.orders*')])>My Orders</a>
        @endauth
        <a href="{{ url('/') }}#kontak">Contact</a>
    </div>
    <div class="nb-right">
        @guest
            <a href="{{ route('login') }}" class="btn-dark">Login</a>
            <a href="{{ route('register') }}" class="btn-fill">Register</a>
        @else
            <a href="{{ route('tamu.notifications.index') }}" style="position:relative;color:#555;text-decoration:none;font-size:18px;padding:4px">
                🔔<span id="notif-badge" style="position:absolute;top:-4px;right:-6px;background:#dc2626;color:#fff;font-size:9px;font-weight:700;border-radius:50%;width:14px;height:14px;display:none;align-items:center;justify-content:center"></span>
            </a>
            <a href="{{ route('tamu.booking.index') }}" class="btn-fill">Book Now</a>
            <div class="aw">
                <button class="ab">
                    <img src="{{ Auth::user()->photo ? asset('storage/'.Auth::user()->photo) : asset('images/default-avatar.png') }}" alt="">
                    <span>{{ auth()->user()->name }}</span>
                </button>
                <div class="dd">
                    <a href="{{ route('profile.edit') }}">Edit Profile</a>
                    <a href="{{ route('tamu.orders') }}">My Orders</a>
                    <hr>
                    <form method="POST" action="{{ route('logout') }}">@csrf
                        <button type="submit" class="out">Logout</button>
                    </form>
                </div>
            </div>
        @endguest
        <button class="mob-toggle" onclick="document.getElementById('mobMenu').classList.add('open')">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>
</nav>

{{-- PAGE HEADER --}}
<div class="ph">
    <span class="ph-tag">@yield('page-tag', 'Tarsan Homestay')</span>
    <h1 class="ph-title">{!! $__env->yieldContent('page-title', 'Page') !!}</h1>
    @hasSection('page-sub')
        <p class="ph-sub">@yield('page-sub')</p>
    @endif
</div>

{{-- CONTENT --}}
<main class="main">
    @yield('inner-content')
</main>

{{-- FOOTER --}}
<footer class="foot">
    <div class="fg">
        <div>
            <div class="fbrand">Tarsan Homestay</div>
            <p class="fabout">Comfortable accommodation in Labuan Bajo — the gateway to Komodo National Park, East Nusa Tenggara.</p>
            <div class="fcon">
                <a href="https://maps.app.goo.gl/7pmmdcZEvY4FtAEk6" target="_blank">📍 Labuan Bajo, Kec. Komodo, NTT</a>
                <a href="mailto:tarsanhomestay@gmail.com">✉ tarsanhomestay@gmail.com</a>
                <a href="tel:082146562293">☎ 0821-4656-2293</a>
            </div>
        </div>
        <div>
            <div class="fct">Explore</div>
            <div class="fcl">
                <a href="{{ route('tamu.dashboard') }}">Home</a>
                <a href="{{ route('kamar.index') }}">Rooms</a>
                <a href="{{ route('tamu.facilities') }}">Facilities</a>
                <a href="{{ route('tamu.dining') }}">Dining</a>
            </div>
        </div>
        <div>
            <div class="fct">Account</div>
            <div class="fcl">
                @auth
                    <a href="{{ route('tamu.booking.index') }}">Book Now</a>
                    <a href="{{ route('tamu.orders') }}">My Orders</a>
                    <a href="{{ route('profile.edit') }}">Profile</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </div>
    <div class="fbot">
        <span>© {{ date('Y') }} Tarsan Homestay. All rights reserved.</span>
        <span>Labuan Bajo, Indonesia</span>
    </div>
</footer>

@auth
<script>
document.addEventListener('DOMContentLoaded',function(){
    loadCount(); setInterval(loadCount,30000);
});
function loadCount(){
    fetch('{{ route("tamu.notifications.unread-count") }}')
        .then(r=>r.json()).then(d=>{
            const b=document.getElementById('notif-badge');
            if(b){if(d.count>0){b.textContent=d.count>99?'99+':d.count;b.style.display='flex';}else b.style.display='none';}
        });
}
</script>
@endauth
@stack('scripts')
</body>
</html>

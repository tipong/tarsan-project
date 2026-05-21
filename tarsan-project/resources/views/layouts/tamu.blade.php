<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400;1,500&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tarsan Homestay</title>
    <link rel="icon" type="image/png" href="{{ asset('tarsanhomestay.png') }}">
    @include('layouts.assets')
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Inter',sans-serif;background:#f8f5ef;color:#2a2a2a;overflow-x:hidden}
.nb{position:fixed;top:0;left:0;right:0;z-index:100;padding:20px 48px;display:flex;align-items:center;justify-content:space-between;transition:all .4s}
.nb.sc{background:rgba(248,245,239,.96);backdrop-filter:blur(12px);padding:14px 48px;box-shadow:0 1px 0 rgba(0,0,0,.08)}
.nb-logo{display:flex;align-items:center;gap:10px;text-decoration:none}
.nb-logo img{height:42px;object-fit:contain}
.nb-logo span{font-family:'Playfair Display',serif;font-size:18px;font-weight:600;color:#fff;transition:color .4s}
.nb.sc .nb-logo span{color:#1a1a1a}
.nb-links{display:flex;align-items:center;gap:28px}
.nb-links a{font-size:12px;font-weight:400;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.85);text-decoration:none;transition:color .3s}
.nb-links a:hover{color:#fff}
.nb.sc .nb-links a{color:#555}
.nb.sc .nb-links a:hover{color:#1a1a1a}
.nb-right{display:flex;align-items:center;gap:12px}
.btn-outline{padding:8px 20px;border:1px solid rgba(255,255,255,.5);color:#fff;font-size:11px;font-weight:500;letter-spacing:.12em;text-transform:uppercase;text-decoration:none;transition:all .3s;background:transparent;cursor:pointer;font-family:'Inter',sans-serif}
.btn-outline:hover{background:rgba(255,255,255,.15)}
.nb.sc .btn-outline{border-color:#2a2a2a;color:#2a2a2a}
.nb.sc .btn-outline:hover{background:#2a2a2a;color:#fff}
.avatar-wrap{position:relative}
.avatar-btn{display:flex;align-items:center;gap:10px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.25);padding:6px 14px 6px 6px;cursor:pointer;transition:all .3s;font-family:'Inter',sans-serif}
.nb.sc .avatar-btn{background:rgba(0,0,0,.04);border-color:rgba(0,0,0,.12)}
.avatar-btn img{width:32px;height:32px;border-radius:50%;object-fit:cover}
.avatar-btn span{font-size:13px;color:#fff;font-weight:400}
.nb.sc .avatar-btn span{color:#1a1a1a}
.dropdown{position:absolute;right:0;top:calc(100% + 8px);width:200px;background:#fff;border:1px solid rgba(0,0,0,.08);box-shadow:0 8px 32px rgba(0,0,0,.12);opacity:0;visibility:hidden;transition:all .25s}
.avatar-wrap:hover .dropdown{opacity:1;visibility:visible}
.dropdown a,.dropdown button{display:block;width:100%;text-align:left;padding:12px 16px;font-size:13px;color:#444;text-decoration:none;background:none;border:none;cursor:pointer;font-family:'Inter',sans-serif;transition:background .2s}
.dropdown a:hover,.dropdown button:hover{background:#f4f0e6}
.dropdown hr{border:none;border-top:1px solid #f0ece5;margin:4px 0}
.dropdown .logout{color:#dc2626}
.mob-toggle{display:none;background:none;border:none;cursor:pointer;padding:8px;color:#fff}
.nb.sc .mob-toggle{color:#1a1a1a}
.mob-menu{display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:#f4f0e6;z-index:200;flex-direction:column;padding:80px 40px 40px;gap:4px}
.mob-menu.open{display:flex}
.mob-menu a,.mob-menu button{font-size:15px;font-weight:400;letter-spacing:.08em;text-transform:uppercase;color:#2a2a2a;text-decoration:none;padding:14px 0;border-bottom:1px solid rgba(0,0,0,.06);background:none;text-align:left;cursor:pointer;font-family:'Inter',sans-serif;width:100%}
.mob-close{position:absolute;top:24px;right:24px;background:none;border:none;cursor:pointer;font-size:24px;color:#2a2a2a;line-height:1}
/* HERO */
.hero{position:relative;height:100vh;min-height:620px;overflow:hidden;display:flex;align-items:flex-end}
.hbg{position:absolute;inset:0;background:url('{{ asset('images/hero.png') }}') center/cover;transform:scale(1.05);transition:transform 8s}
.hbg.ok{transform:scale(1)}
.hov{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.78) 0%,rgba(0,0,0,.3) 55%,rgba(0,0,0,.05) 100%)}
.hcont{position:relative;z-index:2;width:100%;padding:0 72px 72px;display:flex;justify-content:space-between;align-items:flex-end;gap:24px}
.htitle{font-family:'Playfair Display',serif;font-size:clamp(48px,7vw,88px);font-weight:400;font-style:italic;color:#fff;line-height:1.05}
.hright{text-align:right;color:rgba(255,255,255,.75);display:flex;flex-direction:column;align-items:flex-end;gap:20px}
.hsub{font-size:13px;letter-spacing:.15em;text-transform:uppercase;font-weight:300;max-width:240px;line-height:1.7}
.sbox{background:rgba(255,255,255,.12);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,.2);padding:5px;display:flex;gap:5px}
.sbox input{background:#fff;border:none;outline:none;padding:10px 12px;font-size:12px;color:#2a2a2a;font-family:'Inter',sans-serif;width:148px}
.sbox button{background:#fff;color:#1a1a1a;border:none;padding:10px 18px;font-size:11px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;cursor:pointer;font-family:'Inter',sans-serif;transition:background .3s}
.sbox button:hover{background:#f4f0e6}
.scroll-arrow{position:absolute;bottom:28px;left:50%;transform:translateX(-50%);color:rgba(255,255,255,.5);z-index:2;animation:bob 2.2s infinite}
@keyframes bob{0%,100%{transform:translateX(-50%) translateY(0)}50%{transform:translateX(-50%) translateY(7px)}}
/* ABOUT */
.about{background:#f4f0e6;padding:96px 48px;text-align:center}
.stag{display:inline-block;font-size:11px;font-weight:600;letter-spacing:.25em;text-transform:uppercase;color:#8a7a65;margin-bottom:18px}
.stitle{font-family:'Playfair Display',serif;font-size:clamp(34px,5vw,60px);font-weight:400;color:#1a1a1a;line-height:1.15;max-width:660px;margin:0 auto 26px}
.stitle em{font-style:italic;color:#6b5c47}
.sbody{font-size:16px;font-weight:300;line-height:1.9;color:#5a5a5a;max-width:620px;margin:0 auto 14px}
/* ADVANTAGES */
.adv{background:#fff;padding:96px 48px}
.adv-head{text-align:center;margin-bottom:60px}
.adv-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1px;background:#e8e0d5}
.ac{background:#f4f0e6;padding:52px 38px;transition:background .3s}
.ac:hover{background:#ece8de}
.acn{font-family:'Playfair Display',serif;font-size:48px;font-weight:300;color:rgba(0,0,0,.07);line-height:1}
.acl{font-size:11px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;color:#8a7a65;margin:16px 0 12px}
.acname{font-family:'Playfair Display',serif;font-size:24px;font-weight:400;color:#1a1a1a;line-height:1.2;margin-bottom:14px}
.acdesc{font-size:14px;font-weight:300;line-height:1.85;color:#5a5a5a}
/* FACILITIES */
.fac{background:#f4f0e6;padding:96px 48px}
.fac-head{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:52px}
.fac-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:2px}
.fc{position:relative;overflow:hidden;height:480px}
.fc img{width:100%;height:100%;object-fit:cover;transition:transform .8s}
.fc:hover img{transform:scale(1.06)}
.fov{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.78) 0%,rgba(0,0,0,0) 55%);display:flex;flex-direction:column;justify-content:flex-end;padding:34px 30px}
.ftag{font-size:10px;font-weight:600;letter-spacing:.25em;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:8px}
.fname{font-family:'Playfair Display',serif;font-size:26px;font-weight:400;font-style:italic;color:#fff;line-height:1.2;margin-bottom:10px}
.fdesc{font-size:13px;font-weight:300;color:rgba(255,255,255,.75);line-height:1.65;margin-bottom:22px;opacity:0;transform:translateY(8px);transition:all .4s}
.fc:hover .fdesc{opacity:1;transform:translateY(0)}
.flink{display:inline-block;padding:9px 22px;border:1px solid rgba(255,255,255,.5);color:#fff;font-size:11px;font-weight:500;letter-spacing:.14em;text-transform:uppercase;text-decoration:none;transition:all .3s}
.flink:hover{background:rgba(255,255,255,.14);border-color:#fff}
/* CTA */
.cta{position:relative;height:500px;overflow:hidden;display:flex;align-items:center;justify-content:center}
.cbg{position:absolute;inset:0;background:url('{{ asset('images/room.png') }}') center 40%/cover;filter:brightness(.4)}
.ccon{position:relative;z-index:2;text-align:center;padding:0 32px}
.ctag{font-size:11px;font-weight:600;letter-spacing:.3em;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:18px}
.ctitle{font-family:'Playfair Display',serif;font-size:clamp(36px,6vw,76px);font-weight:400;font-style:italic;color:#fff;line-height:1.1;margin-bottom:34px}
.cbtn{display:inline-block;padding:13px 38px;border:1px solid rgba(255,255,255,.6);color:#fff;font-size:11px;font-weight:500;letter-spacing:.18em;text-transform:uppercase;text-decoration:none;transition:all .3s;margin:4px}
.cbtn:hover{background:rgba(255,255,255,.12);border-color:#fff}
/* FOOTER */
.foot{background:#1a1a1a;padding:68px 48px 36px}
.fg{display:grid;grid-template-columns:1.4fr 1fr 1fr;gap:44px;margin-bottom:52px}
.fbrand{font-family:'Playfair Display',serif;font-size:21px;font-weight:500;color:#fff;margin-bottom:14px}
.fabout{font-size:13px;font-weight:300;line-height:1.8;color:rgba(255,255,255,.4);margin-bottom:18px}
.fcon a{display:block;font-size:13px;color:rgba(255,255,255,.45);text-decoration:none;margin-bottom:7px;transition:color .3s}
.fcon a:hover{color:#fff}
.fct{font-size:11px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:18px}
.fcl a{display:block;font-size:13px;font-weight:300;color:rgba(255,255,255,.45);text-decoration:none;margin-bottom:9px;transition:color .3s}
.fcl a:hover{color:#fff}
.fbot{border-top:1px solid rgba(255,255,255,.07);padding-top:26px;display:flex;justify-content:space-between;font-size:12px;color:rgba(255,255,255,.35)}
/* FADE */
.fu{opacity:0;transform:translateY(26px);transition:opacity .7s,transform .7s}
.fu.v{opacity:1;transform:translateY(0)}
/* RESPONSIVE */
@media(max-width:900px){
  .nb,.nb.sc{padding:16px 24px}
  .nb-links{display:none}
  .mob-toggle{display:block}
  .hcont{padding:0 28px 44px;flex-direction:column;align-items:flex-start;gap:20px}
  .hright{align-items:flex-start;text-align:left}
  .sbox{flex-wrap:wrap}
  .sbox input{width:100%}
  .about,.adv,.fac{padding:68px 24px}
  .adv-grid,.fac-grid{grid-template-columns:1fr}
  .fc{height:340px}
  .fac-head{flex-direction:column;align-items:flex-start;gap:10px}
  .foot{padding:52px 24px 32px}
  .fg{grid-template-columns:1fr;gap:32px}
  .fbot{flex-direction:column;gap:8px;text-align:center}
}
</style>
</head>
<body>

{{-- MOBILE MENU --}}
<div class="mob-menu" id="mobMenu">
    <button class="mob-close" onclick="document.getElementById('mobMenu').classList.remove('open')">✕</button>
    <a href="{{ route('tamu.dashboard') }}">Home</a>
    <a href="#tentang">About</a>
    <a href="#fasilitas">Facilities</a>
    <a href="{{ route('kamar.index') }}">Rooms</a>
    <a href="#kontak">Contact</a>
    @auth
        <a href="{{ route('tamu.booking.index') }}">Book Now</a>
        <a href="{{ route('tamu.orders') }}">My Orders</a>
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
<nav class="nb" id="mainNav">
    <a href="{{ route('tamu.dashboard') }}" class="nb-logo">
        <img src="{{ asset('images/tarsanhomestay.png') }}" alt="Tarsan Homestay">
        <span>Tarsan Homestay</span>
    </a>
    <div class="nb-links">
        <a href="{{ route('tamu.dashboard') }}">Home</a>
        <a href="#tentang">About</a>
        <a href="#fasilitas">Facilities</a>
        <a href="{{ route('kamar.index') }}">Rooms</a>
        <a href="#kontak">Contact</a>
    </div>
    <div class="nb-right">
        @guest
            <a href="{{ route('login') }}" class="btn-outline">Login</a>
            <a href="{{ route('register') }}" class="btn-outline">Register</a>
        @else
            <a href="{{ route('tamu.notifications.index') }}" style="position:relative;color:rgba(255,255,255,.8);text-decoration:none;font-size:20px" id="notifLink">
                🔔<span id="notif-badge" style="position:absolute;top:-6px;right:-8px;background:#dc2626;color:#fff;font-size:9px;font-weight:700;border-radius:50%;width:14px;height:14px;display:none;align-items:center;justify-content:center"></span>
            </a>
            <a href="{{ route('tamu.booking.index') }}" class="btn-outline">Book</a>
            <div class="avatar-wrap">
                <button class="avatar-btn">
                    <img src="{{ Auth::user()->photo ? asset('storage/'.Auth::user()->photo) : asset('images/default-avatar.png') }}" alt="">
                    <span>{{ auth()->user()->name }}</span>
                </button>
                <div class="dropdown">
                    <a href="{{ route('profile.edit') }}">Edit Profile</a>
                    <a href="{{ route('tamu.orders') }}">My Orders</a>
                    <hr>
                    <form method="POST" action="{{ route('logout') }}">@csrf
                        <button type="submit" class="logout">Logout</button>
                    </form>
                </div>
            </div>
        @endguest
        <button class="mob-toggle" onclick="document.getElementById('mobMenu').classList.add('open')">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>
</nav>

{{-- HERO --}}
<section class="hero" id="beranda">
    <div class="hbg" id="heroBg"></div>
    <div class="hov"></div>
    <div class="hcont">
        <h1 class="htitle">The Best Stay<br>in <em>Labuan Bajo</em></h1>
        <div class="hright">
            <p class="hsub">Gateway to Komodo<br>National Park &<br>beyond</p>
            @auth
            <form action="{{ route('tamu.booking.index') }}" method="GET" class="sbox">
                <input type="date" name="check_in">
                <input type="date" name="check_out">
                <button type="submit">Search</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn-outline">Book Your Stay</a>
            @endauth
        </div>
    </div>
    <div class="scroll-arrow">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/></svg>
    </div>
</section>

{{-- ABOUT --}}
<section class="about" id="tentang">
    <span class="stag fu">Welcome to</span>
    <h2 class="stitle fu">Tarsan <em>Homestay</em><br>Labuan Bajo</h2>
    <p class="sbody fu">Located in Labuan Bajo, West Manggarai Regency, East Nusa Tenggara — designed for travelers seeking comfortable, affordable accommodation at the gateway to Komodo National Park.</p>
    <p class="sbody fu">Every room is equipped with essential amenities in a clean, welcoming environment. Friendly, responsive service is at the heart of everything we do. Have a wonderful holiday! 😍</p>
</section>

{{-- ADVANTAGES --}}
<section class="adv" id="keunggulan">
    <div class="adv-head fu">
        <span class="stag">Why book direct</span>
        <h2 class="stitle" style="margin-bottom:0">Advantages of<br><em>Direct Booking</em></h2>
    </div>
    <div class="adv-grid">
        <div class="ac fu"><div class="acn">01</div><div class="acl">Pricing</div><div class="acname">Transparent Price</div><div class="acdesc">Room prices displayed directly — no hidden fees or third-party markups.</div></div>
        <div class="ac fu"><div class="acn">02</div><div class="acl">Convenience</div><div class="acname">Fast Booking</div><div class="acdesc">Book quickly through our streamlined web-based reservation system.</div></div>
        <div class="ac fu"><div class="acn">03</div><div class="acl">Control</div><div class="acname">Full Control</div><div class="acdesc">Monitor your order status independently at any time from your dashboard.</div></div>
    </div>
</section>

{{-- FACILITIES --}}
<section class="fac" id="fasilitas">
    <div class="fac-head fu">
        <h2 class="stitle" style="margin-bottom:0">Our<br><em>Offerings</em></h2>
        <p style="font-size:13px;font-weight:300;color:#888;max-width:260px;text-align:right;line-height:1.7">From comfortable rooms to curated experiences — everything for the perfect stay.</p>
    </div>
    <div class="fac-grid">
        <div class="fc">
            <img src="{{ asset('images/room.png') }}" alt="Rooms">
            <div class="fov"><span class="ftag">Accommodation</span><h3 class="fname">Rooms & Suites</h3><p class="fdesc">Comfortable rooms with modern design and all essential amenities.</p><a href="{{ route('tamu.rooms') }}" class="flink">Explore Rooms</a></div>
        </div>
        <div class="fc">
            <img src="{{ asset('images/facility.jpg') }}" alt="Facilities">
            <div class="fov"><span class="ftag">Leisure</span><h3 class="fname">Homestay Facilities</h3><p class="fdesc">Relaxation area, Wi-Fi, billiards, motorbike rental and more.</p><a href="{{ route('tamu.facilities') }}" class="flink">Explore Facilities</a></div>
        </div>
        <div class="fc">
            <img src="{{ asset('images/dining.jpg') }}" alt="Dining">
            <div class="fov"><span class="ftag">Culinary</span><h3 class="fname">Dining Experience</h3><p class="fdesc">Fresh local ingredients curated to enhance your comfort during stay.</p><a href="{{ route('tamu.dining') }}" class="flink">Explore Dining</a></div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta">
    <div class="cbg"></div>
    <div class="ccon fu">
        <p class="ctag">Ready for your adventure?</p>
        <h2 class="ctitle">Book your<br>stay today</h2>
        @auth
            <a href="{{ route('tamu.booking.index') }}" class="cbtn">Reserve Now</a>
        @else
            <a href="{{ route('login') }}" class="cbtn">Login to Book</a>
            <a href="{{ route('register') }}" class="cbtn">Create Account</a>
        @endauth
    </div>
</section>

{{-- FOOTER --}}
<footer class="foot" id="kontak">
    <div class="fg">
        <div>
            <div class="fbrand">Tarsan Homestay</div>
            <p class="fabout">Comfortable accommodation in Labuan Bajo — the gateway to Komodo National Park, East Nusa Tenggara.</p>
            <div class="fcon">
                <a href="https://maps.app.goo.gl/7pmmdcZEvY4FtAEk6" target="_blank">📍 Labuan Bajo, Kec. Komodo, Manggarai Barat, NTT</a>
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
                <a href="#kontak">Contact</a>
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
            if(d.count>0){b.textContent=d.count>99?'99+':d.count;b.style.display='flex';}
            else b.style.display='none';
        });
}
</script>
@endauth
<script>
const nav=document.getElementById('mainNav');
window.addEventListener('scroll',()=>nav.classList.toggle('sc',scrollY>60));
window.addEventListener('load',()=>document.getElementById('heroBg').classList.add('ok'));
const obs=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting)e.target.classList.add('v');}),{threshold:.1});
document.querySelectorAll('.fu').forEach(el=>obs.observe(el));
</script>
</body>
</html>

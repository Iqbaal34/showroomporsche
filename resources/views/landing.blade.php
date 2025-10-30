<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porsche Landing</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/scss/landing.scss'])
</head>

<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <span class="close-btn" id="closeSidebar">⬅ Close</span>
        </div>
        <ul class="sidebar-menu">
            <li><a href="#">Home</a></li>
            <li><a href="#">Catalog</a></li>
            <li><a href="#">Your Orders</a></li>
        </ul>
            @if (Session::get('logged_in'))
                <div class="logout"><a href="{{ route('logout') }}">Logout</a></div>
            @else
                <div class="login"><a href="{{ route('login') }}">Login</a></div>
            @endif
    </div>
    <div class="overlay" id="overlay"></div>
    <div class="navbar">
        <div class="menu">☰ Menu</div>
        <img src="{{ asset('img/logo.png') }}" alt="Porsche Logo">
        <div class="welcome"></div>
    </div>

    <div class="hero">
        <h1></h1>
        <img src="{{ asset('img/porschelanding.png') }}" alt="Porsche Car">
        <button class="start" onclick="location.href='#start'">Start Your Journey</button>
    </div>

    <section class="model-section">
        <div id="three-container"></div>
    </section>

    <!-- 🔽 Section tambahan di bawah 3D model -->
    <div class="start" id="start">
        <section class="find-porsche">
            <h2>Find Your Porsche</h2>
            <div class="porsche-grid">

                <!-- Card 911 -->
                <div class="porsche-card" onclick="window.location.href='{{ url('car_detail') }}' ">
                    <img src="{{ asset('img/911.png') }}" alt="Porsche 911" class="car-img">
                    <img class="model-number-img" src="{{ asset('img/911_text.png') }}" alt="911 Logo">
                    <div class="desc">The Porsche 911, an icon of timeless elegance and rear-engine perfection</div>
                </div>

                <!-- Card 718 -->
                <div class="porsche-card">
                    <img src="{{ asset('img/718.png') }}" alt="Porsche 718" class="car-img">
                    <img class="model-number-img" src="{{ asset('img/718_text.png') }}" alt="718 Logo">
                    <div class="desc">The Porsche 718, pure driving pleasure shaped in timeless elegance.</div>
                </div>

                <!-- Card Taycan -->
                <div class="porsche-card">
                    <img src="{{ asset('img/taycan.png') }}" alt="Porsche Taycan" class="car-img">
                    <img class="model-number-img" src="{{ asset('img/taycan_text.png') }}" alt="taycan Logo">
                    <div class="desc">The Porsche Taycan, where electrifying innovation meets timeless elegance.</div>
                </div>

                <!-- Card Panamera -->
                <div class="porsche-card">
                    <img src="{{ asset('img/panamera.png') }}" alt="Porsche Panamera" class="car-img">
                    <img class="model-number-img" src="{{ asset('img/panamera_text.png') }}" alt="panamera Logo">
                    <div class="desc">The Porsche Panamera, the art of luxury redefined in motion.</div>
                </div>
                <div class="porsche-card">
                    <img src="{{ asset('img/macan.png') }}" alt="Porsche Macan" class="car-img">
                    <img class="model-number-img" src="{{ asset('img/macan_text.png') }}" alt="macan Logo">
                    <div class="desc">The Porsche Panamera, the art of luxury redefined in motion.</div>
                </div>
                <div class="porsche-card">
                    <img src="{{ asset('img/cayenne.png') }}" alt="Porsche cayenne" class="car-img">
                    <img class="model-number-img" src="{{ asset('img/cayenne_text.png') }}" alt="cayenne Logo">
                    <div class="desc">The Porsche Panamera, the art of luxury redefined in motion.</div>
                </div>
            </div>
        </section>
    </div>

    @vite(['resources/scss/landing.scss', 'resources/components/3d.js'])
</body>
<script>
    const menuBtn = document.querySelector('.menu');
    const sidebar = document.getElementById('sidebar');
    const closeBtn = document.getElementById('closeSidebar');
    const overlay = document.getElementById('overlay');

    menuBtn.addEventListener('click', () => {
        sidebar.classList.add('active');
        overlay.classList.add('active');
    });

    closeBtn.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });
</script>

</html>

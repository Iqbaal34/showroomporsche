<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configure {{ $mobil->nama_mobil }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/scss/configure.scss'])
</head>

<body>
    <div class="navbar">
        <div class="left">
            <a href="/" class="back-btn">←</a>
            <span>Back to Catalog</span>
        </div>
        <img src="{{ asset('img/logo.png') }}" class="logo" alt="Porsche Logo">
    </div>

    <section class="configure-page">
        <h1>{{ $mobil->nama_mobil }}</h1>
        <span class="badge">{{ $mobil->kategori ?? 'Premium Sport' }}</span>

        <form action="{{ route('checkout.continue') }}" method="POST">
            @csrf
            <input type="hidden" name="mobil_id" value="{{ $mobil->mobil_id }}">
            <input type="hidden" id="selected_color" name="warna" value="black">
            <input type="hidden" id="selected_transmission" name="transmisi" value="Manual">

            <div class="config-container">
                <div class="car-image">
                    <img id="car-image" src="{{ asset('img/configure_911_hitam.webp') }}" alt="Porsche 911 Config">
                </div>

                <div class="config-panel">
                    <div class="section">
                        <h2>Choose Color</h2>
                        <div class="color-options">
                            <div class="color-circle black active" data-color="black"
                                data-img="{{ asset('img/configure_911_hitam.webp') }}"></div>
                            <div class="color-circle white" data-color="white"
                                data-img="{{ asset('img/configure_911_putih.webp') }}"></div>
                            <div class="color-circle red" data-color="red"
                                data-img="{{ asset('img/configure_911_merah.webp') }}"></div>
                            <div class="color-circle blue" data-color="blue"
                                data-img="{{ asset('img/configure_911_biru.webp') }}"></div>
                        </div>
                    </div>

                    <div class="section">
                        <h2>Transmission</h2>
                        <div class="type-options">
                            <button type="button" class="transmission-btn active" data-value="Manual">Manual</button>
                            <button type="button" class="transmission-btn" data-value="Automatic">Automatic</button>
                        </div>
                    </div>

                    <div class="price">
                        <label>Starting From</label>
                        <span>Rp {{ number_format($mobil->harga, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="continue-btn">Continue to Checkout</button>
                </div>
            </div>
        </form>
    </section>

    <script>
        const colorCircles = document.querySelectorAll('.color-circle');
        const carImage = document.getElementById('car-image');
        const colorInput = document.getElementById('selected_color');

        colorCircles.forEach(circle => {
            circle.addEventListener('click', () => {
                colorCircles.forEach(c => c.classList.remove('active'));
                circle.classList.add('active');
                const newSrc = circle.dataset.img;
                const newColor = circle.dataset.color;
                colorInput.value = newColor;

                carImage.classList.add('fade-out');
                setTimeout(() => {
                    carImage.src = newSrc;
                    carImage.classList.remove('fade-out');
                    carImage.classList.add('fade-in');
                    setTimeout(() => carImage.classList.remove('fade-in'), 300);
                }, 250);
            });
        });

        // transmisi
        const transButtons = document.querySelectorAll('.transmission-btn');
        const transInput = document.getElementById('selected_transmission');

        transButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                transButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                transInput.value = btn.dataset.value;
            });
        });
    </script>
</body>

</html>

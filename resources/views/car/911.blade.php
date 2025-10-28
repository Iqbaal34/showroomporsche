<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Porsche 911</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  @vite(['resources/scss/car_detail.scss'])
</head>
<body>
  <nav class="navbar">
    <div class="menu">☰ Menu</div>
    <img src="{{ asset('img/logo.png') }}" alt="Porsche Logo" class="logo">
  </nav>

  <section class="porsche-hero">
    <h1 class="model-name">911</h1>
    <img src="{{ asset('img/911.png') }}" alt="Porsche 911" class="car-img">

    <p class="desc">
      The Porsche 911, merging iconic heritage with cutting-edge hybrid performance, radiates athletic elegance
      and precision engineering, offering an unmatched driving experience for those who demand speed, luxury,
      and timeless style.
    </p>

    <button class="order-btn">ORDER</button>
  </section>
</body>
</html>

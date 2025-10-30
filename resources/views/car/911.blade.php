  <!DOCTYPE html>
  <html lang="en">

  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Porsche 911</title>
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
      @vite(['resources/scss/car_detail.scss'])
      <script src="https://kit.fontawesome.com/df4794220c.js" crossorigin="anonymous"></script>
  </head>

  <body>
      <div class="sidebar" id="sidebar">
          <div class="sidebar-header">
              <span class="close-btn" id="closeSidebar">⬅ Close</span>
          </div>
          <ul class="sidebar-menu">
              <li><a href="/">Home</a></li>
              <li><a href="#">Catalog</a></li>
              <li><a href="#">Your Orders</a></li>
          </ul>
          <div class="logout"><a href="#">Logout</a></div>
      </div>
      <div class="overlay" id="overlay"></div>
      <nav class="navbar">
          <div class="menu">☰ Menu</div>
          <img src="{{ asset('img/logo.png') }}" alt="Porsche Logo" class="logo">
      </nav>

      <section class="porsche-hero">
          <!-- Gambar ini sudah mencakup tulisan "911" -->
          <img src="{{ asset('img/911_detail.png') }}" alt="Porsche 911" class="car-hero-img">

          <p class="desc">
              The Porsche 911, merging iconic heritage with cutting-edge hybrid performance, radiates athletic elegance
              and precision engineering, offering an unmatched driving experience for those who demand speed, luxury,
              and timeless style.
          </p>

          <button class="order-btn" onclick="window.location.href='{{ route('configure', ['id' => 1]) }}'">ORDER</button>

      </section>
      <section class="porsche-detail">
          <div class="detail-container">
              <!-- Gambar mobil belakang -->
              <img src="{{ asset('img/911_back.png') }}" alt="Porsche 911 Back" class="car-back">

              <!-- Bagian kiri (logo & harga) -->
              <div class="detail-left">
                  <img src="{{ asset('img/911_text.png') }}" alt="Porsche 911 Text" class="text-img">
                  <p class="price-label">Start From</p>
                  <h2 class="price">Rp4.900.000.000</h2>
              </div>

              <!-- Bagian kanan (spesifikasi) -->
              <div class="detail-right">
                  <div class="specs">
                      <div class="spec-box green">
                          <i class="fa-solid fa-clock" style="font-size: 1.5rem; color: #43975E;"></i>
                          <h3>2.5 S</h3>
                          <p>0 - 60 MPH</p>
                      </div>
                      <div class="spec-box orange">
                          <i class="fa-solid fa-engine" style="font-size: 1.5rem; color: #F25912;"></i>
                          <h3>711 HP</h3>
                          <p>Max Engine Power</p>
                      </div>
                      <div class="spec-box blue">
                          <i class="fa-regular fa-gauge-high" style="font-size: 1.5rem; color: #1B44FE;"></i>
                          <h3>322 MPH</h3>
                          <p>Top Speed</p>
                      </div>
                      <div class="spec-box navy">
                          <i class="fa-solid fa-weight-hanging" style="font-size: 1.5rem; color: #4B4B4B;"></i>
                          <h3>1.420 KG</h3>
                          <p>Weight</p>
                      </div>
                  </div>

                  <div class="video-preview">
                      <img src="{{ asset('img/911_preview.png') }}" alt="Porsche 911 Video Preview">
                  </div>
              </div>
          </div>
      </section>
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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthApps | Layanan Kesehatan Digital Terpercaya</title>
    <link rel="stylesheet" href="index.css">
    <!-- Font dan AOS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


</head>
<body>

    <!-- Navigation -->
 <nav>
 <div class="nav-container">
    <a href="#" class="logo">
    <div class="logo-icon">+</div>
    HealthApps
 </a>
 <div class="nav-menu">
    <ul class="nav-links">
    <li><a href="#beranda" class="active">Beranda</a></li>
    <li><a href="#tentang-kami">Tentang Kami</a></li>
    <li><a href="#layanan">Layanan</a></li>
    <li><a href="#kontak">Kontak</a></li>
  </ul>
    <a href="login.php" class="btn-login">Login</a>
  </div>
  </div>
  </nav>

  <!-- Hero -->
  <section class="hero" id="beranda">
   <div class="shape shape-1"></div>
   <div class="shape shape-2"></div>
   <div class="shape shape-3"></div>
   <div class="hero-container">
   <div class="hero-content" data-aos="fade-right">
   <h1>Solusi Kesehatan Digital Terpercaya</h1>
   <p>HealthApps membantu Anda mengakses layanan kesehatan dengan mudah dan cepat. Dari manajemen data pasien hingga manajemen data resep obat, semua dapat dilakukan secara online.</p>
   <a href="#layanan">Pelajari Lebih Lanjut</a>
  </div>
   <div class="hero-image" data-aos="fade-left">
   <img src="https://cdn-icons-png.flaticon.com/512/3209/3209998.png" alt="HealthCare Illustration">
  </div>
  </div>
  </section>

  <!-- Tentang Kami -->
  <section id="tentang-kami" class="tentang-kami">
  <div class="container">
    <h2 class="judul-tengah">Tentang Kami</h2>
    <div class="content">
    <div class="image">
    <img src="kesehatan.jpg" alt="Tentang Kami" class="tentang-kami-img">
  </div>
    <div class="text">
    <p>
    HealthApps adalah platform digital yang berfokus pada pelayanan kesehatan berbasis teknologi. 
    Tim kami terdiri dari profesional kesehatan dan pengembang teknologi yang berkomitmen untuk 
    meningkatkan kualitas layanan medis di Indonesia.
    </p>
 </div>
 </div>
 </div>
</section>

<!-- Layanan -->
    <section class="layanan" id="layanan">
        <h2 data-aos="fade-up">Layanan Kami</h2>
        <div class="layanan-cards">
            <div class="card" data-aos="zoom-in" data-aos-delay="100">
                <img src="https://cdn-icons-png.flaticon.com/512/2920/2920277.png" alt="Konsultasi">
                <h3>Konsultasi Online</h3>
                <p>Konsultasikan keluhan Anda dengan dokter berpengalaman tanpa perlu keluar rumah.</p>
            </div>
            <div class="card" data-aos="zoom-in" data-aos-delay="200">
                <img src="https://cdn-icons-png.flaticon.com/512/2966/2966327.png" alt="Pasien">
                <h3>Manajemen Pasien</h3>
                <p>Data pasien tersimpan dengan aman dan dapat diakses kapan saja dengan mudah.</p>
            </div>
            <div class="card" data-aos="zoom-in" data-aos-delay="300">
                <img src="https://cdn-icons-png.flaticon.com/512/3171/3171625.png" alt="Obat">
                <h3>Resep Obat Digital</h3>
                <p>Dapatkan resep obat langsung dari dokter dan tebus secara online.</p>
            </div>
        </div>
    </section>

  <!-- Kontak -->
   <section id="kontak" class="contact-section-new">
  <div class="section-title">
    <h2>Hubungi Kami</h2>
    <p>Kami siap membantu Anda</p>
    <p>Jangan ragu untuk menghubungi kami!</p>
  </div>

  <div class="contact-wrapper">
    <div class="contact-image-left">
      <img src="kontak.jpg" alt="Hubungi Kami">
    </div>

    <div class="contact-info-card">
      <h3>Informasi Kontak</h3>
      
      <div class="info-item" onclick="window.location.href='tel:02716640826'">
        <div class="info-icon">
          <i class="fa-solid fa-phone"></i>
        </div>
        <div class="info-content">
          <h4>Telepon</h4>
          <p>(0271) 640826</p>
        </div>
      </div>

      <div class="info-item" onclick="window.location.href='mailto:admin@healthapps.com'">
        <div class="info-icon">
          <i class="fa-solid fa-envelope"></i>
        </div>
        <div class="info-content">
          <h4>Email</h4>
          <p>admin@healthapps.com</p>
        </div>
      </div>

      <div class="info-item" onclick="window.open('#', '_blank')">
        <div class="info-icon">
          <i class="fa-brands fa-instagram"></i>
        </div>
        <div class="info-content">
          <h4>Instagram</h4>
          <p>@HealthApps</p>
        </div>
      </div>
</section>

    <!-- Footer -->
 
   <footer>
  <div class="footer-container">
    <div class="footer-section">
      <h3>HealthApps</h3>
      <p>
        Aplikasi layanan kesehatan yang dapat membantu kita untuk
        pengelolaan data pasien, obat, resep, dan pembayaran.
      </p>
    </div>

    <div class="footer-section">
      <h3>Navigasi</h3>
      <ul>
        <li><a href="#">Beranda</a></li>
        <li><a href="#">Tentang kami</a></li>
        <li><a href="#">Layanan</a></li>
        <li><a href="#">Kontak kami</a></li>
      </ul>
    </div>

    <div class="footer-section">
      <h3>Sosial media</h3>
      <ul>
        <li><i class="fa-solid fa-phone"></i> <a href="#">WhatsApp</a></li>
        <li><i class="fa-solid fa-envelope"></i> <a href="#">Email</a></li>
        <li><i class="fa-brands fa-instagram"></i> <a href="#">Instagram</a></li>
      </ul>
    </div>
  </div>

  <div class="footer-bottom">
    <p>© 2025 <span>HealthApps.</span> MeliaHanna.</p>
  </div>
</footer>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>

    <!-- Script untuk navbar active -->
    <script>
        const navLinks = document.querySelectorAll('.nav-links a');

        // Saat diklik
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Saat di-scroll
        const sections = document.querySelectorAll("section");
        window.addEventListener("scroll", () => {
            let current = "";
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 150;
                if (scrollY >= sectionTop) {
                    current = section.getAttribute("id");
                }
            });

            navLinks.forEach(link => {
                link.classList.remove("active");
                if (link.getAttribute("href") === "#" + current) {
                    link.classList.add("active");
                }
            });
        });
    </script>
</body>
</html>
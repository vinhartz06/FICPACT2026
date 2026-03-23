document.addEventListener('DOMContentLoaded', function() {
  // Tombol di `landing.blade.php`:
  // - Mainkan Sekarang / Lanjut Bermain => `.hero-cta a.btn-play` (tamu / lanjut ke map)
  // - Daftar / Keluar => `.hero-cta a.btn-secondary`
  //    → belum login: navigasi ke halaman Blade `register.blade.php` (href dari server)
  //    → sudah login: Keluar (API + reset UI)
  var playNowLink = document.querySelector('.hero-cta a.btn-play');
  var registerLink = document.querySelector('.hero-cta a.btn-secondary');

  if (!playNowLink || !registerLink || typeof Auth === 'undefined') return;

  function applyLoggedInUi() {
    if (Auth.isLoggedIn()) {
      playNowLink.textContent = '▶ Lanjut Bermain';
      registerLink.textContent = 'Keluar';
    } else {
      playNowLink.textContent = '▶ Mainkan Sekarang';
      registerLink.textContent = 'Daftar';
    }
  }

  applyLoggedInUi();

  playNowLink.addEventListener('click', function(e) {
    e.preventDefault();

    if (Auth.isLoggedIn()) {
      window.location.href = 'game';
      return;
    }

    try {
      Auth.removeToken();
      Auth.removeUser();
    } catch (_e) {}
    Auth.setGuestMode(true);
    window.location.href = 'game';
  });

  registerLink.addEventListener('click', function(e) {
    if (Auth.isLoggedIn()) {
      e.preventDefault();
      Auth.logout()
        .then(function() {
          Auth.setGuestMode(false);
          applyLoggedInUi();
        })
        .catch(function() {
          Auth.setGuestMode(false);
          applyLoggedInUi();
        });
      return;
    }

    // Belum login: jangan preventDefault — biarkan browser buka `route('register')` (register.blade.php).
    Auth.setGuestMode(false);
  });
});

    // Fungsi untuk membuka modal
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    // Fungsi untuk menutup modal
    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
        document.body.style.overflow = '';
    }
    
    // Tutup modal jika klik di luar konten
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.classList.remove('active');
            document.body.style.overflow = '';
        }
    }
    
    // Tambahkan event listener untuk link footer
    document.addEventListener('DOMContentLoaded', function() {
        const aboutLink = document.querySelector('.footer-link:first-child');
        const contactLink = document.querySelector('.footer-link:last-child');
        
        if (aboutLink) {
            aboutLink.addEventListener('click', function(e) {
                e.preventDefault();
                openModal('aboutModal');
            });
        }
        
        if (contactLink) {
            contactLink.addEventListener('click', function(e) {
                e.preventDefault();
                openModal('contactModal');
            });
        }
    });

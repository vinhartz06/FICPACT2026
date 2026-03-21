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

function homeUrl() {
  if (typeof window.TRILOGI_HOME_URL === 'string' && window.TRILOGI_HOME_URL.length) {
    return window.TRILOGI_HOME_URL;
  }
  return 'index.php';
}

/**
 * Koordinat data-pin-x/y = persen (0–100) dari kotak gambar ter-render
 * (elemen <img> object-fit:contain), bukan dari kotak luar — supaya tidak "melayang" di laut.
 */
function layoutIslandMapPins() {
  var container = document.getElementById('island-map');
  if (!container) return;
  var pins = container.querySelectorAll('.stage-pin[data-pin-x]');
  if (!pins.length) return;

  var img = container.querySelector('.map-layer img');
  var mapLayer = container.querySelector('.map-layer');
  var cRect = container.getBoundingClientRect();
  if (!cRect.width || !cRect.height) return;

  var box = null;
  if (img && img.getBoundingClientRect().width > 0) {
    box = img;
  } else if (mapLayer) {
    box = mapLayer;
  }
  if (!box) return;

  var bRect = box.getBoundingClientRect();
  var ox = bRect.left - cRect.left;
  var oy = bRect.top - cRect.top;
  var bw = bRect.width;
  var bh = bRect.height;

  pins.forEach(function(pin) {
    var px = parseFloat(pin.getAttribute('data-pin-x'), 10);
    var py = parseFloat(pin.getAttribute('data-pin-y'), 10);
    if (isNaN(px) || isNaN(py)) return;
    pin.style.left = ((ox + (px / 100) * bw) / cRect.width * 100) + '%';
    pin.style.top = ((oy + (py / 100) * bh) / cRect.height * 100) + '%';
    pin.style.visibility = 'visible';
  });
}

function bindIslandMapLayout() {
  var container = document.getElementById('island-map');
  if (!container) return;

  var run = function() {
    requestAnimationFrame(layoutIslandMapPins);
  };

  run();
  var img = container.querySelector('.map-layer img');
  if (img) {
    if (!img.complete) {
      img.addEventListener('load', run, { once: true });
    }
    img.addEventListener('error', run);
  }
  window.addEventListener('resize', run);
  if (typeof ResizeObserver !== 'undefined') {
    var ro = new ResizeObserver(run);
    ro.observe(container);
  }
}

document.addEventListener('DOMContentLoaded', async function() {
  if (typeof Auth === 'undefined') return;

  if (!Auth.isLoggedIn() && !Auth.isGuest()) {
    window.location.href = homeUrl();
    return;
  }

  bindIslandMapLayout();

  var logoutBtn = document.getElementById('nav-logout');
  if (logoutBtn) {
    logoutBtn.addEventListener('click', function() {
      if (Auth.isLoggedIn()) {
        Auth.logout()
          .catch(function() {})
          .finally(function() {
            Auth.setGuestMode(false);
            window.location.href = homeUrl();
          });
        return;
      }
      try {
        Auth.removeToken();
        Auth.removeUser();
      } catch (_e) {}
      Auth.setGuestMode(false);
      window.location.href = homeUrl();
    });
  }

  var highestUnlocked = 999;
  if (Auth.isLoggedIn()) {
    var p = await Auth.getProgress();
    if (p && p.user) {
      highestUnlocked = parseInt(p.user.highest_stage_unlocked, 10) || 1;
    }
  }

  document.querySelectorAll('a.stage-row').forEach(function(a) {
    var num = parseInt(a.getAttribute('data-stage-number'), 10);
    if (Auth.isLoggedIn() && num > highestUnlocked) {
      a.classList.add('opacity-45', 'cursor-not-allowed', 'is-locked');
      a.addEventListener('click', function(e) {
        e.preventDefault();
        alert('Stage ini masih terkunci. Selesaikan stage sebelumnya dulu.');
      });
    }
  });
});

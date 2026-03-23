/**
 * Dashboard `game.blade.php`: pulau → halaman pilih stage, profil, leaderboard.
 */
function dashboardBasePath() {
  var path = (window.location.pathname || '').replace(/\/?$/, '');
  return path;
}

function islandStagesUrl(slug) {
  return dashboardBasePath() + '/island/' + slug;
}

function homeUrl() {
  if (typeof window.TRILOGI_HOME_URL === 'string' && window.TRILOGI_HOME_URL.length) {
    return window.TRILOGI_HOME_URL;
  }
  return 'index.php';
}

function ensureModal(id, title, innerHtml) {
  var el = document.getElementById(id);
  if (el) return el;
  el = document.createElement('div');
  el.id = id;
  el.className = 'fixed inset-0 z-[100] hidden';
  el.innerHTML =
    '<div class="absolute inset-0 bg-black/60" data-close-modal="' +
    id +
    '"></div>' +
    '<div class="relative flex min-h-full items-center justify-center p-4">' +
    '<div class="w-full max-w-md rounded-2xl border border-white/15 bg-[#1a1f2e]/95 backdrop-blur-md p-6 text-[#FCE6C4] shadow-2xl">' +
    '<div class="flex justify-between items-start mb-4">' +
    '<h3 class="text-lg font-bold text-[#F7D98C]">' +
    title +
    '</h3>' +
    '<button type="button" class="text-white/60 hover:text-white text-2xl leading-none" data-close-modal="' +
    id +
    '">&times;</button>' +
    '</div>' +
    '<div class="modal-body">' +
    innerHtml +
    '</div>' +
    '</div>' +
    '</div>';
  document.body.appendChild(el);
  return el;
}

function showModal(id) {
  var m = document.getElementById(id);
  if (m) m.classList.remove('hidden');
}

function hideModal(id) {
  var m = document.getElementById(id);
  if (m) m.classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
  if (typeof Auth === 'undefined') return;

  if (!Auth.isLoggedIn() && !Auth.isGuest()) {
    window.location.href = homeUrl();
    return;
  }

  document.querySelectorAll('a.island-label').forEach(function(anchor) {
    anchor.addEventListener('click', function(e) {
      e.preventDefault();
      var slug = anchor.getAttribute('data-island');
      if (!slug) {
        var t = (anchor.textContent || '').toLowerCase();
        if (t.indexOf('sumatra') !== -1) slug = 'sumatra';
        else if (t.indexOf('jawa') !== -1) slug = 'jawa';
        else if (t.indexOf('bali') !== -1) slug = 'bali';
        else if (t.indexOf('kalimantan') !== -1) slug = 'kalimantan';
        else if (t.indexOf('sulawesi') !== -1) slug = 'sulawesi';
        else if (t.indexOf('papua') !== -1) slug = 'papua';
      }
      if (!slug) {
        alert('Pulau tidak dikenali.');
        return;
      }
      window.location.href = islandStagesUrl(slug);
    });
  });

  var profilBtn = document.getElementById('nav-profil');
  if (profilBtn) {
    profilBtn.addEventListener('click', function(e) {
      e.preventDefault();
      ensureModal(
        'modal-profil',
        'Profil',
        '<p class="text-sm text-amber-100/70">Memuat data…</p>'
      );
      var modal = document.getElementById('modal-profil');
      var inner = modal ? modal.querySelector('.modal-body') : null;
      if (inner) inner.innerHTML = '<p class="text-sm text-amber-100/70">Memuat data…</p>';
      showModal('modal-profil');
      (async function() {
        var modal2 = document.getElementById('modal-profil');
        var inner2 = modal2 ? modal2.querySelector('.modal-body') : null;
        if (!inner2) return;
        if (Auth.isGuest()) {
          inner2.innerHTML =
            '<p class="text-white font-semibold mb-2">Mode tamu</p>' +
            '<p class="text-sm text-amber-100/80">Login untuk menyimpan skor dan progres.</p>';
          return;
        }
        var p = await Auth.getProgress();
        if (!p || !p.user) {
          inner2.innerHTML =
            '<p class="text-red-300 text-sm">Tidak bisa memuat profil.</p>';
          return;
        }
        var u = p.user;
        var completed = (p.completed_stages || []).length;
        inner2.innerHTML =
          '<ul class="space-y-3 text-sm">' +
          '<li><span class="text-amber-200/60">Nama</span><br><span class="font-semibold text-white">' +
          escapeHtml(u.name) +
          '</span></li>' +
          '<li><span class="text-amber-200/60">Stage tertinggi terbuka</span><br><span class="font-semibold text-white">' +
          u.highest_stage_unlocked +
          '</span></li>' +
          '<li><span class="text-amber-200/60">Total skor</span><br><span class="font-semibold text-[#F7D98C]">' +
          u.total_score +
          '</span></li>' +
          '<li><span class="text-amber-200/60">Stage selesai</span><br><span class="font-semibold text-white">' +
          completed +
          ' stage</span></li>' +
          '</ul>';
      })();
    });
  }

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

  var lbBtn = document.getElementById('nav-leaderboard');
  if (lbBtn) {
    lbBtn.addEventListener('click', function(e) {
      e.preventDefault();
      ensureModal(
        'modal-leaderboard',
        'Leaderboard',
        '<p class="text-sm text-amber-100/70">Memuat…</p>'
      );
      var mlb = document.getElementById('modal-leaderboard');
      var innerLb = mlb ? mlb.querySelector('.modal-body') : null;
      if (innerLb) innerLb.innerHTML = '<p class="text-sm text-amber-100/70">Memuat…</p>';
      showModal('modal-leaderboard');
      (async function() {
        var modal = document.getElementById('modal-leaderboard');
        var inner = modal ? modal.querySelector('.modal-body') : null;
        if (!inner) return;
        var data = await Auth.getLeaderboard();
        if (!data || !data.leaderboard || !data.leaderboard.length) {
          inner.innerHTML =
            '<p class="text-sm text-amber-200/80">Belum ada data pemain.</p>';
          return;
        }
        var rows = data.leaderboard
          .slice(0, 30)
          .map(function(r) {
            return (
              '<tr class="border-b border-white/10">' +
              '<td class="py-2 pr-2 text-amber-200/80">' +
              r.rank +
              '</td>' +
              '<td class="py-2 pr-2 font-medium min-w-0">' +
              escapeHtml(r.name) +
              '</td>' +
              '<td class="py-2 pl-2 pr-3 text-right text-[#F7D98C] font-semibold whitespace-nowrap">' +
              r.total_score +
              '</td>' +
              '</tr>'
            );
          })
          .join('');
        inner.innerHTML =
          '<div class="max-h-72 overflow-y-auto overflow-x-hidden rounded-md" style="scrollbar-gutter: stable;">' +
          '<table class="w-full text-sm table-fixed">' +
          '<colgroup><col class="w-10" /><col /><col class="w-24" /></colgroup>' +
          '<thead><tr class="text-left text-amber-200/50 border-b border-white/20">' +
          '<th class="pb-2 pr-2">#</th><th class="pb-2 pr-2">Pemain</th><th class="pb-2 pl-2 pr-3 text-right">Skor</th>' +
          '</tr></thead><tbody>' +
          rows +
          '</tbody></table></div>';
      })();
    });
  }

  document.addEventListener('click', function(e) {
    var t = e.target;
    if (!t || !t.getAttribute) return;
    var close = t.getAttribute('data-close-modal');
    if (close) hideModal(close);
  });
});

function escapeHtml(s) {
  if (!s) return '';
  var d = document.createElement('div');
  d.textContent = s;
  return d.innerHTML;
}

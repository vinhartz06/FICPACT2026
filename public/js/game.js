var IMAGE_BASE = 'images/cards';

function authJsonHeaders() {
  var h = { Accept: 'application/json' };
  if (typeof Auth !== 'undefined' && Auth.getToken && Auth.getToken()) {
    h.Authorization = 'Bearer ' + Auth.getToken();
  }
  return h;
}

/** Tiap ronde: maksimal 4 trilogi = 12 kartu */
var TRILOGIES_PER_ROUND = 4;

/** Kembalikan jumlah kolom grid sesuai lebar layar saat ini. */
function getGridCols() {
  return window.innerWidth >= 769 ? 4 : 3;
}

/** URL dashboard Blade (Pilih Pulau). */
function getDashboardUrl() {
  if (typeof window.TRILOGI_DASHBOARD_URL === 'string' && window.TRILOGI_DASHBOARD_URL.length) {
    return window.TRILOGI_DASHBOARD_URL;
  }
  var path = window.location.pathname || '';
  var mPlay = path.match(/^(.*\/)play\/?$/i);
  if (mPlay) return mPlay[1] + 'game';
  var i = path.lastIndexOf('/');
  var dir = i >= 0 ? path.substring(0, i + 1) : '/';
  return dir + 'game';
}

/** URL halaman memory game (/play). */
function getPlayUrl() {
  if (typeof window.TRILOGI_PLAY_URL === 'string' && window.TRILOGI_PLAY_URL.length) {
    return window.TRILOGI_PLAY_URL.replace(/\/?$/, '');
  }
  var path = window.location.pathname || '';
  var m = path.match(/^(.*\/)play\/?$/i);
  if (m) return m[1] + 'play';
  var i = path.lastIndexOf('/');
  var dir = i >= 0 ? path.substring(0, i + 1) : '/';
  return dir + 'play';
}

var boardEl = document.getElementById('game-board');
var startBtn = document.getElementById('start-btn');
var timerEl = document.getElementById('timer');
var scoreEl = document.getElementById('score');
var messageEl = document.getElementById('message');
var stageInfo = document.getElementById('stage-info');
var completionModal = document.getElementById('completion-modal');
var modalTitle = document.getElementById('modal-title');
var modalScore = document.getElementById('modal-score');
var btnBackMap = document.getElementById('btn-back-map');
var btnNextStage = document.getElementById('btn-next-stage');

var cards = [];
var opened = [];
var matchedIds = new Set();
var timer = null;
var timeLeft = 60;
var score = 0;
var isChecking = false;
var currentStageId = 1;
var stageData = null;
/** true = login & stage ini melewati progres (tidak boleh main sampai urutan selesai). */
var stageLockedByProgress = false;

function getStageIdFromUrl() {
  var params = new URLSearchParams(window.location.search);
  return parseInt(params.get('stage')) || 1;
}

async function loadStages() {
  var res = await fetch(API_BASE + '/stages');
  if (!res.ok) throw new Error('Gagal memuat data stage');
  return await res.json();
}

async function loadStageCards(stageId) {
  var res = await fetch(API_BASE + '/stages/' + stageId + '/cards');
  if (!res.ok) throw new Error('Gagal memuat data kartu dari backend');
  var data = await res.json();
  stageData = data.stage;
  return data.cards;
}

function shuffle(array) {
  var arr = array.slice();
  for (var i = arr.length - 1; i > 0; i--) {
    var j = Math.floor(Math.random() * (i + 1));
    var temp = arr[i];
    arr[i] = arr[j];
    arr[j] = temp;
  }
  return arr;
}

function renderBoard() {
  boardEl.innerHTML = '';
  /* Let CSS handle grid-template-columns — do NOT set inline style here */
  cards.forEach(function(card) {
    var div = document.createElement('button');
    div.className = 'card face-down';
    div.dataset.id = card.id;
    div.dataset.topicId = card.topic_id;
    if (card.type === 'image') {
      div.innerHTML = '<span class="card-image"><img src="' + IMAGE_BASE + '/' + card.content + '" alt=""></span>';
    } else {
      div.innerHTML = '<span class="card-text">' + card.content + '</span>';
    }
    div.addEventListener('click', function() { onCardClick(card.id); });
    boardEl.appendChild(div);
  });
}

function updateStatus() {
  timerEl.textContent = 'Timer: ' + timeLeft;
  scoreEl.textContent = 'Score: ' + score;
}

function resetGameState() {
  opened = [];
  matchedIds = new Set();
  score = 0;
  timeLeft = 60;
  isChecking = false;
  updateStatus();
  messageEl.textContent = '';
}

function onCardClick(id) {
  if (isChecking) return;
  if (opened.length >= 3) return;
  if (matchedIds.has(id)) return;
  if (opened.includes(id)) return;

  var el = boardEl.querySelector('[data-id="' + id + '"]');
  if (!el || el.classList.contains('face-up') || el.classList.contains('matched')) return;

  el.classList.remove('face-down');
  el.classList.add('face-up');
  opened.push(id);

  if (opened.length === 3) {
    checkMatch();
  }
}

function checkMatch() {
  isChecking = true;
  var selectedCards = opened.map(function(id) {
    return cards.find(function(c) { return c.id === id; });
  });
  var firstTopicId = selectedCards[0].topic_id;
  var allSameTopic = selectedCards.every(function(c) { return c.topic_id === firstTopicId; });

  if (allSameTopic) {
    selectedCards.forEach(function(c) {
      matchedIds.add(c.id);
      var el = boardEl.querySelector('[data-id="' + c.id + '"]');
      if (el) el.classList.add('matched');
    });
    score += 10;
    messageEl.textContent = 'Mantap! Trilogi cocok!';

    if (matchedIds.size === cards.length) {
      clearInterval(timer);
      score += timeLeft;
      updateStatus();
      showCompletionModal();
    }
    updateStatus();
    opened = [];
    isChecking = false;
  } else {
    messageEl.textContent = 'Belum cocok, coba lagi.';
    setTimeout(function() {
      opened.forEach(function(id) {
        if (!matchedIds.has(id)) {
          var el = boardEl.querySelector('[data-id="' + id + '"]');
          if (el) {
            el.classList.add('flipping-back');
            el.classList.remove('face-up');
          }
        }
      });
      setTimeout(function() {
        opened.forEach(function(id) {
          if (!matchedIds.has(id)) {
            var el = boardEl.querySelector('[data-id="' + id + '"]');
            if (el) {
              el.classList.remove('flipping-back');
              el.classList.add('face-down');
            }
          }
        });
        opened = [];
        isChecking = false;
      }, 400);
    }, 800);
  }
  updateStatus();
}

async function showCompletionModal() {
  modalTitle.textContent = 'Stage Selesai!';

  if (Auth.isLoggedIn()) {
    var result = await Auth.completeStage(currentStageId, score);
    if (result) {
      if (result.score_improved === false) {
        modalScore.innerHTML =
          'Skor run ini: <strong>' +
          score +
          '</strong><br><span style="font-size:0.9rem;opacity:0.9">' +
          (result.message || 'Total skor tidak bertambah — selesaikan lebih cepat dari rekor untuk menambah skor.') +
          '</span>';
      } else {
        modalScore.textContent =
          'Skor: ' + score + (result.message ? ' — ' + result.message : '');
      }
      if (result.next_stage) {
        btnNextStage.disabled = false;
        btnNextStage.dataset.nextStage = result.next_stage.id;
      } else {
        btnNextStage.disabled = true;
      }
    } else {
      modalScore.textContent = 'Skor: ' + score;
      btnNextStage.disabled = true;
    }
  } else {
    modalScore.textContent = 'Skor: ' + score + ' (masuk untuk simpan progres)';
    btnNextStage.disabled = true;
  }
  completionModal.classList.remove('hidden');
}

function startTimer() {
  clearInterval(timer);
  timer = setInterval(function() {
    timeLeft -= 1;
    updateStatus();
    if (timeLeft <= 0) {
      clearInterval(timer);
      messageEl.textContent = 'Waktu habis! Coba lagi ya.';
      startBtn.textContent = 'Main Lagi';
      startBtn.classList.remove('hidden');
      startBtn.disabled = false;
      boardEl.querySelectorAll('.card').forEach(function(c) { c.classList.add('disabled'); });
    }
  }, 1000);
}

async function initGame() {
  currentStageId = getStageIdFromUrl();
  stageLockedByProgress = false;
  try {
    var stages = await loadStages();
    var stage = stages.find(function(s) { return s.id === currentStageId; });
    if (stage) {
      stageInfo.textContent =
        'Stage ' +
        stage.stage_number +
        ': ' +
        stage.city_name +
        ' — ' +
        (stage.region || '') +
        ' · tekan Mulai untuk memuat papan';
    }
    if (typeof Auth !== 'undefined' && Auth.isLoggedIn && Auth.isLoggedIn()) {
      var p = await Auth.getProgress();
      if (p && p.user && stage) {
        var hi = parseInt(p.user.highest_stage_unlocked, 10) || 1;
        if (parseInt(stage.stage_number, 10) > hi) {
          stageLockedByProgress = true;
          messageEl.textContent =
            'Stage terkunci. Selesaikan stage sebelumnya dulu (urutan 1 → 2 → 3, dst.).';
          startBtn.disabled = true;
          startBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
      }
    }
  } catch(e) {
    console.error(e);
  }
}

startBtn.addEventListener('click', async function() {
  if (stageLockedByProgress) {
    messageEl.textContent =
      'Stage terkunci. Selesaikan stage sebelumnya dulu (urutan 1 → 2 → 3, dst.).';
    return;
  }
  startBtn.classList.add('hidden');
  resetGameState();
  try {
    var allCards = await loadStageCards(currentStageId);
    var topicGroups = {};
    allCards.forEach(function(c) {
      if (!topicGroups[c.topic_id]) topicGroups[c.topic_id] = [];
      topicGroups[c.topic_id].push(c);
    });
    /* Hanya trilogi valid (tepat 3 kartu). Kalau ada topik dengan 4+ kartu (duplikat DB),
       topik itu di-skip — dulu 4 topik acak + 1 topik berisi 4 kartu = 13 kartu & grid kacau. */
    var validGroups = Object.values(topicGroups).filter(function(g) {
      return g.length === 3;
    });
    if (!validGroups.length) {
      messageEl.textContent = 'Stage ini tidak punya trilogi lengkap (3 kartu per topik).';
      startBtn.classList.remove('hidden');
      return;
    }
    var shuffledTopics = shuffle(validGroups);
    var selectedTopics = shuffledTopics.slice(0, TRILOGIES_PER_ROUND);
    var flatCards = [];
    selectedTopics.forEach(function(g) {
      flatCards = flatCards.concat(g);
    });
    cards = shuffle(flatCards);
    timeLeft = 60;
    updateStatus();

    /* Resolve responsive column count and update stage info label */
    var gridCols = getGridCols();
    if (stageData) {
      var nTri = cards.length / 3;
      var rows = Math.ceil(cards.length / gridCols) || 1;
      stageInfo.textContent =
        'Stage ' +
        stageData.stage_number +
        ': ' +
        stageData.city_name +
        ' — ' +
        (stageData.region || '') +
        ' · Grid ' +
        rows +
        '×' +
        gridCols +
        ' · ' +
        nTri +
        ' trilogi';
    }

    renderBoard();
    startTimer();
    messageEl.textContent = 'Cari kombinasi Trilogi yang tepat!';
  } catch(e) {
    console.error(e);
    messageEl.textContent = 'Tidak bisa konek ke backend.';
    startBtn.classList.remove('hidden');
  }
});

btnBackMap.addEventListener('click', function() {
  window.location.href = getDashboardUrl();
});

btnNextStage.addEventListener('click', async function() {
  var nextStageId = btnNextStage.dataset.nextStage;
  if (nextStageId) {
    try {
      var stages = await loadStages();
      var nextStage = stages.find(function(s) { return s.id === parseInt(nextStageId); });
      if (nextStage) {
        window.location.href = getPlayUrl() + '?stage=' + nextStage.id;
      } else {
        alert('Stage berikutnya belum tersedia. Tunggu update selanjutnya!');
        window.location.href = getDashboardUrl();
      }
    } catch(e) {
      alert('Stage berikutnya belum tersedia. Tunggu update selanjutnya!');
      window.location.href = getDashboardUrl();
    }
  } else {
    alert('Stage berikutnya belum tersedia. Tunggu update selanjutnya!');
    window.location.href = getDashboardUrl();
  }
});

initGame().catch(function(e) {
  console.error(e);
});
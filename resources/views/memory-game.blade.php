<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Trilogi Nusantara - Game</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,500;14..32,700;14..32,800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/game.css') }}?v=maptheme1">
</head>
<body>
  <main class="app">
    <header class="header">
      <h1>Trilogi Nusantara</h1>
      <p id="stage-info">Stage 1 - Semarang - Grid 4x3</p>
      <div class="status">
        <span id="timer">Timer: 60</span>
        <span id="score">Score: 0</span>
      </div>
    </header>

    <section id="game-board" class="grid"></section>

    <section class="controls">
      <button id="start-btn" class="btn btn-primary">Mulai Game</button>
      <p id="message"></p>
    </section>

    <section id="completion-modal" class="modal hidden">
      <div class="modal-overlay"></div>
      <div class="modal-content">
        <h2 id="modal-title">Stage Selesai!</h2>
        <p id="modal-score">Skor: 0</p>
        <div class="modal-buttons">
          <button id="btn-back-map" class="btn btn-secondary">Kembali ke Pilih Pulau</button>
          <button id="btn-next-stage" class="btn btn-primary">Lanjut Stage Berikutnya</button>
        </div>
      </div>
    </section>
  </main>

  <script>
    window.TRILOGI_DASHBOARD_URL = @json(url('/game'));
    window.TRILOGI_PLAY_URL = @json(url('/play'));
  </script>
  <script src="{{ asset('js/auth.js') }}" defer></script>
  <script src="{{ asset('js/game.js') }}" defer></script>
</body>
</html>

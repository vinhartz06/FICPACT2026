// Base URL API (path absolut dari root domain). Relatif string "api" RUSAK di path dalam
// seperti /game/island/sumatra → browser minta .../game/island/api/progress → 404.
function resolveTrilogiApiBase() {
  if (typeof window.TRILOGI_API_BASE === 'string' && window.TRILOGI_API_BASE.length) {
    return window.TRILOGI_API_BASE.replace(/\/*$/, '');
  }
  var path = window.location.pathname || '';
  var i = path.indexOf('/public/');
  if (i !== -1) {
    return path.substring(0, i + '/public'.length) + '/api';
  }
  return '/api';
}
var API_BASE = resolveTrilogiApiBase();

var Auth = {
  getToken: function() {
    return localStorage.getItem('auth_token');
  },
  setToken: function(token) {
    localStorage.setItem('auth_token', token);
  },
  removeToken: function() {
    localStorage.removeItem('auth_token');
  },
  getUser: function() {
    var user = localStorage.getItem('user');
    return user ? JSON.parse(user) : null;
  },
  setUser: function(user) {
    localStorage.setItem('user', JSON.stringify(user));
  },
  removeUser: function() {
    localStorage.removeItem('user');
  },
  isLoggedIn: function() {
    return !!this.getToken();
  },
  login: async function(email, password, name) {
    // Kirim sebagai form-data biar di `main` request JSON-nya kebaca sebagai input.
    var formBody = new URLSearchParams();
    formBody.append('email', email);
    formBody.append('password', password);
    if (name) formBody.append('name', name);
    var res = await fetch(API_BASE + '/auth', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded', 'Accept': 'application/json'},
      body: formBody.toString()
    });
    var raw = await res.text();
    var data;
    try {
      data = JSON.parse(raw);
    } catch (e) {
      throw new Error('Server tidak mengembalikan JSON (cek URL API / pastikan buka lewat .../public/).');
    }
    if (!res.ok) {
      throw new Error(data.message || 'Login gagal');
    }
    this.setToken(data.token);
    this.setUser(data.user);
    return data;
  },
  logout: async function() {
    var token = this.getToken();
    if (token) {
      try {
        await fetch(API_BASE + '/logout', {
          method: 'POST',
          headers: {'Authorization': 'Bearer ' + token, 'Accept': 'application/json'}
        });
      } catch(e) {}
    }
    this.removeToken();
    this.removeUser();
  },
  getProgress: async function() {
    var token = this.getToken();
    if (!token) return null;
    var res = await fetch(API_BASE + '/progress', {
      headers: {'Authorization': 'Bearer ' + token, 'Accept': 'application/json'}
    });
    if (!res.ok) {
      if (res.status === 401) {
        this.removeToken();
        this.removeUser();
      }
      return null;
    }
    return await res.json();
  },
  getLeaderboard: async function() {
    var res = await fetch(API_BASE + '/leaderboard', {
      headers: { Accept: 'application/json' },
    });
    if (!res.ok) return null;
    return await res.json();
  },
  completeStage: async function(stageId, score) {
    var token = this.getToken();
    if (!token) return null;
    var formBody = new URLSearchParams();
    formBody.append('stage_id', stageId);
    formBody.append('score', score);
    var res = await fetch(API_BASE + '/progress/complete', {
      method: 'POST',
      headers: {'Authorization': 'Bearer ' + token, 'Content-Type': 'application/x-www-form-urlencoded', 'Accept': 'application/json'},
      body: formBody.toString()
    });
    if (!res.ok) return null;
    var data = await res.json();
    this.setUser(data.user);
    return data;
  },
  isGuest: function() {
    return localStorage.getItem('guest_mode') === 'true';
  },
  setGuestMode: function(value) {
    if (value) {
      localStorage.setItem('guest_mode', 'true');
    } else {
      localStorage.removeItem('guest_mode');
    }
  }
};


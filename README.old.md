# momilove
mom i love
My mom just found her TSH four terminal cancer. It's not looking good. She only has a few months. I've created a basic mock up with code provided below of a caregiver/that's me and my mom is a logging system so she can provide the information to our doctors I would like you to go craving this and having to connect to my back and PHPSQL server using PHP my amend and then I want to provide me a list of extensive features add-ons extensions antifreeze update configurations due to to improve this feature.
<code>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Care Tracker Mock — Patient & Family</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root{
      --bg: #0f1115;
      --panel: #151822;
      --panel-2: #181b24;
      --card: #1b1f2b;
      --muted: #9aa3b2;
      --text: #e8ecf1;
      --accent: #6c5ce7; /* purple */
      --accent-2: #8f84ff;
      --success: #2ecc71;
      --danger: #ff6b6b;
      --warning: #f1c40f;
      --shadow: 0 10px 24px rgba(0,0,0,.35), 0 2px 6px rgba(0,0,0,.25);
      --radius-lg: 16px;
      --radius-md: 12px;
      --radius-sm: 10px;
      --ring: 0 0 0 2px rgba(108,92,231,.45), 0 8px 24px rgba(108,92,231,.25);
    }
    *{ box-sizing: border-box; }
    html,body{ height:100%; }
    body{
      margin:0;
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji","Segoe UI Emoji", "Segoe UI Symbol", sans-serif;
      background: radial-gradient(1200px 800px at 10% -10%, rgba(108,92,231,.08), transparent 60%),
                  radial-gradient(1200px 800px at 100% 0%, rgba(108,92,231,.06), transparent 60%),
                  var(--bg);
      color: var(--text);
      line-height: 1.45;
    }
    .app{
      max-width: 1280px;
      margin: 28px auto 64px;
      padding: 0 20px;
    }
    .toolbar{
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 18px;
    }
    .title{
      display:flex;
      align-items:center;
      gap:14px;
    }
    .avatar{
      width:44px;height:44px;border-radius:50%;
      display:grid;place-items:center;
      background: linear-gradient(135deg, #1f2440, #151a2f);
      border:1px solid rgba(255,255,255,.06);
      box-shadow: var(--shadow);
    }
    .avatar svg{ opacity:.9 }
    h1{
      font-size: clamp(18px, 2vw, 22px);
      margin:0;
      letter-spacing:.2px;
    }
    .privacy{
      margin-left:10px;
      font-weight:600;
      font-size: 12px;
      padding:6px 10px;
      border-radius: 999px;
      color:#d9d9ff;
      background: linear-gradient(180deg, rgba(108,92,231,.28), rgba(108,92,231,.14));
      border:1px solid rgba(108,92,231,.35);
    }
    .chipline{
      margin-top:6px;
      color: var(--muted);
      font-size: 13px;
    }
    .btn{
      border:1px solid rgba(255,255,255,.08);
      background: linear-gradient(180deg, #1b2030, #151a24);
      color: var(--text);
      padding:10px 14px;
      border-radius: 12px;
      display:inline-flex;
      gap:8px;
      align-items:center;
      box-shadow: var(--shadow);
      cursor:pointer;
      transition: transform .06s ease, border-color .15s ease, box-shadow .2s ease;
      text-decoration:none;
      font-weight:600;
      font-size: 13px;
    }
    .btn:hover{ transform: translateY(-1px); border-color: rgba(108,92,231,.45); box-shadow: var(--ring); }
    .grid{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap: 22px;
    }
    @media (max-width: 980px){
      .grid{ grid-template-columns: 1fr; }
    }
    .panel{
      background: linear-gradient(180deg, var(--panel), var(--panel-2));
      border:1px solid rgba(255,255,255,.06);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow);
      padding: 18px;
    }
    .top-cards{
      margin-top: 14px;
      display:grid;
      grid-template-columns: repeat(4, minmax(0,1fr));
      gap: 14px;
    }
    .stat{
      background: linear-gradient(180deg, #1b2030, #161b24);
      border:1px solid rgba(255,255,255,.06);
      border-radius: 14px;
      padding: 16px;
      display:grid;
      gap:10px;
      min-height: 86px;
    }
    .stat .label{ color: var(--muted); font-size: 13px; }
    .stat .value{ font-size: 22px; font-weight: 700; letter-spacing: .2px; }
    .tabs{
      display:flex;
      gap:10px;
      flex-wrap: wrap;
      margin: 18px 0 8px;
    }
    .tab{
      border:1px solid rgba(255,255,255,.08);
      padding: 8px 12px;
      border-radius: 999px;
      font-size: 13px;
      color: var(--text);
      background: #161b25;
      cursor:pointer;
      display:inline-flex;
      gap:8px;
      align-items:center;
    }
    .tab.active{
      background: linear-gradient(180deg, rgba(108,92,231,.35), rgba(108,92,231,.18));
      border-color: rgba(108,92,231,.55);
      box-shadow: var(--ring);
    }
    .card{
      background: linear-gradient(180deg, #171b25, #131722);
      border:1px solid rgba(255,255,255,.08);
      border-radius: var(--radius-lg);
      padding: 16px;
      margin-top: 14px;
    }
    .card h3{ margin:0 0 12px 0; font-size: 18px;}
    .form-grid{
      display:grid;
      grid-template-columns: 1.1fr .9fr .9fr .9fr;
      gap: 12px;
      align-items: center;
    }
    .form-grid.caregiver{ grid-template-columns: 1.1fr .9fr .9fr .9fr .9fr; }
    .field{ display:grid; gap:6px; }
    label{ color: var(--muted); font-size: 13px; }
    input[type="text"], input[type="date"], input[type="number"], select, textarea{
      background: #0f1320;
      border: 1px solid rgba(255,255,255,.08);
      color: var(--text);
      border-radius: 12px;
      padding: 12px 12px;
      outline: none;
      transition: border-color .15s ease, box-shadow .15s ease;
      font-size: 14px;
    }
    textarea{ min-height: 44px; resize: vertical; }
    input:focus, select:focus, textarea:focus{ border-color: rgba(108,92,231,.55); box-shadow: var(--ring); }
    .emoji-select{ display:flex; gap:8px; align-items:center; flex-wrap: wrap; }
    .emoji{
      width:38px; height:38px; display:grid; place-items:center;
      border-radius: 10px;
      border:1px solid rgba(255,255,255,.08);
      background:#0f1320; cursor:pointer;
      transition:.15s ease; font-size: 20px;
    }
    .emoji.active, .emoji:hover{
      border-color: rgba(108,92,231,.55);
      box-shadow: var(--ring);
      transform: translateY(-1px);
    }
    .table{
      width:100%;
      border-collapse: collapse;
      margin-top: 14px;
      font-size: 14px;
    }
    .table th, .table td{
      padding: 12px 10px;
      border-top: 1px solid rgba(255,255,255,.06);
    }
    .table th{ color: var(--muted); font-weight: 600; text-align: left; }
    .subtle{ color: var(--muted); }
    .badge{
      display:inline-flex; align-items:center; gap:8px;
      padding:6px 10px; border-radius: 999px;
      font-size: 12px; font-weight:600;
      border:1px solid rgba(255,255,255,.08);
      background:#161b25;
    }
    .spacer{ height: 8px;}
    .divider{ height:1px; background: rgba(255,255,255,.06); margin: 10px 0; }
    .right-actions{ display:flex; gap:10px; align-items:center; }
    .pill-num{
      min-width:24px; height:24px; display:inline-grid; place-items:center;
      border-radius:999px; background: rgba(108,92,231,.25); border:1px solid rgba(108,92,231,.5);
      font-weight:700; font-size:12px; color:#d9d9ff; padding:0 6px;
    }
    .hint{ font-size: 12px; color: var(--muted); margin-top:8px; }
  </style>
</head>
<body>
  <div class="app">
    <div class="toolbar">
      <div class="title">
        <div class="avatar" aria-hidden="true">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z" stroke="#87a2ff" stroke-width="1.4"/>
            <path d="M3 21a9 9 0 0 1 18 0" stroke="#87a2ff" stroke-width="1.4"/>
          </svg>
        </div>
        <div>
          <h1>Diana Care Binder <span class="privacy">Private</span></h1>
          <div class="chipline">Patient: <b>Diana</b> · Caregiver: <b>Chance</b> · Grandson: <b>Ethan</b></div>
        </div>
      </div>
      <div class="right-actions">
        <a class="btn" role="button">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
            <path d="M12 3v12m0 0 4-4m-4 4-4-4M4 21h16" stroke="#cdd1ff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Export JSON
        </a>
      </div>
    </div>

    <div class="grid">
      <!-- PATIENT PANEL -->
      <section class="panel">
        <div class="top-cards">
          <div class="stat">
            <div class="label">Next appointment</div>
            <div class="value subtle">—</div>
          </div>
          <div class="stat">
            <div class="label">Avg pain (7d)</div>
            <div class="value subtle">—</div>
          </div>
          <div class="stat">
            <div class="label">Open symptoms</div>
            <div class="value">0</div>
          </div>
          <div class="stat">
            <div class="label">Docs completed</div>
            <div class="value"><span class="pill-num">0%</span></div>
          </div>
        </div>

        <div class="tabs" role="tablist" aria-label="Patient Navigation">
          <button class="tab" data-target="p-overview">Overview</button>
          <button class="tab" data-target="p-palliative"><span aria-hidden="true">⚕️</span> Palliative Assessment</button>
          <button class="tab" data-target="p-symptoms">∿ Symptoms &amp; Pain</button>
          <button class="tab" data-target="p-meds">✚ Meds Log</button>
          <button class="tab" data-target="p-appts">🗓 Appointments</button>
          <button class="tab" data-target="p-docs">📄 Documents</button>
          <button class="tab" data-target="p-contacts">📞 Contacts</button>
          <button class="tab active" data-target="p-checkin">😊 Daily Check-In</button>
        </div>

        <div id="p-checkin" class="card" role="tabpanel">
          <h3>Daily Check-In</h3>
          <div class="form-grid">
            <div class="field">
              <label for="p-date">Date</label>
              <input id="p-date" type="date" value="2025-08-10" />
            </div>
            <div class="field">
              <label>Mood</label>
              <div class="emoji-select" data-group="p-mood">
                <button class="emoji" aria-label="Bad">😞</button>
                <button class="emoji" aria-label="Okay">😐</button>
                <button class="emoji active" aria-label="Good">😊</button>
                <button class="emoji" aria-label="Great">🤗</button>
              </div>
            </div>
            <div class="field">
              <label for="p-energy">Energy (0–10)</label>
              <input id="p-energy" type="number" min="0" max="10" value="5" />
            </div>
            <div class="field">
              <label for="p-pain">Pain (0–10)</label>
              <input id="p-pain" type="number" min="0" max="10" value="0" />
            </div>
          </div>
          <div class="spacer"></div>
          <div class="field">
            <label for="p-notes">Notes</label>
            <textarea id="p-notes" placeholder="Anything to remember about today"></textarea>
          </div>

          <table class="table" aria-label="Patient History">
            <thead>
              <tr><th>Date</th><th>Mood</th><th>Energy</th><th>Pain</th><th>Notes</th></tr>
            </thead>
            <tbody>
              <tr><td class="subtle">—</td><td>—</td><td>—</td><td>—</td><td class="subtle">No entries yet</td></tr>
            </tbody>
          </table>
        </div>
      </section>

    </div>
  </div>









  <script>
    // Simple tab interactivity (visual only)
    document.querySelectorAll('.tabs').forEach(group => {
      group.addEventListener('click', e => {
        const btn = e.target.closest('.tab');
        if(!btn) return;
        const parent = btn.parentElement;
        parent.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');
        // Panel switching could be wired here; for mock, we only toggle active style
      });
    });
    // Emoji toggle (single-select per group)
    document.querySelectorAll('.emoji-select').forEach(sel => {
      sel.addEventListener('click', e => {
        const b = e.target.closest('.emoji');
        if(!b) return;
        sel.querySelectorAll('.emoji').forEach(x => x.classList.remove('active'));
        b.classList.add('active');
      });
    });
  </script>
</body>
</html>


</code>

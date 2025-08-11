<?php
// Include database configuration
require_once 'config/database.php';

// Get current date for default values
$current_date = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>MomiLove — Boat Logging & Care Tracker</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
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
          <h1>MomiLove Care & Boat Tracker <span class="privacy">Private</span></h1>
          <div class="chipline">Patient: <b>Mom</b> · Caregiver: <b>Me</b> · Location: <b>Milford, SK</b></div>
        </div>
      </div>
      <div class="right-actions">
        <a class="btn" href="export.php" role="button">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
            <path d="M12 3v12m0 0 4-4m-4 4-4-4M4 21h16" stroke="#cdd1ff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Export Data
        </a>
      </div>
    </div>

    <div class="grid">
      <!-- MAIN TRACKER PANEL -->
      <section class="panel">
        <div class="top-cards">
          <div class="stat">
            <div class="label">Next appointment</div>
            <div class="value subtle" id="next-appointment">—</div>
          </div>
          <div class="stat">
            <div class="label">Avg mood (7d)</div>
            <div class="value subtle" id="avg-mood">—</div>
          </div>
          <div class="stat">
            <div class="label">Boat trips</div>
            <div class="value" id="boat-trips">0</div>
          </div>
          <div class="stat">
            <div class="label">Days logged</div>
            <div class="value"><span class="pill-num" id="days-logged">0</span></div>
          </div>
        </div>

        <div class="tabs" role="tablist" aria-label="Main Navigation">
          <button class="tab active" data-target="daily-checkin">😊 Daily Check-In</button>
          <button class="tab" data-target="boat-logging">⛵ Boat Logging</button>
          <button class="tab" data-target="resources">📍 Milford Resources</button>
          <button class="tab" data-target="appointments">🗓 Appointments</button>
          <button class="tab" data-target="history">📊 History</button>
        </div>

        <!-- Daily Check-In Panel -->
        <div id="daily-checkin" class="card active-panel" role="tabpanel">
          <h3>Daily Check-In</h3>
          <form id="daily-form" method="POST" action="includes/save_daily.php">
            <div class="form-grid">
              <div class="field">
                <label for="daily-date">Date</label>
                <input id="daily-date" name="date" type="date" value="<?php echo $current_date; ?>" required />
              </div>
              <div class="field">
                <label>Mood</label>
                <div class="emoji-select" data-group="daily-mood">
                  <button type="button" class="emoji" data-value="1" aria-label="Bad">😞</button>
                  <button type="button" class="emoji" data-value="2" aria-label="Okay">😐</button>
                  <button type="button" class="emoji active" data-value="3" aria-label="Good">😊</button>
                  <button type="button" class="emoji" data-value="4" aria-label="Great">🤗</button>
                </div>
                <input type="hidden" name="mood" id="mood-value" value="3">
              </div>
              <div class="field">
                <label for="daily-energy">Energy (0–10)</label>
                <input id="daily-energy" name="energy" type="number" min="0" max="10" value="5" required />
              </div>
              <div class="field">
                <label for="daily-pain">Pain (0–10)</label>
                <input id="daily-pain" name="pain" type="number" min="0" max="10" value="0" required />
              </div>
            </div>
            <div class="spacer"></div>
            <div class="field">
              <label for="daily-notes">Notes</label>
              <textarea id="daily-notes" name="notes" placeholder="Anything to remember about today"></textarea>
            </div>
            <div class="spacer"></div>
            <button type="submit" class="btn">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path d="M5 12l5 5L20 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              Save Daily Entry
            </button>
          </form>

          <div class="divider"></div>
          <h4>Recent Entries</h4>
          <table class="table" aria-label="Daily Tracker History">
            <thead>
              <tr><th>Date</th><th>Mood</th><th>Energy</th><th>Pain</th><th>Notes</th></tr>
            </thead>
            <tbody id="daily-history">
              <tr><td class="subtle">Loading...</td><td>—</td><td>—</td><td>—</td><td class="subtle">—</td></tr>
            </tbody>
          </table>
        </div>

        <!-- Boat Logging Panel -->
        <div id="boat-logging" class="card" role="tabpanel" style="display: none;">
          <h3>Boat Logging</h3>
          <form id="boat-form" method="POST" action="includes/save_boat.php">
            <div class="form-grid">
              <div class="field">
                <label for="boat-date">Trip Date</label>
                <input id="boat-date" name="trip_date" type="date" value="<?php echo $current_date; ?>" required />
              </div>
              <div class="field">
                <label for="boat-location">Location</label>
                <input id="boat-location" name="location" type="text" placeholder="e.g., Blackstrap Lake" required />
              </div>
              <div class="field">
                <label for="boat-duration">Duration (hours)</label>
                <input id="boat-duration" name="duration" type="number" min="0" step="0.5" placeholder="2.5" required />
              </div>
              <div class="field">
                <label for="boat-weather">Weather</label>
                <select id="boat-weather" name="weather" required>
                  <option value="">Select weather</option>
                  <option value="sunny">☀️ Sunny</option>
                  <option value="cloudy">☁️ Cloudy</option>
                  <option value="partly_cloudy">⛅ Partly Cloudy</option>
                  <option value="rainy">🌧️ Rainy</option>
                  <option value="windy">💨 Windy</option>
                </select>
              </div>
            </div>
            <div class="spacer"></div>
            <div class="form-grid">
              <div class="field">
                <label for="boat-companions">Companions</label>
                <input id="boat-companions" name="companions" type="text" placeholder="Who joined the trip?" />
              </div>
              <div class="field">
                <label for="boat-activity">Activity</label>
                <select id="boat-activity" name="activity">
                  <option value="">Select activity</option>
                  <option value="fishing">🎣 Fishing</option>
                  <option value="cruising">🚤 Cruising</option>
                  <option value="swimming">🏊‍♀️ Swimming</option>
                  <option value="relaxing">😌 Relaxing</option>
                  <option value="other">🔄 Other</option>
                </select>
              </div>
              <div class="field">
                <label>Enjoyment</label>
                <div class="emoji-select" data-group="boat-enjoyment">
                  <button type="button" class="emoji" data-value="1" aria-label="Poor">😞</button>
                  <button type="button" class="emoji" data-value="2" aria-label="Okay">😐</button>
                  <button type="button" class="emoji active" data-value="3" aria-label="Good">😊</button>
                  <button type="button" class="emoji" data-value="4" aria-label="Excellent">🤗</button>
                </div>
                <input type="hidden" name="enjoyment" id="enjoyment-value" value="3">
              </div>
              <div class="field">
                <label for="boat-rating">Overall Rating (1-5)</label>
                <input id="boat-rating" name="rating" type="number" min="1" max="5" value="3" required />
              </div>
            </div>
            <div class="spacer"></div>
            <div class="field">
              <label for="boat-notes">Trip Notes</label>
              <textarea id="boat-notes" name="notes" placeholder="Describe the trip, catch details, memorable moments..."></textarea>
            </div>
            <div class="spacer"></div>
            <button type="submit" class="btn">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path d="M5 12l5 5L20 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              Log Boat Trip
            </button>
          </form>

          <div class="divider"></div>
          <h4>Recent Boat Trips</h4>
          <table class="table" aria-label="Boat Trip History">
            <thead>
              <tr><th>Date</th><th>Location</th><th>Duration</th><th>Activity</th><th>Rating</th><th>Notes</th></tr>
            </thead>
            <tbody id="boat-history">
              <tr><td class="subtle">Loading...</td><td>—</td><td>—</td><td>—</td><td>—</td><td class="subtle">—</td></tr>
            </tbody>
          </table>
        </div>

        <!-- Milford Resources Panel -->
        <div id="resources" class="card" role="tabpanel" style="display: none;">
          <h3>Milford, Saskatchewan Resources</h3>
          <div id="resources-content">
            <!-- Resources will be loaded via JavaScript -->
            <div class="subtle">Loading resources...</div>
          </div>
        </div>

        <!-- Appointments Panel -->
        <div id="appointments" class="card" role="tabpanel" style="display: none;">
          <h3>Appointments</h3>
          <form id="appointment-form" method="POST" action="includes/save_appointment.php">
            <div class="form-grid">
              <div class="field">
                <label for="appt-date">Date</label>
                <input id="appt-date" name="appointment_date" type="date" required />
              </div>
              <div class="field">
                <label for="appt-time">Time</label>
                <input id="appt-time" name="appointment_time" type="time" required />
              </div>
              <div class="field">
                <label for="appt-doctor">Doctor/Provider</label>
                <input id="appt-doctor" name="doctor" type="text" placeholder="Dr. Smith" required />
              </div>
              <div class="field">
                <label for="appt-type">Type</label>
                <select id="appt-type" name="appointment_type" required>
                  <option value="">Select type</option>
                  <option value="checkup">Regular Checkup</option>
                  <option value="specialist">Specialist</option>
                  <option value="oncology">Oncology</option>
                  <option value="cardiology">Cardiology</option>
                  <option value="other">Other</option>
                </select>
              </div>
            </div>
            <div class="spacer"></div>
            <div class="field">
              <label for="appt-notes">Notes</label>
              <textarea id="appt-notes" name="notes" placeholder="Questions to ask, symptoms to discuss..."></textarea>
            </div>
            <div class="spacer"></div>
            <button type="submit" class="btn">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path d="M5 12l5 5L20 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              Save Appointment
            </button>
          </form>

          <div class="divider"></div>
          <h4>Upcoming Appointments</h4>
          <table class="table" aria-label="Appointments">
            <thead>
              <tr><th>Date</th><th>Time</th><th>Doctor</th><th>Type</th><th>Notes</th></tr>
            </thead>
            <tbody id="appointment-history">
              <tr><td class="subtle">Loading...</td><td>—</td><td>—</td><td>—</td><td class="subtle">—</td></tr>
            </tbody>
          </table>
        </div>

        <!-- History Panel -->
        <div id="history" class="card" role="tabpanel" style="display: none;">
          <h3>History & Analytics</h3>
          <div class="top-cards">
            <div class="stat">
              <div class="label">Total entries</div>
              <div class="value" id="total-entries">0</div>
            </div>
            <div class="stat">
              <div class="label">Avg energy</div>
              <div class="value" id="avg-energy">—</div>
            </div>
            <div class="stat">
              <div class="label">Total boat hours</div>
              <div class="value" id="total-boat-hours">0</div>
            </div>
            <div class="stat">
              <div class="label">Best rated trip</div>
              <div class="value" id="best-trip">—</div>
            </div>
          </div>
          <div class="spacer"></div>
          <p class="hint">Complete analytics and trends will be displayed here.</p>
        </div>
      </section>
    </div>
  </div>

  <script src="js/app.js"></script>
</body>
</html>
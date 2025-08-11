// Global app state
const app = {
  currentTab: 'daily-checkin',
  isLoading: false
};

// DOM Content Loaded
document.addEventListener('DOMContentLoaded', function() {
  initializeApp();
});

function initializeApp() {
  setupTabNavigation();
  setupEmojiSelectors();
  setupFormSubmissions();
  loadInitialData();
}

// Tab navigation system
function setupTabNavigation() {
  document.querySelectorAll('.tabs').forEach(group => {
    group.addEventListener('click', e => {
      const btn = e.target.closest('.tab');
      if (!btn) return;
      
      const targetId = btn.getAttribute('data-target');
      if (!targetId) return;
      
      // Update active tab
      const parent = btn.parentElement;
      parent.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
      btn.classList.add('active');
      
      // Show corresponding panel
      document.querySelectorAll('.card[role="tabpanel"]').forEach(panel => {
        panel.classList.remove('active-panel');
      });
      
      const targetPanel = document.getElementById(targetId);
      if (targetPanel) {
        targetPanel.classList.add('active-panel');
        app.currentTab = targetId;
        
        // Load data for the active tab
        loadTabData(targetId);
      }
    });
  });
}

// Emoji selector functionality
function setupEmojiSelectors() {
  document.querySelectorAll('.emoji-select').forEach(selector => {
    selector.addEventListener('click', e => {
      const emoji = e.target.closest('.emoji');
      if (!emoji) return;
      
      // Update visual selection
      selector.querySelectorAll('.emoji').forEach(e => e.classList.remove('active'));
      emoji.classList.add('active');
      
      // Update hidden input value
      const value = emoji.getAttribute('data-value');
      const group = selector.getAttribute('data-group');
      
      if (group === 'daily-mood') {
        document.getElementById('mood-value').value = value;
      } else if (group === 'boat-enjoyment') {
        document.getElementById('enjoyment-value').value = value;
      }
    });
  });
}

// Form submission handlers
function setupFormSubmissions() {
  // Daily check-in form
  const dailyForm = document.getElementById('daily-form');
  if (dailyForm) {
    dailyForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      await submitForm(dailyForm, 'daily');
    });
  }
  
  // Boat logging form
  const boatForm = document.getElementById('boat-form');
  if (boatForm) {
    boatForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      await submitForm(boatForm, 'boat');
    });
  }
  
  // Appointment form
  const appointmentForm = document.getElementById('appointment-form');
  if (appointmentForm) {
    appointmentForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      await submitForm(appointmentForm, 'appointment');
    });
  }
}

// Generic form submission
async function submitForm(form, type) {
  if (app.isLoading) return;
  
  const formData = new FormData(form);
  const submitBtn = form.querySelector('button[type="submit"]');
  
  // Show loading state
  setLoadingState(form, true);
  const originalBtnText = submitBtn.innerHTML;
  submitBtn.innerHTML = `
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="animation: spin 1s linear infinite;">
      <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-dasharray="60 30"/>
    </svg>
    Saving...
  `;
  
  try {
    const response = await fetch(form.action, {
      method: 'POST',
      body: formData
    });
    
    const result = await response.json();
    
    if (result.success) {
      showMessage('Data saved successfully!', 'success');
      form.reset();
      
      // Reset emoji selectors to default
      form.querySelectorAll('.emoji').forEach(emoji => emoji.classList.remove('active'));
      form.querySelectorAll('.emoji[data-value="3"]').forEach(emoji => emoji.classList.add('active'));
      
      // Update hidden values
      const moodInput = form.querySelector('#mood-value');
      const enjoymentInput = form.querySelector('#enjoyment-value');
      if (moodInput) moodInput.value = '3';
      if (enjoymentInput) enjoymentInput.value = '3';
      
      // Refresh data
      loadTabData(app.currentTab);
      updateDashboardStats();
    } else {
      showMessage(result.message || 'Error saving data', 'error');
    }
  } catch (error) {
    console.error('Form submission error:', error);
    showMessage('Network error. Please try again.', 'error');
  } finally {
    setLoadingState(form, false);
    submitBtn.innerHTML = originalBtnText;
  }
}

// Show success/error messages
function showMessage(text, type = 'success') {
  // Remove existing messages
  document.querySelectorAll('.message').forEach(msg => msg.remove());
  
  const message = document.createElement('div');
  message.className = `message ${type}`;
  message.textContent = text;
  
  // Insert at the top of the active panel
  const activePanel = document.querySelector('.card.active-panel');
  if (activePanel) {
    activePanel.insertBefore(message, activePanel.firstChild);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
      message.remove();
    }, 5000);
  }
}

// Set loading state
function setLoadingState(element, loading) {
  app.isLoading = loading;
  if (loading) {
    element.classList.add('loading');
  } else {
    element.classList.remove('loading');
  }
}

// Load data for specific tab
async function loadTabData(tabId) {
  try {
    switch (tabId) {
      case 'daily-checkin':
        await loadDailyHistory();
        break;
      case 'boat-logging':
        await loadBoatHistory();
        break;
      case 'resources':
        await loadResources();
        break;
      case 'appointments':
        await loadAppointments();
        break;
      case 'history':
        await loadAnalytics();
        break;
    }
  } catch (error) {
    console.error('Error loading tab data:', error);
  }
}

// Load daily check-in history
async function loadDailyHistory() {
  const tbody = document.getElementById('daily-history');
  if (!tbody) return;
  
  try {
    const response = await fetch('includes/get_daily.php');
    const data = await response.json();
    
    if (data.success && data.entries.length > 0) {
      tbody.innerHTML = data.entries.map(entry => `
        <tr>
          <td>${formatDate(entry.date)}</td>
          <td>${getMoodEmoji(entry.mood)}</td>
          <td>${entry.energy}/10</td>
          <td>${entry.pain}/10</td>
          <td class="subtle">${entry.notes || '—'}</td>
        </tr>
      `).join('');
    } else {
      tbody.innerHTML = '<tr><td class="subtle">No entries yet</td><td>—</td><td>—</td><td>—</td><td class="subtle">—</td></tr>';
    }
  } catch (error) {
    console.error('Error loading daily history:', error);
    tbody.innerHTML = '<tr><td class="subtle">Error loading data</td><td>—</td><td>—</td><td>—</td><td class="subtle">—</td></tr>';
  }
}

// Load boat trip history
async function loadBoatHistory() {
  const tbody = document.getElementById('boat-history');
  if (!tbody) return;
  
  try {
    const response = await fetch('includes/get_boats.php');
    const data = await response.json();
    
    if (data.success && data.trips.length > 0) {
      tbody.innerHTML = data.trips.map(trip => `
        <tr>
          <td>${formatDate(trip.trip_date)}</td>
          <td>${trip.location}</td>
          <td>${trip.duration}h</td>
          <td>${getActivityIcon(trip.activity)} ${trip.activity || '—'}</td>
          <td>${'⭐'.repeat(trip.rating || 0)}</td>
          <td class="subtle">${trip.notes ? trip.notes.substring(0, 50) + (trip.notes.length > 50 ? '...' : '') : '—'}</td>
        </tr>
      `).join('');
    } else {
      tbody.innerHTML = '<tr><td class="subtle">No boat trips yet</td><td>—</td><td>—</td><td>—</td><td>—</td><td class="subtle">—</td></tr>';
    }
  } catch (error) {
    console.error('Error loading boat history:', error);
    tbody.innerHTML = '<tr><td class="subtle">Error loading data</td><td>—</td><td>—</td><td>—</td><td>—</td><td class="subtle">—</td></tr>';
  }
}

// Load Milford resources
async function loadResources() {
  const container = document.getElementById('resources-content');
  if (!container) return;
  
  try {
    const response = await fetch('includes/get_resources.php');
    const data = await response.json();
    
    if (data.success) {
      container.innerHTML = data.categories.map(category => `
        <div class="resource-category">
          <h4>${category.icon} ${category.name}</h4>
          <div class="resource-list">
            ${category.resources.map(resource => `
              <div class="resource-item">
                <h5>${resource.name}</h5>
                <div class="address">${resource.address}</div>
                ${resource.phone ? `<a href="tel:${resource.phone}" class="phone">${resource.phone}</a>` : ''}
                ${resource.description ? `<div class="subtle" style="margin-top: 6px; font-size: 12px;">${resource.description}</div>` : ''}
              </div>
            `).join('')}
          </div>
        </div>
      `).join('');
    } else {
      container.innerHTML = '<div class="subtle">Error loading resources</div>';
    }
  } catch (error) {
    console.error('Error loading resources:', error);
    container.innerHTML = '<div class="subtle">Error loading resources</div>';
  }
}

// Load appointments
async function loadAppointments() {
  const tbody = document.getElementById('appointment-history');
  if (!tbody) return;
  
  try {
    const response = await fetch('includes/get_appointments.php');
    const data = await response.json();
    
    if (data.success && data.appointments.length > 0) {
      tbody.innerHTML = data.appointments.map(appt => `
        <tr>
          <td>${formatDate(appt.appointment_date)}</td>
          <td>${appt.appointment_time}</td>
          <td>${appt.doctor}</td>
          <td>${appt.appointment_type}</td>
          <td class="subtle">${appt.notes || '—'}</td>
        </tr>
      `).join('');
    } else {
      tbody.innerHTML = '<tr><td class="subtle">No appointments scheduled</td><td>—</td><td>—</td><td>—</td><td class="subtle">—</td></tr>';
    }
  } catch (error) {
    console.error('Error loading appointments:', error);
    tbody.innerHTML = '<tr><td class="subtle">Error loading data</td><td>—</td><td>—</td><td>—</td><td class="subtle">—</td></tr>';
  }
}

// Load analytics data
async function loadAnalytics() {
  try {
    const response = await fetch('includes/get_analytics.php');
    const data = await response.json();
    
    if (data.success) {
      updateElement('total-entries', data.analytics.total_entries);
      updateElement('avg-energy', data.analytics.avg_energy ? data.analytics.avg_energy.toFixed(1) : '—');
      updateElement('total-boat-hours', data.analytics.total_boat_hours || '0');
      updateElement('best-trip', data.analytics.best_trip || '—');
    }
  } catch (error) {
    console.error('Error loading analytics:', error);
  }
}

// Update dashboard statistics
async function updateDashboardStats() {
  try {
    const response = await fetch('includes/get_dashboard_stats.php');
    const data = await response.json();
    
    if (data.success) {
      updateElement('next-appointment', data.stats.next_appointment || '—');
      updateElement('avg-mood', data.stats.avg_mood ? getMoodEmoji(data.stats.avg_mood) : '—');
      updateElement('boat-trips', data.stats.boat_trips || '0');
      updateElement('days-logged', data.stats.days_logged || '0');
    }
  } catch (error) {
    console.error('Error updating dashboard stats:', error);
  }
}

// Load initial data
function loadInitialData() {
  loadTabData(app.currentTab);
  updateDashboardStats();
}

// Utility functions
function updateElement(id, value) {
  const element = document.getElementById(id);
  if (element) {
    element.textContent = value;
  }
}

function formatDate(dateString) {
  const date = new Date(dateString);
  return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
}

function getMoodEmoji(mood) {
  const moods = ['😞', '😐', '😊', '🤗'];
  return moods[mood - 1] || '—';
}

function getActivityIcon(activity) {
  const icons = {
    fishing: '🎣',
    cruising: '🚤',
    swimming: '🏊‍♀️',
    relaxing: '😌',
    other: '🔄'
  };
  return icons[activity] || '';
}

// Add CSS for spin animation
const style = document.createElement('style');
style.textContent = `
  @keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
  }
`;
document.head.appendChild(style);
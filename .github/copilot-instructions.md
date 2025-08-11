# Momilove Care Tracker
Momilove is a single-file HTML application for tracking terminal cancer patient care. The application provides an interface for caregivers to log patient mood, pain levels, energy, medications, appointments, and other medical information.

Always reference these instructions first and fallback to search or bash commands only when you encounter unexpected information that does not match the info here.

## Working Effectively
- **CRITICAL**: This is a single-file HTML application with embedded CSS and JavaScript - there is NO traditional build process.
- Extract the HTML application from README.md to test it:
  - `sed -n '7,368p' README.md > care-tracker.html`
- Run the application locally:
  - `python3 -m http.server 8000` -- starts in under 1 second. NEVER CANCEL.
  - Open browser to `http://localhost:8000/care-tracker.html`
- **NO BUILD STEP REQUIRED** - the application runs directly as static HTML
- **NO DEPENDENCIES TO INSTALL** - uses external Google Fonts only (may be blocked by some networks)

## Validation
- Always manually validate any changes by running the application in a browser
- Test ALL interactive elements: tabs, emoji selectors, form inputs, and buttons
- **VALIDATION SCENARIOS**: 
  - Test tab switching: click "Overview", "Palliative Assessment", "Daily Check-In" tabs
  - Test emoji mood selection: click different mood emojis (😞, 😐, 😊, 🤗)
  - Test form inputs: modify date, energy/pain numbers (0-10), add notes
  - Verify visual feedback: active tabs highlight purple, selected emojis highlight purple
- Take screenshots to document UI changes using browser developer tools or Playwright
- **NO LINTING OR TESTING FRAMEWORK EXISTS** - validation is entirely manual and visual

## Time Expectations
- File operations: instantaneous (< 0.01 seconds)
- Python HTTP server startup: under 1 second. NEVER CANCEL.
- HTML application load: under 2 seconds. NEVER CANCEL.
- Total validation workflow: under 30 seconds from start to finish

## Common Tasks
The following are outputs from frequently run commands. Reference them instead of viewing, searching, or running bash commands to save time.

### Repository Structure
```
/home/runner/work/momilove/momilove/
├── README.md (contains HTML application code from lines 7-368)
├── .git/
└── .github/
    └── copilot-instructions.md (this file)
```

### Extract HTML Application
```bash
cd /home/runner/work/momilove/momilove
sed -n '7,368p' README.md > care-tracker.html
```

### Run Application Locally
```bash
# Start HTTP server (runs immediately)
python3 -m http.server 8000

# Application URL: http://localhost:8000/care-tracker.html
```

### Available Tools
- Node.js v20.19.4 with npm 10.8.2 (available but not used)
- Python 3.12.3 (used for HTTP server)
- PHP 8.3.6 (mentioned in README for future backend integration)
- MySQL (mentioned in README for future backend integration)

### Current Application Features
- **Patient Care Dashboard**: Shows next appointment, pain averages, symptoms, docs completion
- **Interactive Tabs**: Overview, Palliative Assessment, Symptoms & Pain, Meds Log, Appointments, Documents, Contacts, Daily Check-In
- **Daily Check-In Form**: Date picker, mood emoji selector, energy/pain number inputs (0-10), notes textarea
- **Data Table**: Patient history table (currently empty/mock data)
- **Dark Theme**: Purple accent colors (#6c5ce7), responsive design
- **JavaScript Interactivity**: Tab switching, emoji selection, form interactions

### Known Issues
- Google Fonts may be blocked by network policies (console error: ERR_BLOCKED_BY_CLIENT)
- Application is currently front-end only (no backend persistence)
- README mentions future PHP/MySQL backend integration needed

### Future Development Notes
- README indicates need to connect to "PHP/SQL server"
- Mentions creating "extensive features add-ons extensions" 
- Current implementation is a mock-up/prototype for caregiver logging system

## Key Principles
- **NO BUILD PROCESS**: Never try to run `npm install`, `npm run build`, or similar commands
- **STATIC HTML**: Application runs entirely in browser as static files
- **MANUAL TESTING**: Always test changes by loading in browser and exercising functionality
- **VISUAL VALIDATION**: Screenshots are the primary form of documentation for UI changes
- **MINIMAL CHANGES**: Preserve the single-file architecture unless explicitly required to change it
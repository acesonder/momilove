# MomiLove Web Application

A comprehensive care tracking and boat logging application designed for caregivers and patients in Milford, Saskatchewan.

## Features

### 📱 **Daily Check-In Tracker**
- Mood tracking with emoji-based selection (😞 😐 😊 🤗)
- Energy level monitoring (0-10 scale)
- Pain level tracking (0-10 scale)
- Daily notes and observations
- Historical tracking with trend analysis

### ⛵ **Boat Logging System**
- Trip date and location tracking
- Duration recording (in hours)
- Weather conditions (Sunny, Cloudy, Partly Cloudy, Rainy, Windy)
- Companion information
- Activity selection (Fishing, Cruising, Swimming, Relaxing, Other)
- Enjoyment rating with emojis
- Overall trip rating (1-5 stars)
- Detailed trip notes
- Trip history and analytics

### 📍 **Milford, Saskatchewan Resources**
Pre-loaded comprehensive directory of local resources including:

#### 🚒 Emergency Services
- RCMP Kindersley Detachment
- Kindersley Fire Department  
- SaskPower Emergency Line

#### 🏥 Healthcare
- Kindersley Regional Health Centre
- Milford Medical Clinic
- Unity Health Centre

#### 💊 Pharmacy Services
- Pharmasave Kindersley
- Unity Pharmacy

#### 🏠 Senior Services
- West Central Seniors Association
- Meals on Wheels Kindersley
- Home Care Services

#### 🚐 Transportation
- Handi-Bus West Central
- Unity Taxi

#### 🎗️ Support Services
- Saskatchewan Health Authority
- Canadian Cancer Society
- Community Living Division

#### 🏞️ Recreation
- Kindersley Regional Park
- Unity Lake
- Milford Community Centre

### 🗓 **Appointment Management**
- Schedule medical appointments
- Doctor/provider information
- Appointment type categorization
- Notes and preparation reminders
- Upcoming appointment tracking

### 📊 **Analytics & History**
- Dashboard with key metrics
- 7-day mood averages
- Total boat trip hours
- Days logged statistics
- Trend analysis

### 📤 **Data Export**
- Complete data export in JSON format
- Backup and sharing capabilities

## Technology Stack

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Backend**: PHP 8.3+
- **Database**: SQLite (portable, no setup required)
- **Styling**: Custom CSS with dark purple theme matching original mockup
- **Icons**: Emoji-based for accessibility and visual appeal

## Installation

1. Clone the repository
2. Ensure PHP 8.3+ is installed
3. Start PHP development server:
   ```bash
   php -S localhost:8000
   ```
4. Open browser to `http://localhost:8000`

The application will automatically create the SQLite database and populate it with Milford, SK resources on first run.

## File Structure

```
/
├── index.php              # Main application entry point
├── css/
│   └── styles.css        # All styling (maintains original theme)
├── js/
│   └── app.js           # Frontend JavaScript functionality
├── includes/            # PHP backend files
│   ├── save_daily.php   # Daily entry saving
│   ├── save_boat.php    # Boat trip logging
│   ├── save_appointment.php # Appointment scheduling
│   ├── get_daily.php    # Fetch daily entries
│   ├── get_boats.php    # Fetch boat trips
│   ├── get_appointments.php # Fetch appointments
│   ├── get_resources.php # Fetch local resources
│   ├── get_analytics.php # Analytics data
│   └── get_dashboard_stats.php # Dashboard metrics
├── config/
│   └── database.php     # Database configuration
├── sql/
│   └── init_database.php # Database initialization
├── data/
│   └── momilove.db      # SQLite database (auto-created)
└── export.php           # Data export functionality
```

## Design Philosophy

This application maintains the original dark purple theme and elegant design from the initial mockup while extending it into a full-featured web application. The UI emphasizes:

- **Accessibility**: Clear typography, good contrast, emoji-based selections
- **Ease of Use**: Intuitive navigation, minimal clicks required
- **Local Focus**: Pre-populated with Milford, Saskatchewan resources
- **Emotional Support**: Gentle design suitable for sensitive health tracking
- **Data Persistence**: Reliable storage with backup capabilities

## Usage

1. **Daily Tracking**: Start each day by filling out the daily check-in form
2. **Boat Logging**: Record memorable boat trips with full details
3. **Resource Access**: Quickly find local healthcare, emergency, and support services
4. **Appointment Management**: Keep track of upcoming medical appointments
5. **Progress Monitoring**: Review analytics and historical trends

The application is designed to support both the patient and caregiver in maintaining comprehensive health and activity records while providing easy access to essential local resources in Milford, Saskatchewan.

## Browser Support

- Chrome/Chromium 80+
- Firefox 75+
- Safari 13+
- Edge 80+

## License

Created for personal use in Milford, Saskatchewan. Local resource information should be verified for accuracy.
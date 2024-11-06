//Submit Attendance accurate Date and Time
function updateDateTime() {
  const now = new Date();
  
  // Display current date (Weekday, Month, Day, Year)
  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  document.getElementById('current-date').innerText = now.toLocaleDateString('en-US', options);

  // Display current time
  document.getElementById('current-time').innerText = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

  // Update time every second
  setTimeout(updateDateTime, 1000);
}

// Initial call to display the date and time
updateDateTime();
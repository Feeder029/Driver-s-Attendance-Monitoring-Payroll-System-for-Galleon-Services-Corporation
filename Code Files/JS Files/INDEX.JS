// Function to handle displaying the selected form section and showing or hiding the nav menu
function showForm(formId, showNav) {

  const formContainer = document.getElementById('form-container'); // The container where form content will be loaded

  // Clear any existing content in the container
  formContainer.innerHTML = '';

  // Determine the path to the PHP file based on the formId
  const formPath = `${formId}.php`; // Assumes that each form has its own PHP file

  // Fetch and load the content from the PHP file
  fetch(formPath)
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.text();
    })
    .then(html => {
      formContainer.innerHTML = html; // Insert the loaded HTML content into the container
    })
    .catch(error => {
      console.error('Error loading form:', error);
      formContainer.innerHTML = '<p>Sorry, there was an error loading the form.</p>';
    });

  // Show or hide the navigation menu based on the clicked option
  const navMenu = document.querySelector('.nav-menu');
  if (showNav) {
    navMenu.style.display = 'flex'; // Show the navigation menu
  } else {
    navMenu.style.display = 'none'; // Hide the navigation menu
  }
}
  
  // Toggle dropdown menu visibility
  function toggleMenu() {
    const dropdown = document.getElementById('dropdown-menu');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
  }
  
  // Close dropdown when clicking outside of it
  window.onclick = function(event) {
    if (!event.target.matches('.menu-icon') && !event.target.matches('.dropdown a')) {
      const dropdown = document.getElementById('dropdown-menu');
      dropdown.style.display = 'none';
    }
  }

  function logout(){
    window.logout.href = "../LoginSignup/DriverMainDashBoard.html"
  }
  
  // Show the default form on page load (e.g., Personal Account Section)
  window.addEventListener('DOMContentLoaded', () => {
    showForm('EMP_PERSONAL-ACCOUNT', true); // Load personal-account section by default
  });
  
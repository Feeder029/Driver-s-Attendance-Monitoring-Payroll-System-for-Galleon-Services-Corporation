//Container forms flow
function showForm(formId, showNav) {
  const formSections = document.querySelectorAll('.form-section');
  formSections.forEach(section => {
    section.style.display = 'none'; // Hide all form sections
  });
  
  const selectedForm = document.getElementById(formId);
  if (selectedForm) {
    selectedForm.style.display = 'block'; // Show the selected form
  }

  // Show or hide the navigation menu based on the clicked option
  const navMenu = document.querySelector('.nav-menu');
  if (showNav) {
    navMenu.style.display = 'flex'; // Show the navigation menu
  } else {
    navMenu.style.display = 'none'; // Hide the navigation menu
  }
}

function toggleMenu() {
  const dropdown = document.getElementById('dropdown-menu');
  dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}

//Close dropdown when clicking outside of it
window.onclick = function(event) {
  if (!event.target.matches('.menu-icon') && !event.target.matches('.dropdown a')) {
    const dropdown = document.getElementById('dropdown-menu');
    dropdown.style.display = 'none';
  }
}
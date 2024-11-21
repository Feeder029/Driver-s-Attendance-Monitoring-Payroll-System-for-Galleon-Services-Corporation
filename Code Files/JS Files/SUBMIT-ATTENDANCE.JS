function toggleCard(button) {
    const cardContent = button.parentElement.nextElementSibling;
    cardContent.style.display = cardContent.style.display === 'none' ? 'block' : 'none';
    button.textContent = cardContent.style.display === 'none' ? 'View' : 'Hide';
}

// Hide all expandable content on page load
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.card-content').forEach(content => content.style.display = 'none');
});

function confirmSubmission(event) {
    event.preventDefault(); // Prevent the default form submission
    var confirmation = confirm("Are you sure you want to submit the form?");
    if (confirmation) {
        event.target.closest('form').submit(); // Submit the form if confirmed
    } 
}
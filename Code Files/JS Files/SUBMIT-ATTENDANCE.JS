function toggleCard(button) {
    const cardContent = button.parentElement.nextElementSibling;
    cardContent.style.display = cardContent.style.display === 'none' ? 'block' : 'none';
    button.textContent = cardContent.style.display === 'none' ? 'View' : 'Hide';
}

// Hide all expandable content on page load
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.card-content').forEach(content => content.style.display = 'none');
});
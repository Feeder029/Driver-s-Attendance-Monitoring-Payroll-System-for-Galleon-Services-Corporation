window.onload = function() {
    document.getElementById('iframe-dashboard').src = 'Accounts.html';
};


const sidebarLinks = document.querySelectorAll('.side-menu li a');

sidebarLinks.forEach(link => {
    link.addEventListener('click', function () {
        sidebarLinks.forEach(l => l.classList.remove('active')); 
        this.classList.add('active');
    });
});

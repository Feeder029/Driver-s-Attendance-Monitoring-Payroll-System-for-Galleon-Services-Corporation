window.onload = function() {
    document.getElementById('iframe-dashboard').src = 'http://localhost/Driver-s-Attendance-Monitoring-Payroll-System-for-Galleon-Services-Corporation/Code%20Files/HTML%20Files/Accounts.php';
};


const sidebarLinks = document.querySelectorAll('.side-menu li a');

sidebarLinks.forEach(link => {
    link.addEventListener('click', function () {
        sidebarLinks.forEach(l => l.classList.remove('active')); 
        this.classList.add('active');
    });
});

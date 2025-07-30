const mobileMenu = document.getElementById('mobile-menu');
const navLinks = document.querySelector('.navbar ul');

mobileMenu.addEventListener('click', () => {
    navLinks.classList.toggle('active'); // Show/hide the menu
});




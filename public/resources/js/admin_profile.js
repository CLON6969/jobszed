
function loadPage(page) {
    const iframe = document.getElementById('contentFrame');
    iframe.src = page;
}

// Sidebar toggle and icon change
document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.querySelector('.sidebar');
    const menuToggle = document.getElementById('menuToggle');
    const menuIcon = menuToggle.querySelector('i');

    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        if (sidebar.classList.contains('collapsed')) {
            menuIcon.classList.replace('fa-times', 'fa-bars');
        } else {
            menuIcon.classList.replace('fa-bars', 'fa-times');
        }
    });

    // Dropdown functionality
    const dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('click', function(e) {
            const menu = this.querySelector('.dropdown-menu');
            menu.classList.toggle('show');
            e.stopPropagation();  // Prevent event from propagating to parent
        });
    });

    // Close dropdown when clicked outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });
});


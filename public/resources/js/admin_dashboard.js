const sidebar = document.getElementById('sidebar');
const sidebarToggleIcon = document.getElementById('sidebarToggleIcon');
const body = document.body;

const savedTheme = localStorage.getItem('theme');
if (savedTheme) {
  body.classList.add(savedTheme);
} else {
  body.classList.add('light-mode');
}

function toggleSidebar() {
  closeAllDropdowns();
  const collapsed = sidebar.classList.toggle('collapsed');
  sidebarToggleIcon.classList.toggle('rotate', !collapsed);
}

function toggleDropdown(el) {
  if (!sidebar.classList.contains('collapsed')) {
    const parent = el.parentElement;
    closeAllDropdowns();
    parent.classList.toggle('open');
  }
}

function closeAllDropdowns() {
  document.querySelectorAll('.dropdown.open').forEach(dropdown => {
    dropdown.classList.remove('open');
  });
}

function selectItem(el, url) {
  const iframe = document.getElementById('contentFrame');
  iframe.classList.remove('loaded');
  iframe.src = url;

  const allLinks = document.querySelectorAll('.dropdown-menu a');
  allLinks.forEach(link => link.classList.remove('selected'));
  el.classList.add('selected');
}

document.getElementById('contentFrame').addEventListener('load', function () {
  this.classList.add('loaded');
});

function toggleTheme() {
  if (body.classList.contains('dark-mode')) {
    body.classList.remove('dark-mode');
    body.classList.add('light-mode');
    localStorage.setItem('theme', 'light-mode');
  } else {
    body.classList.remove('light-mode');
    body.classList.add('dark-mode');
    localStorage.setItem('theme', 'dark-mode');
  }
}

document.querySelectorAll('nav a').forEach(link => {
  link.addEventListener('click', function (e) {
    const ripple = document.createElement('span');
    ripple.classList.add('ripple-effect');
    ripple.style.position = 'absolute';
    ripple.style.width = ripple.style.height = '100px';
    ripple.style.left = e.offsetX + 'px';
    ripple.style.top = e.offsetY + 'px';
    ripple.style.background = 'var(--highlight-color)';
    ripple.style.borderRadius = '50%';
    ripple.style.transform = 'scale(0)';
    ripple.style.opacity = '0.5';
    ripple.style.animation = 'ripple 0.6s linear';
    this.appendChild(ripple);
    setTimeout(() => ripple.remove(), 600);
  });
});


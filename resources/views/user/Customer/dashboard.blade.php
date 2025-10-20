@extends('layouts.admin_dashboard2')

@section('content')
<div class="wrapper">

    <!-- Sidebar Overlay for Mobile -->
    <div id="sidebarOverlay" class="overlay"></div>

    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar collapsed">
        <div class="sidebar-header d-flex justify-content-between align-items-center px-3 py-2">
            
            <button id="closeSidebar" class="btn btn-sm d-md-none">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="profile-container text-center my-3">
            <img src="{{ Auth::user()->profile_picture ? asset('public/storage/' . Auth::user()->profile_picture) : asset('public/uploads/pics/default.png') }}" 
                 alt="Profile Picture" class="rounded-circle">
                
        </div>

        <ul class="nav flex-column" id="sidebarMenu"></ul>

        <div class="sidebar-footer mt-auto px-3 py-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-link logout-btn d-flex align-items-center gap-2">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="nav-label">Logout</span>
                </button>
            </form>
        </div>
    </nav>

    <!-- Content -->
    <div class="content">
        <div class="topbar d-flex justify-content-between align-items-center px-3 py-2">
            <button id="toggleSidebar" class="btn btn-sm">
                <i class="fas fa-bars"></i>
            </button>
            <button id="toggleTheme" class="btn btn-sm">Dark Mode</button>
        </div>
        <iframe id="contentFrame" src="{{ route('user.Customer.profile-account.index') }}"></iframe>
    </div>

</div>

<style>
/* ---------------- Body & Wrapper ---------------- */
body, html {
    margin: 0;
    height: 100%;
    width: 100%;
    overflow: hidden;
    font-family: 'Segoe UI', Roboto, sans-serif;
    transition: background-color 0.3s, color 0.3s;
    background-color: #f8f9fa;
    color: #212529;
}

.wrapper {
    display: flex;
    height: 100%;
}

/* ---------------- Sidebar ---------------- */
.sidebar {
    width: 290px;
    background-color: #ffffff;
    border-right: 1px solid #ddd;
    overflow-y: auto;
    transition: width 0.3s ease, transform 0.3s ease;
    display: flex;
    flex-direction: column;
    position: relative;
    z-index: 1000;
}

.sidebar.collapsed {
    width: 67px;
}

.sidebar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 1rem;
    border-bottom: 1px solid #dddddd00;
}

.user-name {
    font-weight: 600;
}

/* ---------------- Profile ---------------- */
.profile-container img {
 width: 55px;
 height: 55px;
 border-radius: 50%;
 object-fit: cover;
 border: 2px solid #007bff;
transition: transform 0.3s;
}
.profile-container img:hover {
transform: scale(1.05);
}
.user-name {
font-size: 0.9rem;
font-weight: 600;
color: #444;
}

/* ---------------- Menu ---------------- */
    /* ---------------- Menu ---------------- */
.nav-link {
display: flex;
align-items: center;
gap: 12px;
padding: 12px 18px;
text-decoration: none;
color: #212529;
font-size: 0.95rem;
cursor: pointer;
position: relative;
border-radius: 8px;
margin: 3px 2px;
transition: background 0.3s, color 0.3s;
}


.nav-link:hover,
.nav-link.active {
background: #007bff;
color: #fff;
}

.nav-icon {
    width: 25px;
    text-align: center;
}

.nav-label {
    transition: opacity 0.3s;
}

.sidebar.collapsed .nav-label {
    display: none;
}

/* ---------------- Footer ---------------- */
.sidebar-footer .logout-btn {
    width: 100%;
    justify-content: flex-start;
    gap: 10px;
    padding: 0.5rem 0;
    border: none;
    background: none;
    color: #212529;
    cursor: pointer;
}

.sidebar-footer .logout-btn i {
    font-size: 1rem;
}

/* ---------------- Content ---------------- */
.content {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    margin-left: 0; /* Ensure no space between sidebar and content */
    transition: none;
}

.topbar {
    background-color: #fff;
    border-bottom: 1px solid #ddd;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

iframe {
    flex-grow: 1;
    width: 100%;
    border: none;
}


/* ---------------- Dark Mode ---------------- */
body.dark-mode {
    background-color: #121212;
    color: #f1f1f1;

    i{
      color: #ffffff;
    }
    #toggleTheme{
      color: #ffffff;
    }
}

body.dark-mode .sidebar {
    background-color: #1a1a1a;
    border-right-color: #333;
}

body.dark-mode .nav-link {
    color: #f1f1f1;
}

body.dark-mode .nav-link:hover,
body.dark-mode .nav-link.active {
    background-color: #0056b3;
    color: #fff;
}

body.dark-mode .topbar {
    background-color: #1c1c1c;
    border-bottom-color: #333;
}

body.dark-mode .logout-btn {
    color: #fff;
}

/* ---------------- Mobile Overlay ---------------- */
#sidebarOverlay {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 998;
    opacity: 0;
    transition: opacity 0.3s ease;
}

#sidebarOverlay.show {
    display: block;
    opacity: 1;
}

/* ---------------- Responsive ---------------- */
@media (max-width: 576px) {
    .sidebar {
        position: fixed;
        left: -290px;
        width: 290px;
        height: 100%;
        transition: transform 0.3s ease;
    }

    .sidebar.show {
        transform: translateX(290px);
    }

    .sidebar.collapsed {
        width: 290px;
    }

    .sidebar.show .nav-label {
        display: inline;
    }

    .content {
        margin-left: 0 !important;
    }

    #closeSidebar {
        display: block !important;
    }
}

@media (min-width: 577px) {
    .sidebar.collapsed ~ .content {
        margin-left: 0; /* Keep no space */
    }
}

.sidebar.hover-expand {
  width: 290px;
}

.sidebar.hover-expand .nav-label {
  display: inline;
}

</style>

<script>
const sidebar = document.getElementById("sidebar");
const toggleBtn = document.getElementById("toggleSidebar");
const closeBtn = document.getElementById("closeSidebar");
const overlay = document.getElementById("sidebarOverlay");
const iframe = document.getElementById("contentFrame");
const toggleTheme = document.getElementById("toggleTheme");
const menu = document.getElementById("sidebarMenu");

// Load theme from localStorage
if(localStorage.getItem('theme') === 'dark') document.body.classList.add('dark-mode');

// Theme toggle
toggleTheme.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('theme', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
});

// Sidebar toggle
toggleBtn.addEventListener('click', () => {
    if(window.innerWidth > 576) {
        sidebar.classList.toggle('collapsed');
    } else {
        sidebar.classList.add('show');
        overlay.classList.add('show');
    }
});

// Close sidebar on mobile
closeBtn.addEventListener('click', () => {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
});

overlay.addEventListener('click', () => {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
});

// Handle resizing
window.addEventListener('resize', () => {
    if(window.innerWidth > 576){
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    }
});

// Select menu item
function selectItem(element, url){
    document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
    element.classList.add('active');
    iframe.src = url;
    if(window.innerWidth <= 576){
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    }
}

// Expand sidebar on hover
sidebar.addEventListener("mouseenter", () => {
  if (sidebar.classList.contains("collapsed") && window.innerWidth > 576) {
    sidebar.classList.add("hover-expand");
  }
});
sidebar.addEventListener("mouseleave", () => {
  if (sidebar.classList.contains("collapsed") && window.innerWidth > 576) {
    sidebar.classList.remove("hover-expand");
  }
});


// Create menu dynamically with title
function createNavButton(label, icon, title, url){
    const li = document.createElement('li');
    li.innerHTML = `<a onclick="selectItem(this,'${url}')" class="nav-link" title="${title}">
        <span class="nav-icon"><i class="${icon}"></i></span>
        <span class="nav-label">${label}</span>
    </a>`;
    menu.appendChild(li);
}




createNavButton('My Profile','fa-solid fa-gears','My Profile','{{ route("user.Customer.profile-account.index") }}');

createNavButton('Messages','fa-solid fa-envelope','Messages','{{ route("user.Customer.messages.index") }}');

createNavButton('Categories','fa-solid fa-folder','Product Categories','{{ route("user.Customer.categories.index") }}');


createNavButton('Products','fa-solid fa-box','Browse Products','{{ route("user.Customer.products.index") }}');

createNavButton('Orders','fa-solid fa-cart-shopping','My Orders','{{ route("user.Customer.orders.index") }}');

createNavButton('Order Items','fa-solid fa-box-check','My Order Items','{{ route("user.Customer.order-items.index") }}');





// Auto-select first menu item
setTimeout(()=>{
    const firstLink = document.querySelector('.nav-link');
    if(firstLink) firstLink.click();
},100);
</script>

@endsection

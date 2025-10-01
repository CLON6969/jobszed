@extends('layouts.admin_dashboard2')

@section('content')
<div class="wrapper">

    <!-- Sidebar Overlay for Mobile -->
    <div id="sidebarOverlay" class="overlay"></div>

    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar collapsed">
        <div class="sidebar-header d-flex justify-content-between align-items-center px-3 py-2">
            <button id="closeSidebar" class="btn btn-sm d-md-none" title="logout">
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
        <iframe id="contentFrame" src="{{ route('admin.admin.job_user_summary') }}"></iframe>
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
    width: 78px;
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

/* Arrow rotation */
.nav-link .fa-chevron-down {
    transition: transform 0.3s ease;
}
.nav-link.active-arrow .fa-chevron-down {
    transform: rotate(180deg);
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

// Theme persistence
if(localStorage.getItem('theme') === 'dark') document.body.classList.add('dark-mode');
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
closeBtn.addEventListener('click', () => {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
});
overlay.addEventListener('click', () => {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
});
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

// Hover expand
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

// Create button
function createNavButton(label, icon, title, url){
    const li = document.createElement('li');
    li.innerHTML = `<a onclick="selectItem(this,'${url}')" class="nav-link" title="${title}">
        <span class="nav-icon"><i class="${icon}"></i></span>
        <span class="nav-label">${label}</span>
    </a>`;
    menu.appendChild(li);
}

// Create dropdown
function createDropdown(label, icon, title, items) {
    const li = document.createElement('li');
    li.classList.add("dropdown");

    const dropdownId = `dropdown-${label.replace(/\s+/g,'-')}`;

    let html = `
      <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#${dropdownId}" 
         role="button" aria-expanded="false" aria-controls="${dropdownId}" title="${title}">
        <span class="d-flex align-items-center gap-2">
          <span class="nav-icon"><i class="${icon}"></i></span>
          <span class="nav-label">${label}</span>
        </span>
        <i class="fas fa-chevron-down small"></i>
      </a>
      <ul class="collapse list-unstyled ps-4" id="${dropdownId}">
    `;

    function buildItems(items) {
        let innerHTML = '';
        items.forEach(item => {
            if (item.children && item.children.length > 0) {
                const childId = `dropdown-${item.label.replace(/\s+/g,'-')}`;
                innerHTML += `
                  <li class="dropdown-submenu mt-2">
                    <a class="nav-link d-flex justify-content-between align-items-center small" data-bs-toggle="collapse" href="#${childId}" 
                       role="button" aria-expanded="false" aria-controls="${childId}">
                      <span>${item.label}</span>
                      <i class="fas fa-chevron-down small"></i>
                    </a>
                    <ul class="collapse list-unstyled ps-3" id="${childId}">
                        ${buildItems(item.children)}
                    </ul>
                  </li>
                `;
            } else {
                innerHTML += `
                  <li>
                    <a onclick="selectItem(this,'${item.url}')" class="nav-link small">
                      <span class="nav-label">${item.label}</span>
                    </a>
                  </li>
                `;
            }
        });
        return innerHTML;
    }

    html += buildItems(items);
    html += "</ul>";
    li.innerHTML = html;
    menu.appendChild(li);
}

// Accordion + arrow toggle
document.addEventListener("click", function (e) {
    const toggle = e.target.closest("[data-bs-toggle='collapse']");
    if (!toggle) return;

    const targetId = toggle.getAttribute("href") || toggle.getAttribute("data-bs-target");
    if (!targetId) return;
    const targetCollapse = document.querySelector(targetId);
    if (!targetCollapse) return;

    const parentUl = toggle.closest("ul");
    if (!parentUl) return;

    // Close siblings
    parentUl.querySelectorAll(".collapse.show").forEach(openDropdown => {
        if (openDropdown !== targetCollapse) {
            openDropdown.classList.remove("show");
            const sibToggle = parentUl.querySelector(`[href="#${openDropdown.id}"], [data-bs-target="#${openDropdown.id}"]`);
            if (sibToggle) sibToggle.classList.remove("active-arrow");
        }
    });

    // Toggle arrow
    toggle.classList.toggle("active-arrow");
});

// Reset arrow when hidden
document.addEventListener("hidden.bs.collapse", function (e) {
    const toggle = document.querySelector(`[href="#${e.target.id}"], [data-bs-target="#${e.target.id}"]`);
    if (toggle) toggle.classList.remove("active-arrow");
});

// Menu items
createNavButton('Dashboard','fas fa-tachometer-alt','Dashboard','{{ route('admin.admin.job_user_summary') }}');
createNavButton('Jobs', 'fas fa-briefcase', 'Jobs', '{{ route("admin.web.job.index") }}');
createNavButton('Applications', 'fas fa-file-alt', 'Applications', '{{ route('admin.web.applications.index') }}');
createNavButton('Applicant Email', 'fas fa-calendar-alt', 'Applicant Email', '{{ route("admin.web.Email_application_management.index", 1) }}');

createDropdown('Web Settings', 'fas fa-globe', 'Web Settings', [
  {
    label: 'General',
    children: [
       { label: 'Nav links', url: '{{ route('admin.web.general.nav1.index') }}' },
       { label: 'Socials', url: '{{ route('admin.web.general.socials.index') }}' },
       { label: 'Logo', url: '{{ route('admin.web.general.logo.index') }}' },
       { 
        label: 'Footer', 
        children: [
            { label: 'Footer Titles', url: '{{ route('admin.web.general.footer.titles.index') }}' },
            { label: 'Footer Items', url: '{{ route('admin.web.general.footer.items.index') }}' },
        ]
      }
    ]
  },
  {
    label: 'Home-page',
    children: [
      { label: 'Landing Page', url: '{{ route('admin.web.homepage.content.edit') }}' },
      { label: 'Table 1', url: '{{ route('admin.web.homepage.table.index') }}' },
      { label: 'Table 2', url: '{{ route('admin.web.opportunities.index') }}' },
    ]
  },
  {
    label: 'About-page',
    children: [
     { label: 'About page', url: '{{ route('admin.web.about.edit') }}' },
     { label: 'About Table', url: '{{ route('admin.web.about.table.index') }}' },
     { label: 'Company statements', url: '{{ route('admin.web.homepage.statements.index') }}' },
    ]
  }
]);

createNavButton('My Profile','fa-solid fa-gears','My Profile','{{ route("admin.profile-account.index") }}');

// Auto-select first
setTimeout(()=>{
    const firstLink = document.querySelector('.nav-link');
    if(firstLink) firstLink.click();
},100);
</script>
@endsection

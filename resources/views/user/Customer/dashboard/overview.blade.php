
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7f9;
            margin: 0;
            padding: 0;
            transition: background-color 0.3s;
        }

        body.dark-mode {
            background-color: #1a1d21;
            color: #e4e6eb;
        }

        .dashboard-container {
            padding: 20px;
        }

        /* Stats Cards */
        .stats-container {
            margin-bottom: 20px;
        }

        .stat-card {
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h6 {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        body.dark-mode .stat-card h6 {
            color: #a0a4a8;
        }

        .stat-card h5 {
            font-size: 1.8rem;
            font-weight: bold;
            margin: 0;
        }

        /* Navigation Menu Styles */
        .nav-menu {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .nav-menu-item {
            padding: 8px 16px;
            border-radius: 5px;
            background-color: #f8f9fa;
            color: var(--secondary-color);
            text-decoration: none;
            transition: all 0.3s;
            cursor: pointer;
            border: 1px solid #dee2e6;
        }

        .nav-menu-item:hover, .nav-menu-item.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        body.dark-mode .nav-menu-item {
            background-color: #2a2c31;
            color: #e4e6eb;
            border-color: #444;
        }

        body.dark-mode .nav-menu-item:hover, 
        body.dark-mode .nav-menu-item.active {
            background-color: var(--primary-color);
            color: white;
        }

        /* Iframe Container */
        .iframe-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            height: 75vh;
        }

        body.dark-mode .iframe-card {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        #contentFrame {
            width: 100%;
            height: 100%;
            border: none;
            background: white;
        }

        body.dark-mode #contentFrame {
            background: #242526;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .stats-container .col-md-2 {
                flex: 0 0 33.333333%;
                max-width: 33.333333%;
                margin-bottom: 15px;
            }
            
            .nav-menu {
                gap: 8px;
            }
            
            .nav-menu-item {
                padding: 6px 12px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 768px) {
            .stats-container .col-md-2 {
                flex: 0 0 50%;
                max-width: 50%;
            }
            
            .iframe-card {
                height: 70vh;
            }
            
            .nav-menu {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .stats-container .col-md-2 {
                flex: 0 0 100%;
                max-width: 100%;
            }
            
            .nav-menu .nav-link {
                padding: 8px 12px;
                font-size: 0.9rem;
            }
            
            .nav-menu {
                flex-direction: column;
                gap: 5px;
            }
            
            .nav-menu-item {
                text-align: center;
            }

              #navMenu {
              display: none;
            }
        }


        
    </style>
</head>
<body>
    <div class="dashboard-container">

        <!-- Stats Cards -->
<div class="stats-container">
    <div class="row">
        <!-- Jobs Applied -->
        <div class="col-md-2 col-6">
            <div class="card stat-card shadow-sm mb-3 border-start border-darkblue border-4" >
                <div class="card-body text-center">
                    <h6 class="text-darkblue" style="color:#0F172A;">Jobs Applied</h6>
                    <h5 class="fw-bold">{{ $jobsApplied }}</h5>
                </div>
            </div>
        </div>

        <!-- Submitted Applications -->
        <div class="col-md-2 col-6">
            <div class="card stat-card shadow-sm mb-3 border-start border-teal border-4 "  ">
                <div class="card-body text-center">
                    <h6 class="text-teal" style="color:#06a960;">Submitted Applications</h6>
                    <h5 class="fw-bold">{{ $submittedApplications }}</h5>
                </div>
            </div>
        </div>


        <!-- Shortlisted Applications -->
        <div class="col-md-2 col-6">
            <div class="card stat-card shadow-sm mb-3 bg-primary text-white">
                <div class="card-body text-center">
                    <h6 class="text-white">Shortlisted</h6>
                    <h5 class="fw-bold">{{ $shortlistedApplications }}</h5>
                </div>
            </div>
        </div>

        <!-- Accepted Applications -->
        <div class="col-md-2 col-6">
            <div class="card stat-card shadow-sm mb-3 bg-success text-white">
                <div class="card-body text-center">
                    <h6 class="text-white">Accepted</h6>
                    <h5 class="fw-bold">{{ $acceptedApplications }}</h5>
                </div>
            </div>
        </div>

        <!-- Rejected Applications -->
        <div class="col-md-2 col-6">
            <div class="card stat-card shadow-sm mb-3 bg-danger text-white">
                <div class="card-body text-center">
                    <h6 class="text-white">Rejected</h6>
                    <h5 class="fw-bold">{{ $rejectedApplications }}</h5>
                </div>
            </div>
        </div>

        <!-- Interview Applications -->
        <div class="col-md-2 col-6">
            <div class="card stat-card shadow-sm mb-3 bg-warning text-dark">
                <div class="card-body text-center">
                    <h6 class="text-dark">Interviews</h6>
                    <h5 class="fw-bold">{{ $interviewApplications }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>


        <!-- Navigation Menu -->
        <div class="nav-menu mb-4" id="navMenu">
            <!-- Navigation items will be dynamically added here -->
        </div>

        <!-- Iframe Container -->
        <div class="iframe-card shadow-sm">
            <iframe id="contentFrame" src="{{ route('user.applicant.overviews.index') }}"></iframe>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // DOM Elements
        const iframe = document.getElementById("contentFrame");
        const navMenu = document.getElementById("navMenu");

        function selectItem(element, url) {
            iframe.src = url;
            document.querySelectorAll(".nav-menu-item").forEach(item => item.classList.remove("active"));
            element.classList.add("active");
        }

        function createNavButton(label, icon, url) {
            const button = document.createElement('a');
            button.className = 'nav-menu-item';
            button.innerHTML = `<i class="${icon}"></i> ${label}`;
            button.addEventListener('click', () => selectItem(button, url));
            navMenu.appendChild(button);
            
            // Set first button as active by default
            if (navMenu.children.length === 1) {
                button.classList.add('active');
            }
            
            return button;
        }

        // Create navigation buttons
        createNavButton('Overview', 'fas fa-street-view', '{{ route('user.applicant.overviews.index') }}');
       createNavButton('personal', 'fa-solid fa-id-card', '{{ route('user.applicant.profiles.edit', $profile) }}');
        createNavButton('Certifications', 'fas fa-certificate', '{{ route('user.applicant.certifications.index') }}');
        createNavButton('Educations', 'fas fa-graduation-cap', '{{ route('user.applicant.educations.index') }}');
        createNavButton('Experiences', 'fas fa-briefcase', '{{ route('user.applicant.experiences.index') }}');
        createNavButton('Locations', 'fas fa-map-marker-alt', '{{ route('user.applicant.locations.index') }}');
        createNavButton('Voluntary Disclosures', 'fas fa-user-shield', '{{ route('user.applicant.voluntary_disclosures.edit') }}');
    </script>
</body>
</html>

@extends('layouts.home')

@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            overflow-x: hidden;
            color: #333;
        }

        /* Modern Navbar Styles */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #1a73e8;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
        }

        .logo-img {
            height: 40px;
            width: auto;
            object-fit: contain;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            padding: 10px 0;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: #1a73e8;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #1a73e8;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-cta {
            background: #1a73e8;
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-cta:hover {
            background: #0d62d9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 115, 232, 0.3);
        }

        .hamburger {
            display: none;
            cursor: pointer;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #1a73e8;
        }

        /* Hero Slider Styles */
        .hero-slider {
            position: relative;
            height: 100vh;
            overflow: hidden;
        }

        .slider-container {
            position: relative;
            height: 100%;
            width: 100%;
        }

        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 10%;
            opacity: 0;
            transition: opacity 0.8s ease;
        }

        .slide.active {
            opacity: 1;
        }

        /* Individual parallax backgrounds for each slide */
        .slide-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            transition: opacity 1.2s ease-in-out;
        }

        .slide-bg::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(26, 115, 232, 0.85) 0%, rgba(13, 71, 161, 0.75) 100%);
        }

        .slide-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .slide-text {
            max-width: 600px;
            color: white;
            z-index: 2;
        }

        .slide-text h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.1;
            transform: translateY(30px);
            opacity: 0;
            transition: all 0.8s ease;
        }

        .slide-text h2 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #bbdefb;
            transform: translateY(30px);
            opacity: 0;
            transition: all 0.8s ease 0.2s;
        }

        .slide-text p {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            color: #e3f2fd;
            transform: translateY(30px);
            opacity: 0;
            transition: all 0.8s ease 0.4s;
        }

        .buttons {
            display: flex;
            gap: 1rem;
            transform: translateY(30px);
            opacity: 0;
            transition: all 0.8s ease 0.6s;
        }

        .btn-light, .btn-dark {
            display: inline-flex;
            align-items: center;
            padding: 12px 28px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-light {
            background: white;
            color: #1a73e8;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .btn-light:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.25);
            background: #e3f2fd;
        }

        .btn-dark {
            background: rgba(255,255,255,0.15);
            color: white;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .btn-dark:hover {
            background: rgba(255,255,255,0.25);
            transform: translateY(-3px);
        }

        .slide.active .fade-up {
            transform: translateY(0);
            opacity: 1;
        }

        .slide-image {
            position: relative;
            max-width: 500px;
            transform: translateX(30px);
            opacity: 0;
            transition: all 0.8s ease 0.3s;
        }

        .slide.active .slide-image {
            transform: translateX(0);
            opacity: 1;
        }

        .slide-image img {
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .floating-card {
            position: absolute;
            bottom: -30px;
            right: -30px;
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            max-width: 250px;
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.6s ease 0.8s;
            border-left: 4px solid #1a73e8;
        }

        .slide.active .floating-card {
            transform: translateY(0);
            opacity: 1;
        }

        .floating-card h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: #1a73e8;
        }

        .floating-card p {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.5;
        }

        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.2);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            z-index: 10;
        }

        .nav-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-50%) scale(1.1);
        }

        .prev {
            left: 30px;
        }

        .next {
            right: 30px;
        }

        .pagination {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 10;
        }

        .pagination span {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255,255,255,0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .pagination span.active {
            background: white;
            transform: scale(1.2);
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .nav-menu {
                position: fixed;
                top: 70px;
                right: -100%;
                flex-direction: column;
                background: white;
                width: 80%;
                max-width: 300px;
                height: calc(100vh - 70px);
                padding: 2rem;
                box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
                transition: right 0.3s ease;
                gap: 0;
            }

            .nav-menu.active {
                right: 0;
            }

            .nav-item {
                margin: 1rem 0;
            }

            .nav-link {
                padding: 15px 0;
                display: block;
                border-bottom: 1px solid #f0f0f0;
            }

            .nav-cta {
                margin-top: 1rem;
                text-align: center;
                display: block;
            }

            .hamburger {
                display: block;
            }

            .slide {
                flex-direction: column;
                justify-content: center;
                text-align: center;
                padding: 0 5%;
            }

            .slide-text {
                margin-bottom: 3rem;
            }

            .slide-text h1 {
                font-size: 2.8rem;
            }

            .slide-text h2 {
                font-size: 1.5rem;
            }

            .slide-image {
                max-width: 400px;
            }

            .floating-card {
                right: 0;
                bottom: -50px;
            }
        }

        @media (max-width: 576px) {
            .slide-text h1 {
                font-size: 2.2rem;
            }

            .slide-text h2 {
                font-size: 1.3rem;
            }

            .buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn-light, .btn-dark {
                width: 100%;
                max-width: 250px;
                justify-content: center;
            }

            .slide-image {
                max-width: 300px;
            }

            .floating-card {
                max-width: 200px;
                padding: 1rem;
            }

            .nav-btn {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }

            .prev {
                left: 15px;
            }

            .next {
                right: 15px;
            }

            .nav-container {
                padding: 0 15px;
            }
        }
    </style>

    <!-- Modern Responsive Navbar -->


    <!-- HERO SLIDER -->
    <section class="hero-slider">
        <div class="slider-container">

            <!-- Slide 1 -->
            <div class="slide active">
                <div class="slide-bg">
                    <img src="{{ asset('/public/uploads/pics/42.jpg') }}" 
                         alt="Digital Transformation Background" loading="lazy">
                </div>
                <div class="slide-text">
                    <h1 class="fade-up">Transform Your Digital Experience</h1>
                    <h2 class="fade-up delay1">Innovative Solutions for Modern Businesses</h2>
                    <p class="fade-up delay2">We create stunning digital experiences that captivate your audience and drive results. Our team of experts delivers cutting-edge solutions tailored to your needs.</p>

                    <div class="buttons fade-up delay3">
                        <a class="btn-light" href="#services">
                            <i class="fas fa-plus mr-2"></i> Explore Services
                        </a>
                        <a class="btn-dark" href="#contact">
                            Get Started
                        </a>
                    </div>
                </div>

                <div class="slide-image fade-in">
                    <img src="{{ asset('/public/uploads/pics/42.jpg') }}" 
                         alt="Digital Transformation" loading="lazy">
                    <div class="floating-card">
                        <h3>Why Choose Us?</h3>
                        <p>Over 10 years of experience delivering exceptional results for clients worldwide.</p>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="slide">
                <div class="slide-bg">
                    <img src="{{ asset('/public/uploads/pics/100.jpg') }}" 
                         alt="Brand Elevation Background" loading="lazy">
                </div>
                <div class="slide-text">
                    <h1 class="fade-up">Elevate Your Brand</h1>
                    <h2 class="fade-up delay1">Creative Design & Strategic Marketing</h2>
                    <p class="fade-up delay2">Our comprehensive approach combines beautiful design with data-driven strategies to elevate your brand and maximize your online presence.</p>

                    <div class="buttons fade-up delay3">
                        <a class="btn-light" href="#portfolio">
                            View Portfolio
                        </a>
                        <a class="btn-dark" href="#contact">
                            Contact Us
                        </a>
                    </div>
                </div>

                <div class="slide-image fade-in">
                    <img src="{{ asset('/public/uploads/pics/100.jpg') }}" 
                         alt="Brand Elevation" loading="lazy">
                    <div class="floating-card">
                        <h3>Our Approach</h3>
                        <p>We combine creativity with analytics to deliver measurable results for your business.</p>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="slide">
                <div class="slide-bg">
                    <img src="{{ asset('/public/uploads/pics/233.jpg') }}" 
                         alt="Technology Solutions Background" loading="lazy">
                </div>
                <div class="slide-text">
                    <h1 class="fade-up">Future-Proof Solutions</h1>
                    <h2 class="fade-up delay1">Scalable Technology for Growing Businesses</h2>
                    <p class="fade-up delay2">Build a digital foundation that grows with your business. Our future-proof solutions ensure your technology scales as your needs evolve.</p>

                    <div class="buttons fade-up delay3">
                        <a class="btn-light" href="#technology">
                            <i class="fas fa-cogs mr-2"></i> Our Technology
                        </a>
                        <a class="btn-dark" href="#contact">
                            Schedule a Demo
                        </a>
                    </div>
                </div>

                <div class="slide-image fade-in">
                    <img src="{{ asset('/public/uploads/pics/233.jpg') }}" 
                         alt="Technology Solutions" loading="lazy">
                    <div class="floating-card">
                        <h3>Our Promise</h3>
                        <p>We deliver scalable solutions that adapt to your evolving business needs.</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Arrows -->
            <button class="nav-btn prev">&#10094;</button>
            <button class="nav-btn next">&#10095;</button>

            <!-- Pagination Dots -->
            <div class="pagination"></div>
        </div>
    </section>

<script>
    // Navbar functionality
    const navbar = document.querySelector('.navbar');
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');

    hamburger.addEventListener('click', () => {
        navMenu.classList.toggle('active');
        hamburger.innerHTML = navMenu.classList.contains('active') 
            ? '<i class="fas fa-times"></i>' 
            : '<i class="fas fa-bars"></i>';
    });

    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('active');
            hamburger.innerHTML = '<i class="fas fa-bars"></i>';
        });
    });

    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 50);
    });

    // Slider functionality
    const slides = document.querySelectorAll(".slide");
    const prevBtn = document.querySelector(".prev");
    const nextBtn = document.querySelector(".next");
    const pagination = document.querySelector(".pagination");
    let index = 0;
    let autoPlayInterval;
    let isTabActive = true;

    // Pagination dots
    slides.forEach((_, i) => {
        const dot = document.createElement("span");
        if(i === 0) dot.classList.add("active");
        pagination.appendChild(dot);
        dot.addEventListener("click", () => { 
            index = i; 
            showSlide(index); 
            stopAutoPlay();
        });
    });
    const dots = document.querySelectorAll(".pagination span");

    function showSlide(n){
        slides.forEach((slide, i) => slide.classList.toggle("active", i === n));
        dots.forEach((dot, i) => dot.classList.toggle("active", i === n));
    }

    prevBtn.addEventListener("click", () => { 
        index = (index - 1 + slides.length) % slides.length; 
        showSlide(index); 
        stopAutoPlay();
    });

    nextBtn.addEventListener("click", () => { 
        index = (index + 1) % slides.length; 
        showSlide(index); 
        stopAutoPlay();
    });

    function startAutoPlay(){
        stopAutoPlay();
        autoPlayInterval = setInterval(() => { 
            index = (index + 1) % slides.length; 
            showSlide(index); 
        }, 3000); // Slide change every 4 seconds
    }

    function stopAutoPlay(){
        clearInterval(autoPlayInterval);
    }

    // Pause on hover
    const sliderContainer = document.querySelector('.slider-container');
    sliderContainer.addEventListener('mouseenter', stopAutoPlay);
    sliderContainer.addEventListener('mouseleave', () => { if(isTabActive) startAutoPlay(); });

    // Pause/resume on tab visibility
    document.addEventListener('visibilitychange', () => {
        if(document.hidden) { stopAutoPlay(); isTabActive = false; }
        else { startAutoPlay(); isTabActive = true; }
    });

    // Initialize
    showSlide(index);
    startAutoPlay();
</script>



@endsection
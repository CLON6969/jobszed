@extends('layouts.home')

@section('content')
<!-- HERO SLIDER -->
<section class="hero-slider">
  <div class="parallax-bg"></div> <!-- Parallax background -->

  <div class="slider-container">

    <!-- Slide 1 -->
    <div class="slide active">
      <div class="slide-text">
        <h1 class="fade-up">{{ $home->title1 }}</h1>
        <h2 class="fade-up delay1">{{ $home->title1_content }}</h2>
        <p class="fade-up delay2">{{ $home->title1_sub_content }}</p>

        <div class="buttons fade-up delay3">
          <a class="btn-light" href="{{$home->button1_url}}">
            <i class="fas fa-plus mr-2"></i> {{$home->button1_name}}
          </a>
          <a class="btn-dark" href="{{$home->button2_url}}">
            {{$home->button2_name}}
          </a>
        </div>
      </div>

      <div class="slide-image fade-in">
        <img src="{{ asset('public/storage/uploads/pics/' . $home->background_picture) }}" 
             srcset="{{ asset('public/storage/uploads/pics/' . $home->background_picture) }} 1x, 
                     {{ asset('public/storage/uploads/pics/' . $home->background_picture) }} 2x"
             alt="Slide Image" loading="lazy">
        <div class="floating-card">
          <h3>{{ $home->title2 }}</h3>
          <p>{{ $home->title2_content }}</p>
        </div>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="slide">
      <div class="slide-text">
        <h1 class="fade-up">{{ $home->title3 }}</h1>
        <h2 class="fade-up delay1">{{ $home->title3_content }}</h2>
        <p class="fade-up delay2">{{ $home->title3_sub_content }}</p>

        <div class="buttons fade-up delay3">
          <a class="btn-light" href="{{$home->button3_url}}">
            {{$home->button3_name}}
          </a>
          <a class="btn-dark" href="{{$home->button4_url}}">
            {{$home->button4_name}}
          </a>
        </div>
      </div>

      <div class="slide-image fade-in">
        <img src="{{ asset('public/storage/uploads/pics/' . $home->background_picture2) }}" 
             alt="Slide Image" loading="lazy">
        <div class="floating-card">
          <h3>{{$home->title4}}</h3>
          <p>{{$home->title4_content}}</p>
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


<!-- =========================
     JS
========================= -->
<script>
const slides = document.querySelectorAll(".slide");
const prevBtn = document.querySelector(".prev");
const nextBtn = document.querySelector(".next");
const pagination = document.querySelector(".pagination");
let index = 0;
let autoPlayInterval;

// Create pagination dots
slides.forEach((_, i) => {
  const dot = document.createElement("span");
  if(i === 0) dot.classList.add("active");
  pagination.appendChild(dot);
  dot.addEventListener("click", () => { 
    index = i; 
    showSlide(index); 
    stopAutoPlay(); // stop auto-play on click
  });
});
const dots = document.querySelectorAll(".pagination span");

function showSlide(n){
  slides.forEach((slide, i) => slide.classList.toggle("active", i===n));
  dots.forEach((dot, i) => dot.classList.toggle("active", i===n));
}

prevBtn.addEventListener("click", () => { 
  index = (index-1+slides.length)%slides.length; 
  showSlide(index); 
  stopAutoPlay(); // stop auto-play on click
});

nextBtn.addEventListener("click", () => { 
  index = (index+1)%slides.length; 
  showSlide(index); 
  stopAutoPlay(); // stop auto-play on click
});

// Auto-play
function startAutoPlay(){
  autoPlayInterval = setInterval(() => { 
    index=(index+1)%slides.length; 
    showSlide(index); 
  }, 4000);
}

function stopAutoPlay(){
  clearInterval(autoPlayInterval);
}

// Start auto-play initially
startAutoPlay();

showSlide(index);
</script>












<section class="relative w-full bg-black py-28">
  <div class="max-w-7xl mx-auto px-6 md:px-12 lg:px-16">
    
    <!-- Hero Text -->
    <div class="text-center max-w-4xl mx-auto mb-20" data-aos="fade-up" data-aos-duration="800">
      <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-blue-800 leading-tight mb-6">
        {{ $home->title1 }}
      </h1>
      <p class="text-gray-400 text-lg sm:text-xl lg:text-2xl leading-relaxed text-justify">
        {{ $home->title4_sub_content }}
      </p>
    </div>

    <!-- Layout -->
    <div class="grid lg:grid-cols-3 gap-14 items-center">
      
      <!-- Features -->
      <div class="order-2 lg:order-1 flex flex-col gap-8" data-aos="fade-right" data-aos-duration="1000">
        @foreach($home_table1 as $table)
        <div class="feature group cursor-pointer p-6 rounded-2xl border border-gray-200 bg-gray-300 shadow-sm hover:shadow-2xl hover:border-indigo-500 transition-all duration-300"
             data-image="{{ asset('/public/storage/uploads/pics/' . $table->picture) }}">
          <div class="flex items-start gap-5">
            <!-- Icon -->
            <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 text-xl font-bold group-hover:bg-indigo-100">
              <i class="fas fa-heart"></i>
            </div>
            <div>
              <h4 class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-indigo-800">
                {{ $table->title1 }}
              </h4>
              <p class="text-sm text-gray-600 mb-2 leading-relaxed text-justify">
                {{ $table->title1_content }}
              </p>
              <small class="text-xs text-gray-400 italic">
                {{ $table->title1_small_text }}
              </small>
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <!-- Main Image -->
      <div class="order-1 lg:order-2 flex justify-center" data-aos="zoom-in" data-aos-duration="1200">
        <div class="w-full max-w-lg aspect-[4/3] rounded-3xl overflow-hidden   ring-gray-200">
          <img src="" alt="picture" id="main-image"
            class="w-full h-full object-cover transition-opacity duration-500 fade-out rounded-3xl" />
        </div>
      </div>

      <!-- Empty Spacer -->
      <div class="hidden lg:block"></div>
    </div>
  </div>
</section>

<!-- Fade Animation -->
<style>
  .fade-out {
    opacity: 0;
    transition: opacity 0.4s ease-in-out;
  }
</style>

<script>
  AOS.init(); // Initialize scroll animations

  const features = document.querySelectorAll('.feature');
  const mainImage = document.getElementById('main-image');

  let currentIndex = 0;
  let autoSlide = true;
  let slideInterval;

  function activateFeature(index) {
    const feature = features[index];
    const image = feature.getAttribute('data-image');

    mainImage.classList.add('fade-out');

    setTimeout(() => {
      mainImage.src = image;
      mainImage.classList.remove('fade-out');
    }, 400);

    features.forEach(f => f.classList.remove('ring-2', 'ring-indigo-500', 'bg-indigo-50'));
    feature.classList.add('ring-2', 'ring-indigo-500', 'bg-indigo-50');
  }

  function startSlideshow() {
    slideInterval = setInterval(() => {
      if (!autoSlide) return;
      currentIndex = (currentIndex + 1) % features.length;
      activateFeature(currentIndex);
    }, 4000);
  }

  features.forEach((feature, index) => {
    feature.addEventListener('click', function () {
      autoSlide = false;
      activateFeature(index);
    });
  });

  activateFeature(currentIndex);
  startSlideshow();
</script>

<!-- Font Awesome for icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>





  




<div class="opportunities-container">
  @foreach($opportunities as $index => $opportunity)
    <section class="opportunity-card" onclick="openOverlay('overlay-{{ $opportunity->id }}')">
      <img src="{{ asset('/public/storage/opportunities/' . $opportunity->image) }}" class="bg" alt="background picture">
      <div class="overlay">
        <div class="content">
          <h2>{{ $opportunity->title }}</h2>
          <p>{{ $opportunity->summary }}</p>
          <a href="#" class="read-more">Read more</a>
        </div>
      </div>
    </section>
  @endforeach
</div>

@foreach($opportunities as $opportunity)
  <div id="overlay-{{ $opportunity->id }}" class="fullscreen-overlay">
    <div class="overlay-inner" style="background-image: url('{{ asset('/public/storage/opportunities/' . $opportunity->image) }}');">
      <button onclick="closeOverlay()" class="close-btn">&times;</button>
      <div class="overlay-text">
        <h2>{{ $opportunity->title }}</h2>
        <p>{{ $opportunity->overlay_intro }}</p>
        <div class="more-content">
          <p>{{ $opportunity->overlay_details }}</p>
        </div>
        <button class="expand-btn" onclick="event.stopPropagation(); toggleMore(this)">Read more</button>
      </div>
    </div>
  </div>
@endforeach


 <!-- this is for full screen overlay when clicked -->
<script>
let scrollPosition = 0;

function openOverlay(id) {
  // Save current scroll position
  scrollPosition = window.scrollY || document.documentElement.scrollTop;

  // Lock scrolling by fixing the body
  document.body.style.position = 'fixed';
  document.body.style.top = `-${scrollPosition}px`;
  document.body.style.width = '100%';

  // Show overlay
  document.getElementById(id).classList.add('active');
}

function closeOverlay() {
  document.querySelectorAll('.fullscreen-overlay').forEach(el => el.classList.remove('active'));

  // Restore body scroll
  document.body.style.position = '';
  document.body.style.top = '';
  document.body.style.width = '';
  window.scrollTo(0, scrollPosition); // Return to saved scroll position
}

function toggleMore(button) {
  const moreContent = button.previousElementSibling;
  moreContent.classList.toggle('active');
  button.textContent = moreContent.classList.contains('active') ? 'Show less' : 'Read more';
}
</script>


  

 <!-- this gets -->

 <style>
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out both;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

@endsection

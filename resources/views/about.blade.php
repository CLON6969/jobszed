@extends('layouts.about')

@section('content')

<!-- ================= HERO SECTION ================= -->
<section class="hero relative h-[100vh] flex items-center justify-center overflow-hidden">
  <!-- Background -->
  <img src="{{ asset('/public/storage/uploads/pics/' . $about->background_picture) }}" 
       class="absolute inset-0 w-full h-full object-cover brightness-75 scale-105 animate-[zoomIn_18s_ease-in-out_infinite]" 
       alt="background picture">

  <!-- Overlay -->
  <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/30 to-black/70 rounded-2xl"></div>

  <!-- Content -->
  <div class="relative z-10 text-center text-white px-6 max-w-4xl mx-auto" data-aos="fade-up" data-aos-once="false">
    <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight mb-6 drop-shadow-xl">
      {{ $about->title1 }}
    </h1>
    <p class="max-w-2xl mx-auto text-lg md:text-xl opacity-90 leading-relaxed">
      {{ $about->title1_content }}
    </p>
    <a href="#about-section" 
       class="mt-10 inline-block bg-gradient-to-r from-blue-600 to-indigo-600 hover:opacity-90 
              text-white px-8 py-4 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105">
      <i class="fas fa-arrow-down mr-2"></i> Explore More
    </a>
  </div>
</section>

<!-- ================= SECTION 1 ================= -->
<section id="about-section" class="py-20 bg-gradient-to-b from-gray-50 to-white overflow-hidden">
  <div class="max-w-6xl mx-auto text-center px-6" data-aos="fade-up" data-aos-once="false">
    <h1 class="text-4xl font-bold text-gray-800 mb-6">{{ $about->title2 }}</h1>
    <p class="text-gray-600 mb-8 leading-relaxed">{{ $about->title2_content }}</p>

    <a href="{{ $about->button1_url }}" 
       class="inline-block bg-gradient-to-r from-blue-600 to-indigo-600 hover:opacity-90 text-white px-8 py-3 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105">
      <i class="fas fa-plus mr-2"></i> {{ $about->button1_name }}
    </a>
  </div>
</section>

<!-- ================= SECTION 2 ================= -->
<section class="relative py-24 text-white overflow-hidden">
  <img src="{{ asset('/public/storage/uploads/pics/' . $about->background_picture2) }}" 
       class="absolute inset-0 w-full h-full object-cover brightness-50 rounded-2xl" 
       alt="background picture">
  <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/40 to-black/70 rounded-2xl"></div>

  <div class="relative z-10 max-w-4xl mx-auto text-center px-6" data-aos="fade-up" data-aos-once="false">
    <h1 class="text-4xl font-bold mb-6">{{ $about->title3 }}</h1>
    <p class="opacity-90 leading-relaxed">{{ $about->title3_content }}</p>
  </div>
</section>

<!-- ================= SLIDESHOW SECTION ================= -->
<section class="py-20 bg-gray-50 overflow-hidden">
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center px-6">
    
    <div data-aos="fade-right" data-aos-once="false">
      <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $about->title4 }}</h1>
      <p class="text-gray-600 leading-relaxed">{{ $about->title4_content }}</p>
    </div>

    <div class="relative" data-aos="fade-left" data-aos-once="false">
      <img src="" alt="Slideshow" 
           class="rounded-xl shadow-2xl mx-auto transition-all duration-700 ease-in-out 
                  w-[400px] h-[450px] md:w-[500px] md:h-[550px] object-cover" 
           id="main-image"/>
    </div>
  </div>

  <!-- Features -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16 max-w-6xl mx-auto px-6">
    @foreach($about_table as $table)
      <div class="feature cursor-pointer bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition transform hover:scale-105" 
           data-aos="fade-up" data-aos-once="false"
           data-image="{{ asset('/public/storage/uploads/pics/' . $table->picture) }}">
        <h4 class="font-semibold text-xl mb-2 text-gray-800">{{ $table->title1 }}</h4>
        <p class="text-gray-600 text-sm">{{ $table->title1_content }}</p>
        <small class="block text-gray-500 mt-3">{{ $table->title1_small_text }}</small>
      </div>
    @endforeach
  </div>
</section>

<!-- ================= STATEMENTS SECTION ================= -->
<section class="py-20 bg-gradient-to-b from-white to-gray-100 overflow-hidden">
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 px-6">
    @foreach($statements as $statement)
      <div class="relative rounded-2xl overflow-hidden shadow-lg group" data-aos="fade-up" data-aos-once="false">
        <div class="relative w-full h-72 overflow-hidden rounded-2xl">
          <img src="{{ asset('/public/storage/uploads/pics/' . $statement->background_picture) }}" 
               alt="background picture" 
               class="absolute inset-0 w-full h-full object-cover rounded-2xl scale-110">
          <div class="absolute inset-0 bg-black/50 flex flex-col justify-center items-center text-center px-4 rounded-2xl">
            <h2 class="text-xl font-bold text-white mb-3">{{ $statement->title1 }}</h2>
            <p class="text-gray-200 text-sm leading-relaxed">{{ $statement->title1_main_content }}</p>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</section>

<!-- ================= CTA SECTION ================= -->
<section class="py-20 text-center bg-gradient-to-r from-indigo-600 to-blue-600 text-white overflow-hidden">
  <div data-aos="fade-up" data-aos-once="false">
    <h1 class="text-4xl font-bold mb-8">{{ $about->title5 }}</h1>
    <a href="{{ $about->button2_url }}" 
       class="inline-block bg-white text-blue-700 px-8 py-3 rounded-full font-semibold shadow-lg hover:opacity-90 transform hover:scale-105 transition">
      <i class="fas fa-plus mr-2"></i> {{ $about->button2_name }}
    </a>
  </div>
</section>

<!-- ================= TEAM SECTION ================= -->
<section class="max-w-[1200px] mx-auto px-8 py-16 team">
  <h2 class="text-3xl md:text-4xl font-bold text-center mb-8 text-cyan-400 drop-shadow-lg">
    {{ $about->title6 }}
  </h2>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 team-grid">
    
    <!-- CEO -->
    <div class="team-member bg-white/10 border border-cyan-400/20 backdrop-blur-md rounded-[20px] p-4 text-center shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-2 hover:scale-105"
         data-aos="fade-up" data-aos-once="false" data-aos-duration="1000">
      <img src="{{ asset('/public/uploads/pics/default2.png') }}" 
           alt="Mbumwae S. M." 
           class="w-[90px] h-[90px] rounded-full object-cover mx-auto mb-4 border-2 border-cyan-400">
      <h4 class="text-lg md:text-xl font-semibold mb-1 text-black">Erick Maliko</h4>
      <p class="text-sm md:text-base font-orbitron text-cyan-200">C.E.O</p>
    </div>

    <!-- CTO -->
    <div class="team-member bg-white/10 border border-cyan-400/20 backdrop-blur-md rounded-[20px] p-4 text-center shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-2 hover:scale-105"
         data-aos="fade-up" data-aos-once="false" data-aos-duration="1000" data-aos-delay="150">
      <img src="{{ asset('/public/uploads/pics/default2.png') }}" 
           alt="Erick Maliko" 
           class="w-[90px] h-[90px] rounded-full object-cover mx-auto mb-4 border-2 border-cyan-400">
      <h4 class="text-lg md:text-xl font-semibold mb-1 text-black">Erick Maliko</h4>
      <p class="text-sm md:text-base font-orbitron text-cyan-200">Chief Technology Officer</p>
    </div>

    <!-- UX Lead -->
    <div class="team-member bg-white/10 border border-cyan-400/20 backdrop-blur-md rounded-[20px] p-4 text-center shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-2 hover:scale-105"
         data-aos="fade-up" data-aos-once="false" data-aos-duration="1000" data-aos-delay="300">
      <img src="{{ asset('/public/uploads/pics/default2.png') }}" 
           alt="Mwami Miyanda" 
           class="w-[90px] h-[90px] rounded-full object-cover mx-auto mb-4 border-2 border-cyan-400">
      <h4 class="text-lg md:text-xl font-semibold mb-1 text-black">Mwami Miyanda</h4>
      <p class="text-sm md:text-base font-orbitron text-cyan-200">Lead UX Designer</p>
    </div>

  </div>
</section>





<!-- ================= SLIDESHOW SCRIPT ================= -->
<script>
  const features = document.querySelectorAll('.feature');
  const mainImage = document.getElementById('main-image');

  let currentIndex = 0;
  let autoSlide = true;

  function activateFeature(index) {
    const feature = features[index];
    const image = feature.getAttribute('data-image');

    mainImage.classList.add('opacity-0');
    setTimeout(() => {
      mainImage.src = image;
      mainImage.classList.remove('opacity-0');
    }, 400);

    features.forEach(f => f.classList.remove('ring-4', 'ring-indigo-500'));
    feature.classList.add('ring-4', 'ring-indigo-500');
  }

  function startSlideshow() {
    setInterval(() => {
      if (!autoSlide) return;
      currentIndex = (currentIndex + 1) % features.length;
      activateFeature(currentIndex);
    }, 4000);
  }

  features.forEach((feature, index) => {
    feature.addEventListener('click', () => {
      autoSlide = false;
      currentIndex = index;
      activateFeature(index);
    });
  });

  if (features.length > 0) {
    activateFeature(currentIndex);
    startSlideshow();
  }

  // Initialize AOS
  AOS.init({
    duration: 1000,
    once: false,
    mirror: true
  });
</script>



@endsection

@php 
    $navItems = App\Models\Nav1::with('children')
        ->whereNull('parent_id')
        ->get();
    $logo = App\Models\Logo::first();
@endphp

<style>
    .nav a{
        font-family: 'Orbitron', sans-serif;
        font-weight: bold;
    }
    .nav li{
        color: black;
        font-weight: bold;
        font-family: 'Orbitron', sans-serif;

    }
</style>

<script src="//unpkg.com/alpinejs" defer></script>

<nav class="bg-white border-b shadow-sm fixed top-0 w-full z-50 nav">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <div>
                <a href="{{ url($logo->home_url ?? '/') }}" class="flex items-center">
                    @if($logo && $logo->picture)
                        <img src="{{ asset('/public/storage/uploads/logo/' . $logo->picture) }}" alt="Logo" class="h-10 w-auto">
                    @else
                        <img src="{{ asset('/public/uploads/default.png') }}" alt="Logo" class="h-10 w-auto">
                    @endif
                </a>
            </div>

            {{-- Desktop Menu --}}
            <ul class="hidden md:flex items-center space-x-8 font-medium text-gray-800">
                @foreach ($navItems as $item)
                    <li x-data="{ open: false }" class="relative">
                        @if($item->children->count())
                            <button 
                                @click="open = !open" 
                                @click.outside="open = false"
                                class="flex items-center space-x-1 hover:text-blue-700 transition">
                                <span>{{ $item->name }}</span>
                                <svg class="w-4 h-4 mt-0.5 transition-transform duration-200" 
                                     :class="{'rotate-180': open}" 
                                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div 
                                x-show="open" 
                                x-transition 
                                class="absolute left-0 mt-2 w-48 bg-white border rounded-lg shadow-lg py-2 z-50">
                                @foreach ($item->children as $child)
                                    <a href="{{ url($child->name_url) }}" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ $child->name }}
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <a href="{{ url($item->name_url) }}" class="hover:text-blue-700 transition">
                                {{ $item->name }}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>

            {{-- CTA Button --}}
            <div class="hidden md:flex">
                <a href="register/employer" 
                   class="bg-blue-900 text-green-400 font-semibold px-5 py-2 rounded-md hover:bg-blue-800 transition">
                   Post job (free)
                </a>
            </div>

            {{-- Mobile Hamburger --}}
            <div class="md:hidden flex items-center" x-data="{ mobileOpen: false }">
                <button @click="mobileOpen = !mobileOpen" class="text-2xl text-gray-800">
                    <i class="fas fa-bars"></i>
                </button>
                
                {{-- Mobile Menu --}}
                <div x-show="mobileOpen" x-transition class="absolute top-16 left-0 w-full bg-white shadow-md border-t">
                    <ul class="flex flex-col items-start px-6 py-4 space-y-4 font-medium text-gray-800">
                        @foreach ($navItems as $item)
                            <li x-data="{ open: false }" class="w-full">
                                @if($item->children->count())
                                    <button 
                                        @click="open = !open" 
                                        class="flex justify-between w-full items-center hover:text-blue-700 transition">
                                        <span>{{ $item->name }}</span>
                                        <svg class="w-4 h-4 transition-transform duration-200" 
                                             :class="{'rotate-180': open}" 
                                             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div x-show="open" x-transition class="ml-4 mt-2 space-y-2">
                                        @foreach ($item->children as $child)
                                            <a href="{{ url($child->name_url) }}" 
                                               class="block text-sm text-gray-700 hover:text-blue-700 transition">
                                                {{ $child->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <a href="{{ url($item->name_url) }}" class="block hover:text-blue-700 transition">
                                        {{ $item->name }}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                        <li class="w-full">
                            <a href="register/employer" 
                               class="block bg-blue-900 text-green-400 text-center w-full px-5 py-2 rounded-md hover:bg-blue-800 transition">
                               Post Job (free)
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</nav>

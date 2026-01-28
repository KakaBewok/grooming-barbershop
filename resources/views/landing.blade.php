@extends('layouts.landing')

@section('content')

    <!-- Navbar Component -->
    <x-navbar :barbershop="$barbershop" />

    <!-- Hero Section -->
    <section id="hero">
        <section class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 py-20">
            <div class="max-w-7xl mx-auto w-full">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="space-y-8">
                        <div>
                            <div
                                class="inline-block px-4 py-2 border-4 border-black dark:border-white bg-yellow-400 dark:bg-yellow-300 text-black font-bold uppercase text-sm mb-6 neo-brutal-shadow-sm">
                                Premium Barbershop
                            </div>
                            <h1 class="font-display text-6xl lg:text-7xl font-bold leading-none mb-6">
                                {{ $barbershop->name }}
                            </h1>
                            <p class="text-xl lg:text-2xl opacity-80 leading-relaxed">
                                {{ $barbershop->description }}
                            </p>
                        </div>

                        <!-- WhatsApp CTA -->
                        <div class="flex flex-wrap gap-4">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $barbershop->phone) }}?text={{ urlencode('Hello, I would like to ask about your barbershop services.') }}"
                                target="_blank"
                                class="neo-brutal-btn px-8 py-4 bg-green-500 text-white neo-brutal-shadow inline-flex items-center gap-3 text-lg">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                </svg>
                                Booking via WhatsApp
                            </a>

                            <a href="#services"
                                class="neo-brutal-btn px-8 py-4 bg-white dark:bg-black border-black dark:border-white neo-brutal-shadow text-lg">
                                View Services
                            </a>
                        </div>

                        <!-- Social Links -->
                        <div class="flex gap-4 pt-4">
                            @if ($barbershop->instagram_url)
                                <a href="{{ $barbershop->instagram_url }}" target="_blank"
                                    class="p-3 border-4 border-black dark:border-white bg-white dark:bg-black neo-brutal-shadow-sm hover:translate-x-1 hover:translate-y-1 hover:shadow-none">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                                </a>
                            @endif

                            @if ($barbershop->tiktok_url)
                                <a href="{{ $barbershop->tiktok_url }}" target="_blank"
                                    class="p-3 border-4 border-black dark:border-white bg-white dark:bg-black neo-brutal-shadow-sm hover:translate-x-1 hover:translate-y-1 hover:shadow-none">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Right Image -->
                    <div class="relative">
                        @if ($barbershop->featuredImages->first())
                            <div
                                class="border-4 border-black dark:border-white neo-brutal-shadow overflow-hidden aspect-square">
                                <img src="{{ asset('storage/' . $barbershop->featuredImages->first()->image_path) }}"
                                    alt="{{ $barbershop->name }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services"
            class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900 border-y-4 border-black dark:border-white">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="font-display text-5xl lg:text-6xl font-bold mb-4">Our Services</h2>
                    <p class="text-xl opacity-80 mb-6">Premium grooming services for modern gentlemen</p>
                    <p class="text-sm opacity-60">← Swipe to see more →</p>
                </div>

                <!-- Horizontal Scrollable Container -->
                <div class="relative -mx-4 sm:-mx-6 lg:-mx-8">
                    <div class="overflow-x-auto scrollbar-hide px-4 sm:px-6 lg:px-8">
                        <div class="flex gap-6 pb-4" style="scroll-snap-type: x mandatory;">
                            @foreach ($barbershop->activeServices as $service)
                                <div class="flex-none w-[85vw] sm:w-100 lg:w-112.5" style="scroll-snap-align: start;">
                                    <x-service-card :service="$service" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Scroll Indicator (optional) -->
                <div class="flex justify-center gap-2 mt-6">
                    @foreach ($barbershop->activeServices as $index => $service)
                        <div class="w-2 h-2 rounded-full bg-black dark:bg-white opacity-30"></div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Products Section -->
        @if ($barbershop->activeProducts->count() > 0)
            <section id="products" class="py-20 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-12">
                        <h2 class="font-display text-5xl lg:text-6xl font-bold mb-4">Premium Products</h2>
                        <p class="text-xl opacity-80 mb-6">Curated grooming products for your daily routine</p>
                        <p class="text-sm opacity-60">← Swipe to see more →</p>
                    </div>

                    <!-- Horizontal Scrollable Container -->
                    <div class="relative -mx-4 sm:-mx-6 lg:-mx-8">
                        <div class="overflow-x-auto scrollbar-hide px-4 sm:px-6 lg:px-8">
                            <div class="flex gap-6 pb-4" style="scroll-snap-type: x mandatory;">
                                @foreach ($barbershop->activeProducts as $product)
                                    <div class="flex-none w-[75vw] sm:w-[320px] lg:w-90" style="scroll-snap-align: start;">
                                        <x-product-card :product="$product" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Scroll Indicator (optional) -->
                    <div class="flex justify-center gap-2 mt-6">
                        @foreach ($barbershop->activeProducts as $index => $product)
                            <div class="w-2 h-2 rounded-full bg-black dark:bg-white opacity-30"></div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Gallery Section -->
        @if ($barbershop->images->count() > 0)
            <section id="gallery"
                class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900 border-y-4 border-black dark:border-white">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-16">
                        <h2 class="font-display text-5xl lg:text-6xl font-bold mb-4">Our Space</h2>
                        <p class="text-xl opacity-80">Step inside our modern barbershop</p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" x-data="{ lightbox: false, currentImage: '' }">
                        @foreach ($barbershop->images as $image)
                            <div class="border-4 border-black dark:border-white neo-brutal-shadow overflow-hidden aspect-square cursor-pointer hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all"
                                @click="lightbox = true; currentImage = '{{ asset('storage/' . $image->image_path) }}'">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->caption }}"
                                    class="w-full h-full object-cover">
                            </div>
                        @endforeach

                        <!-- Lightbox -->
                        <div x-show="lightbox" @click="lightbox = false"
                            class="fixed inset-0 z-50 bg-black bg-opacity-90 flex items-center justify-center p-4"
                            x-transition>
                            <button @click="lightbox = false"
                                class="absolute top-6 right-6 text-white text-4xl font-bold">&times;</button>
                            <img :src="currentImage" class="max-w-full max-h-full border-4 border-white"
                                alt="Gallery Image">
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Contact Section -->
        <section id="contact" class="py-20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-12">
                    <!-- Contact Info -->
                    <div class="space-y-8">
                        <div>
                            <h2 class="font-display text-5xl font-bold mb-6">Visit Us</h2>
                            <div class="space-y-6 text-lg">
                                <div class="flex items-start gap-4">
                                    <svg class="w-6 h-6 mt-1 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-bold mb-1">Address</p>
                                        <p class="opacity-80">{{ $barbershop->address }}</p>
                                        @if ($barbershop->google_maps_url)
                                            <a href="{{ $barbershop->google_maps_url }}" target="_blank"
                                                class="inline-block mt-2 px-4 py-2 border-2 border-black dark:border-white text-sm font-bold hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-colors">
                                                Open in Maps
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <svg class="w-6 h-6 mt-1 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    <div>
                                        <p class="font-bold mb-1">Phone</p>
                                        <p class="opacity-80">{{ $barbershop->phone }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Opening Hours -->
                        @if ($openingHours->count() > 0)
                            <div class="border-4 border-black dark:border-white p-6 neo-brutal-shadow">
                                <h3 class="font-bold text-2xl mb-4">Opening Hours</h3>
                                <div class="space-y-2">
                                    @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                        @if ($openingHours->has($day))
                                            <div class="flex justify-between">
                                                <span class="font-semibold capitalize">{{ $day }}</span>
                                                <span>{{ $openingHours[$day]['open'] }} -
                                                    {{ $openingHours[$day]['close'] }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- CTA Card -->
                    <div
                        class="border-4 border-black dark:border-white bg-yellow-400 dark:bg-yellow-300 text-black p-8 lg:p-12 neo-brutal-shadow flex flex-col justify-center">
                        <h3 class="font-display text-4xl font-bold mb-4">Ready for a Fresh Look?</h3>
                        <p class="text-xl mb-8">Book your appointment now via WhatsApp</p>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $barbershop->phone) }}?text={{ urlencode('Hello, I would like to book an appointment.') }}"
                            target="_blank"
                            class="neo-brutal-btn px-8 py-4 bg-black text-white neo-brutal-shadow inline-flex items-center justify-center gap-3 text-lg w-full">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                            </svg>
                            Chat Admin Now
                        </a>
                    </div>
                </div>
            </div>
        </section>

    @endsection

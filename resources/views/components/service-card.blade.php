@props(['service'])

<div class="border-4 border-black dark:border-white bg-white dark:bg-black p-6 neo-brutal-shadow hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all"
    x-data="{ showGallery: false }">

    <!-- Service Image -->
    @if ($service->images->first())
        <div class="mb-6 aspect-video border-4 border-black dark:border-white overflow-hidden cursor-pointer"
            @click="showGallery = true">
            <img src="{{ asset('storage/' . $service->images->first()->image_path) }}" alt="{{ $service->name }}"
                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
        </div>
    @endif

    <!-- Service Info -->
    <div class="space-y-4">
        <div>
            <h3 class="font-display text-2xl font-bold mb-2">{{ $service->name }}</h3>
            <p class="opacity-80 text-sm line-clamp-2">{{ $service->description }}</p>
        </div>

        <!-- Price -->
        <div class="flex items-baseline gap-2">
            <span class="text-3xl font-bold">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
            @if ($service->has_discount)
                <span class="text-lg line-through opacity-50">Rp
                    {{ number_format($service->crossed_out_price, 0, ',', '.') }}</span>
                <span class="px-2 py-1 bg-red-500 text-white text-xs font-bold">
                    -{{ round($service->discount_percentage) }}%
                </span>
            @endif
        </div>

        <!-- View Gallery Button -->
        @if ($service->images->count() > 1)
            <button @click="showGallery = true" class="text-sm font-bold underline hover:no-underline">
                View {{ $service->images->count() }} Photos
            </button>
        @endif
    </div>

    <!-- Gallery Modal -->
    @if ($service->images->count() > 0)
        <div x-show="showGallery" @click.self="showGallery = false"
            class="fixed inset-0 z-50 bg-black bg-opacity-90 flex items-center justify-center p-4" x-transition
            style="display: none;">

            <div class="relative max-w-4xl w-full" @click.stop>
                <!-- Close Button -->
                <button @click="showGallery = false"
                    class="absolute -top-12 right-0 text-white text-4xl font-bold hover:scale-110 transition-transform">
                    &times;
                </button>

                <!-- Service Info -->
                <div class="bg-white dark:bg-black border-4 border-white p-6 mb-4">
                    <h3 class="font-display text-3xl font-bold mb-2">{{ $service->name }}</h3>
                    <p class="text-2xl font-bold">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                </div>

                <!-- Gallery Slider -->
                <div x-data="{ currentSlide: 0, totalSlides: {{ $service->images->count() }} }" class="relative">
                    <div class="border-4 border-white overflow-hidden aspect-video bg-black">
                        @foreach ($service->images as $index => $image)
                            <img x-show="currentSlide === {{ $index }}"
                                src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $service->name }}"
                                class="w-full h-full object-contain" style="display: none;">
                        @endforeach
                    </div>

                    @if ($service->images->count() > 1)
                        <!-- Navigation -->
                        <button @click="currentSlide = currentSlide === 0 ? totalSlides - 1 : currentSlide - 1"
                            class="absolute left-4 top-1/2 -translate-y-1/2 bg-white text-black p-3 border-4 border-white font-bold text-2xl hover:bg-black hover:text-white transition-colors">
                            ‹
                        </button>
                        <button @click="currentSlide = currentSlide === totalSlides - 1 ? 0 : currentSlide + 1"
                            class="absolute right-4 top-1/2 -translate-y-1/2 bg-white text-black p-3 border-4 border-white font-bold text-2xl hover:bg-black hover:text-white transition-colors">
                            ›
                        </button>

                        <!-- Indicators -->
                        <div class="flex justify-center gap-2 mt-4">
                            @foreach ($service->images as $index => $image)
                                <button @click="currentSlide = {{ $index }}"
                                    :class="currentSlide === {{ $index }} ? 'bg-white' : 'bg-gray-600'"
                                    class="w-3 h-3 border-2 border-white transition-colors">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

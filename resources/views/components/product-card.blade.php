@props(['product'])

<div class="border-4 border-black dark:border-white bg-white dark:bg-black p-6 neo-brutal-shadow hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all"
    x-data="{ showGallery: false }">

    <!-- Product Image -->
    @if ($product->images->first())
        <div class="mb-6 aspect-square border-4 border-black dark:border-white overflow-hidden cursor-pointer"
            @click="showGallery = true">
            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}"
                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
        </div>
    @endif

    <!-- Stock Badge -->
    <div class="mb-4">
        @if ($product->stock > 10)
            <span class="px-3 py-1 bg-green-500 text-white text-xs font-bold border-2 border-black dark:border-white">
                IN STOCK
            </span>
        @elseif($product->stock > 0)
            <span class="px-3 py-1 bg-yellow-500 text-black text-xs font-bold border-2 border-black dark:border-white">
                LOW STOCK ({{ $product->stock }} left)
            </span>
        @else
            <span class="px-3 py-1 bg-red-500 text-white text-xs font-bold border-2 border-black dark:border-white">
                OUT OF STOCK
            </span>
        @endif
    </div>

    <!-- Product Info -->
    <div class="space-y-4">
        <div>
            <h3 class="font-display text-2xl font-bold mb-2">{{ $product->name }}</h3>
            <p class="opacity-80 text-sm line-clamp-2">{{ $product->description }}</p>
        </div>

        <!-- Price -->
        <div class="flex items-baseline gap-2">
            <span class="text-3xl font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            @if ($product->has_discount)
                <span class="text-lg line-through opacity-50">Rp
                    {{ number_format($product->crossed_out_price, 0, ',', '.') }}</span>
                <span class="px-2 py-1 bg-red-500 text-white text-xs font-bold">
                    -{{ round($product->discount_percentage) }}%
                </span>
            @endif
        </div>

        <!-- View Gallery Button -->
        @if ($product->images->count() > 1)
            <button @click="showGallery = true" class="text-sm font-bold underline hover:no-underline">
                View {{ $product->images->count() }} Photos
            </button>
        @endif
    </div>

    <!-- Gallery Modal -->
    @if ($product->images->count() > 0)
        <div x-show="showGallery" @click.self="showGallery = false"
            class="fixed inset-0 z-50 bg-black bg-opacity-90 flex items-center justify-center p-4" x-transition
            style="display: none;">

            <div class="relative max-w-4xl w-full" @click.stop>
                <!-- Close Button -->
                <button @click="showGallery = false"
                    class="absolute -top-12 right-0 text-white text-4xl font-bold hover:scale-110 transition-transform">
                    &times;
                </button>

                <!-- Product Info -->
                <div class="bg-white dark:bg-black border-4 border-white p-6 mb-4">
                    <h3 class="font-display text-3xl font-bold mb-2">{{ $product->name }}</h3>
                    <p class="text-2xl font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="mt-2 opacity-80">{{ $product->description }}</p>
                </div>

                <!-- Gallery Slider -->
                <div x-data="{ currentSlide: 0, totalSlides: {{ $product->images->count() }} }" class="relative">
                    <div class="border-4 border-white overflow-hidden aspect-square bg-black">
                        @foreach ($product->images as $index => $image)
                            <img x-show="currentSlide === {{ $index }}"
                                src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-contain" style="display: none;">
                        @endforeach
                    </div>

                    @if ($product->images->count() > 1)
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
                            @foreach ($product->images as $index => $image)
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

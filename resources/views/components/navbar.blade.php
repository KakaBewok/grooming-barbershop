@props(['barbershop'])

<nav x-data="{ mobileMenuOpen: false }"
    class="fixed top-0 left-0 right-0 z-40 bg-white dark:bg-black border-b-4 border-black dark:border-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            <!-- Logo/Brand -->
            <a href="#hero" class="font-display text-2xl font-bold hover:opacity-80 transition-opacity">
                {{ $barbershop->name }}
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-8">
                <a href="#hero" class="font-bold uppercase text-sm hover:opacity-70 transition-opacity">Home</a>
                <a href="#services" class="font-bold uppercase text-sm hover:opacity-70 transition-opacity">Services</a>
                @if ($barbershop->activeProducts->count() > 0)
                    <a href="#products"
                        class="font-bold uppercase text-sm hover:opacity-70 transition-opacity">Products</a>
                @endif
                @if ($barbershop->images->count() > 0)
                    <a href="#gallery"
                        class="font-bold uppercase text-sm hover:opacity-70 transition-opacity">Gallery</a>
                @endif
                <a href="#contact" class="font-bold uppercase text-sm hover:opacity-70 transition-opacity">Contact</a>

                <!-- WhatsApp Button (Desktop) -->
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $barbershop->phone) }}?text={{ urlencode('Hello, I would like to ask about your barbershop services.') }}"
                    target="_blank"
                    class="px-6 py-2 bg-green-500 text-white border-4 border-black dark:border-white font-bold uppercase text-sm neo-brutal-shadow-sm hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                    </svg>
                    Book Now
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="md:hidden p-2 border-4 border-black dark:border-white bg-white dark:bg-black neo-brutal-shadow-sm"
                :class="{ 'translate-x-1 translate-y-1 shadow-none': mobileMenuOpen }">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
                <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4" @click.away="mobileMenuOpen = false"
        class="md:hidden border-t-4 border-black dark:border-white bg-white dark:bg-black" style="display: none;">

        <div class="px-4 py-6 space-y-4">
            <a href="#hero" @click="mobileMenuOpen = false"
                class="block px-4 py-3 border-4 border-black dark:border-white font-bold uppercase text-sm hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-colors">
                Home
            </a>

            <a href="#services" @click="mobileMenuOpen = false"
                class="block px-4 py-3 border-4 border-black dark:border-white font-bold uppercase text-sm hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-colors">
                Services
            </a>

            @if ($barbershop->activeProducts->count() > 0)
                <a href="#products" @click="mobileMenuOpen = false"
                    class="block px-4 py-3 border-4 border-black dark:border-white font-bold uppercase text-sm hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-colors">
                    Products
                </a>
            @endif

            @if ($barbershop->images->count() > 0)
                <a href="#gallery" @click="mobileMenuOpen = false"
                    class="block px-4 py-3 border-4 border-black dark:border-white font-bold uppercase text-sm hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-colors">
                    Gallery
                </a>
            @endif

            <a href="#contact" @click="mobileMenuOpen = false"
                class="block px-4 py-3 border-4 border-black dark:border-white font-bold uppercase text-sm hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-colors">
                Contact
            </a>

            <!-- Mobile WhatsApp Button -->
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $barbershop->phone) }}?text={{ urlencode('Hello, I would like to ask about your barbershop services.') }}"
                target="_blank"
                class="block px-4 py-3 bg-green-500 text-white border-4 border-black dark:border-white font-bold uppercase text-sm text-center neo-brutal-shadow hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all">
                <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                </svg>
                Book via WhatsApp
            </a>
        </div>
    </div>
</nav>

<!-- Spacer to prevent content being hidden under fixed navbar -->
<div class="h-20"></div>

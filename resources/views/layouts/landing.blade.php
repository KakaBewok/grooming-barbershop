{{-- <!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $barbershop->name }} - Modern Barbershop</title>
    <meta name="description" content="{{ Str::limit($barbershop->description, 160) }}">

    <!-- SEO Meta Tags -->
    <meta property="og:title" content="{{ $barbershop->name }}">
    <meta property="og:description" content="{{ Str::limit($barbershop->description, 160) }}">
    @if ($barbershop->featuredImages->first())
        <meta property="og:image" content="{{ asset('storage/' . $barbershop->featuredImages->first()->image_path) }}">
    @endif

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#000000',
                        secondary: '#FFFFFF',
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        display: ['Space Grotesk', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Space+Grotesk:wght@700&display=swap"
        rel="stylesheet">

    <style>
        /* Neo Brutalism Styles */
        .neo-brutal-shadow {
            box-shadow: 8px 8px 0px 0px rgba(0, 0, 0, 1);
        }

        .neo-brutal-shadow-sm {
            box-shadow: 4px 4px 0px 0px rgba(0, 0, 0, 1);
        }

        .dark .neo-brutal-shadow,
        .dark .neo-brutal-shadow-sm {
            box-shadow: 8px 8px 0px 0px rgba(255, 255, 255, 0.2);
        }

        .neo-brutal-btn {
            @apply border-4 border-black font-bold uppercase tracking-wider transition-all duration-200;
            @apply hover:translate-x-1 hover:translate-y-1 hover:shadow-none;
        }

        .dark .neo-brutal-btn {
            @apply border-white;
        }

        .bento-grid {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        @media (min-width: 768px) {
            .bento-grid-large {
                grid-template-columns: repeat(12, 1fr);
            }
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
    </style>
</head>

<body class="bg-white dark:bg-black text-black dark:text-white font-sans antialiased">

    <!-- Dark Mode Toggle (Fixed Position) -->
    <button @click="darkMode = !darkMode"
        class="fixed top-6 right-6 z-50 p-3 border-4 border-black dark:border-white bg-white dark:bg-black neo-brutal-shadow-sm hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all"
        aria-label="Toggle Dark Mode">
        <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
        <svg x-show="darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
            </path>
        </svg>
    </button>

    @yield('content')

    <!-- Footer -->
    <footer class="border-t-4 border-black dark:border-white bg-white dark:bg-black py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-lg font-bold">{{ $barbershop->name }}</p>
                <p class="mt-2 text-sm opacity-70">© {{ date('Y') }} All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html> --}}

<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $barbershop->name }} - Modern Barbershop</title>
    <meta name="description" content="{{ Str::limit($barbershop->description, 160) }}">

    <!-- SEO Meta Tags -->
    <meta property="og:title" content="{{ $barbershop->name }}">
    <meta property="og:description" content="{{ Str::limit($barbershop->description, 160) }}">
    @if ($barbershop->featuredImages->first())
        <meta property="og:image" content="{{ asset('storage/' . $barbershop->featuredImages->first()->image_path) }}">
    @endif

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#000000',
                        secondary: '#FFFFFF',
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        display: ['Space Grotesk', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Space+Grotesk:wght@700&display=swap"
        rel="stylesheet">

    <style>
        /* Neo Brutalism Styles */
        .neo-brutal-shadow {
            box-shadow: 8px 8px 0px 0px rgba(0, 0, 0, 1);
        }

        .neo-brutal-shadow-sm {
            box-shadow: 4px 4px 0px 0px rgba(0, 0, 0, 1);
        }

        .dark .neo-brutal-shadow,
        .dark .neo-brutal-shadow-sm {
            box-shadow: 8px 8px 0px 0px rgba(255, 255, 255, 0.2);
        }

        .neo-brutal-btn {
            border: 4px solid black;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.2s;
        }

        .dark .neo-brutal-btn {
            border-color: white;
        }

        .neo-brutal-btn:hover {
            transform: translate(4px, 4px);
            box-shadow: none;
        }

        .bento-grid {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        @media (min-width: 768px) {
            .bento-grid-large {
                grid-template-columns: repeat(12, 1fr);
            }
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 80px;
            /* Account for fixed navbar */
        }

        /* Hide scrollbar but keep functionality */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* Smooth horizontal scroll */
        .overflow-x-auto {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>
</head>

<body class="bg-white dark:bg-black text-black dark:text-white font-sans antialiased">

    <!-- Dark Mode Toggle (Fixed Position) -->
    <button @click="darkMode = !darkMode"
        class="fixed top-6 right-6 z-50 p-3 border-4 border-black dark:border-white bg-white dark:bg-black neo-brutal-shadow-sm hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all"
        aria-label="Toggle Dark Mode">
        <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
        <svg x-show="darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
            </path>
        </svg>
    </button>

    @yield('content')

    <!-- Footer -->
    <footer class="border-t-4 border-black dark:border-white bg-white dark:bg-black py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-lg font-bold">{{ $barbershop->name }}</p>
                <p class="mt-2 text-sm opacity-70">© {{ date('Y') }} All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>

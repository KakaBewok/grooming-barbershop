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

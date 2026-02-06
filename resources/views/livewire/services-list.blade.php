<div class="w-full">
    <!-- Desktop Grid & Mobile Carousel Wrapper -->
    <div class="flex flex-col gap-10">
        <!-- Services Grid/Carousel -->
        <div class="flex overflow-x-auto pb-8 snap-x snap-mandatory scrollbar-hide -mx-4 px-4 md:mx-0 md:px-0 md:grid md:grid-cols-2 lg:grid-cols-3 md:overflow-visible md:pb-0 md:snap-none gap-6 md:gap-10">
            @foreach ($services as $service)
                <div class="flex-none w-[85vw] sm:w-[350px] md:w-full snap-start h-auto">
                    <x-service-card :service="$service" />
                </div>
            @endforeach
        </div>

        <!-- Custom Neo-Brutal Pagination -->
        @if ($services->hasPages())
            <div class="mt-4 flex justify-center">
                <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center gap-4">
                    {{-- Previous Page Link --}}
                    @if ($services->onFirstPage())
                        <div class="p-4 border-4 border-black dark:border-white bg-gray-200 dark:bg-gray-800 opacity-50 cursor-not-allowed">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </div>
                    @else
                        <button wire:click="previousPage" wire:loading.attr="disabled"
                            class="p-4 border-4 border-black dark:border-white bg-yellow-400 dark:bg-yellow-300 neo-brutal-shadow-sm hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all active:translate-x-1 active:translate-y-1 active:shadow-none group">
                            <svg class="w-6 h-6 group-active:scale-95 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                    @endif

                    {{-- Page Information --}}
                    <div class="px-6 py-4 border-4 border-black dark:border-white bg-white dark:bg-black font-display font-bold text-xl neo-brutal-shadow-sm">
                        {{ $services->currentPage() }} <span class="opacity-50 mx-1">/</span> {{ $services->lastPage() }}
                    </div>

                    {{-- Next Page Link --}}
                    @if ($services->hasMorePages())
                        <button wire:click="nextPage" wire:loading.attr="disabled"
                            class="p-4 border-4 border-black dark:border-white bg-yellow-400 dark:bg-yellow-300 neo-brutal-shadow-sm hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all active:translate-x-1 active:translate-y-1 active:shadow-none group">
                            <svg class="w-6 h-6 group-active:scale-95 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    @else
                        <div class="p-4 border-4 border-black dark:border-white bg-gray-200 dark:bg-gray-800 opacity-50 cursor-not-allowed">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    @endif
                </nav>
            </div>
        @endif
    </div>
</div>

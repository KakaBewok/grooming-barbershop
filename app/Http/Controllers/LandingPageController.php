<?php

namespace App\Http\Controllers;

use App\Models\Barbershop;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index($slug = null)
    {
        // Get barbershop with all related data (eager loading to avoid N+1)
        $barbershop = Barbershop::with([
            'featuredImages',
            'images' => fn($query) => $query->orderBy('sort_order'),
            'activeServices.images' => fn($query) => $query->orderBy('sort_order'),
            'activeProducts.images' => fn($query) => $query->orderBy('sort_order'),
        ])
        ->active()
        ->when($slug, fn($query) => $query->where('slug', $slug))
        ->firstOrFail();

        // Parse opening hours for display
        // $openingHours = collect($barbershop->opening_hours ?? [])
        //     ->mapWithKeys(function ($hours) {
        //         return [$hours['day'] => $hours];
        //     });

        $openingHours = collect($barbershop->opening_hours ?? [])
            ->filter(fn ($hours) => isset($hours['day'])) // Hanya ambil yang punya key 'day'
            ->mapWithKeys(function ($hours) {
                return [$hours['day'] => $hours];
            });

        return view('landing', compact('barbershop', 'openingHours'));
    }
}

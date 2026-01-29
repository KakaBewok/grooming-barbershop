<?php

namespace App\Http\Controllers;

use App\Models\Barbershop;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $barbershop = Barbershop::with([
            'featuredImages',
            'images' => fn($query) => $query->orderBy('sort_order')
        ])
        ->active()
        ->firstOrFail();

        $services = Service::active()->get();
        $products = Product::active()->get();

        $openingHours = collect($barbershop->opening_hours ?? [])
            ->filter(fn ($hours) => isset($hours['day'])) // Hanya ambil yang punya key 'day'
            ->mapWithKeys(function ($hours) {
                return [$hours['day'] => $hours];
            });

        return view('landing', compact('barbershop', 'services', 'products', 'openingHours'));
    }
}

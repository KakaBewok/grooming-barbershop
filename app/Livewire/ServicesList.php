<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Service;

class ServicesList extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.services-list', [
            'services' => Service::active()->with('images')->paginate(6),
        ]);
    }
}

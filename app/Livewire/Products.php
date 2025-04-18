<?php

namespace App\Livewire;

use App\Models\ProductDisplay;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.products', [
            'products' => ProductDisplay::paginate(8)
        ]);
    }
}

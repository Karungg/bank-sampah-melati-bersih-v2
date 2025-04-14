<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Transaction;
use Livewire\Component;

class StatsCounter extends Component
{
    public function render()
    {
        return view('livewire.stats-counter', [
            'totalClient' => Customer::count(),
            'totalWaste' => Transaction::sum('total_weight')
        ]);
    }
}

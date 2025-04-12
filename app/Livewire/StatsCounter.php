<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Transaction;
use Livewire\Component;

class StatsCounter extends Component
{
    public int $totalClient;
    public int $totalWaste;

    public function mount()
    {
        $this->totalClient = Customer::count();
        $this->totalWaste = Transaction::sum('total_weight');
    }

    public function render()
    {
        return view('livewire.stats-counter');
    }
}

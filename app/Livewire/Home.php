<?php

namespace App\Livewire;

use App\Models\CompanyProfile;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        return view('livewire.home', [
            'annountcement' => CompanyProfile::query()->value('annountcement')
        ]);
    }
}

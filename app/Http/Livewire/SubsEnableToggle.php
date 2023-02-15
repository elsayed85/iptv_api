<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SubsEnableToggle extends Component
{
    public $subs_enabled;

    public function render()
    {
        return view('livewire.subs-enable-toggle');
    }

    public function mount()
    {
        $this->subs_enabled = session('subs_enabled', false);
    }

    public function toggleSubs()
    {
        $this->subs_enabled = !$this->subs_enabled;
        session()->put('subs_enabled', $this->subs_enabled);
    }
}

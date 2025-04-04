<?php

namespace App\Livewire\Popup;

use LivewireUI\Modal\ModalComponent;

class Notification extends ModalComponent
{
    public string $message;
    public bool $reload = false;

    public function render()
    {
        return view('livewire.popup.notification');
    }
}

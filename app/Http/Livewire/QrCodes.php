<?php

namespace App\Http\Livewire;

use App\Models\QrCodeModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class QrCodes extends Component
{

    use LivewireAlert;

    protected $listeners = ['save'];

    public $title, $content;

    public function render()
    {
        $qrs = QrCodeModel::paginate(5);

        return view('livewire.qr-codes', compact('qrs'));
    }

    public function save()
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        QrCodeModel::create([
            'title' => $this->title,
            'content' => $this->content,
            'code' => $this->content,
        ]);

        $this->reset('title', 'content');
        $this->alert('success', 'QR Code Saved');
    }
}

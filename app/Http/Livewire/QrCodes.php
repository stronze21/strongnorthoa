<?php

namespace App\Http\Livewire;

use App\Models\QrCodeModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class QrCodes extends Component
{

    use LivewireAlert;
    use WithPagination;

    protected $listeners = ['save'];

    public $title, $content;
    public $search = '';
    public $showCreate = false;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function openCreate()
    {
        $this->reset(['title', 'content']);
        $this->resetValidation();
        $this->showCreate = true;
    }

    public function render()
    {
        $qrs = QrCodeModel::when($this->search, function ($query) {
            $query->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        })->orderByDesc('id')->paginate(9);

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
        $this->showCreate = false;
        $this->search = '';
        $this->resetPage();
        $this->alert('success', 'QR Code Saved');
    }
}

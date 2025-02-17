<?php

namespace App\Http\Livewire\References;

use App\Models\Sspl;
use Livewire\Component;

class SsplCrud extends Component
{
    public $sspls, $sspl, $type, $ssplId;
    public $isModalOpen = false;

    public function render()
    {
        $this->sspls = Sspl::all();
        return view('livewire.references.sspl-crud');
    }

    public function create()
    {
        $this->resetFields();
        $this->openModal();
    }

    public function edit($id)
    {
        $sspl = Sspl::findOrFail($id);
        $this->ssplId = $id;
        $this->sspl = $sspl->sspl;
        $this->type = $sspl->type;
        $this->openModal();
    }

    public function save()
    {
        $this->validate([
            'sspl' => 'required|string|max:255',
            'type' => 'required|in:lifechanger,partner',
        ]);

        Sspl::updateOrCreate(['id' => $this->ssplId], [
            'level' => $this->sspl,
            'type' => $this->type,
        ]);

        session()->flash('message', $this->ssplId ? 'Sspl updated successfully!' : 'Sspl created successfully!');
        $this->closeModal();
    }

    public function delete($id)
    {
        Sspl::findOrFail($id)->delete();
        session()->flash('message', 'Sspl deleted successfully!');
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetFields();
    }

    private function resetFields()
    {
        $this->ssplId = null;
        $this->sspl = '';
        $this->type = '';
    }
}
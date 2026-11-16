<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component {
    use WithPagination;

    public string $filtroNome = '';

    public function updatedFiltroNome(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $items = Item::query()
            ->when($this->filtroNome !== '', fn ($query) => $query->where('nome', 'like', '%' . $this->filtroNome . '%'))
            ->orderBy('created_at')
            ->get();

        return view('livewire.home-search', compact('items'));
    }
}
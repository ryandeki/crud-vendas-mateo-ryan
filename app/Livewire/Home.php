<?php

use App\Models\Item;
use Livewire\Component;

class Home extends Component {
    public string filtroNome = '';

    public function updatedFiltroNome(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $produtos = Item::query()
        ->when($this->filtroNome !== '', fn ($query) => $query->where('nome', 'like', '%' . $this->filtroNome . '%'))
        ->orderBy('nome');

        return view('home', compact('produtos'));
    }
}
@extends('layouts.main_layout')
@section('content')
@include("top_bar")
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col">

            <div class="row">
                <div class="col">
                    <p class="display-6 mb-0">EDITAR DO ITEM</p>
                </div>
            </div>
            <form action="{{ route('edit.item.submit') }}" method="post">
                @csrf

                <input type="hidden" name="item_id" value="{{ Crypt::encrypt($item->id) }}">

                <div class="row mt-3">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Nome do item:</label>
                            <input type="text" class="form-control" name="text_title" value="{{ old('text_title', $item->nome) }}">
                            @error('text_title')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Categoria:</label>
                            <select onchange="if (this.value.startsWith('http')) { window.location.href = this.value; }" class="form-select" name="category">
                                <option value="">Selecione uma categoria...</option>

                                @foreach ($categories as $category)
                                @if ($category->status == 'active')
                                <option value="{{ $category->nome }}" {{ old('category') == $category->nome || old($item->category_id) == $category->id ? 'selected' : '' }}>{{ $category->nome }}</option>
                                @endif
                                @endforeach

                                <option value="{{ route('new') }}">Criar nova categoria</option>
                            </select>
                            @error('category')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Estado:</label>
                            <select class="form-select" name="status">
                                <option value="new" selected>Novo</option>
                                <option value="almost-new">Semi-novo</option>
                                <option value="worn-out">Desgastado</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Preço:</label>
                            <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price', $item->preco) }}">
                            @error('price')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descrição:</label>
                            <textarea class="form-control" name="description" rows="5">{{ old('description', $item->descricao) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col text-center">
                        <a href="{{ route('home') }}" class="btn btn-danger px-5">
                            <i class="bi bi-ban me-2"></i>Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary px-5">
                            <i class="bi bi-check-circle me-2"></i>Salvar
                        </button>
                    </div>
                </div>>
            </form>

        </div>
    </div>
</div>

@endsection
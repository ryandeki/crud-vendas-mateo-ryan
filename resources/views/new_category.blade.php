@extends('layouts.main_layout')
@section('content')
@include("top_bar")
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col">

            <div class="row">
                <div class="col">
                    <p class="display-6 mb-0">NOVA CATEGORIA</p>
                </div>
            </div>
            <form action="{{ route('newCategorySubmit') }}" method="post">
                @csrf
                <div class="row mt-3">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label">Nome da categoria:</label>
                            <input type="text" class="form-control" name="text_title" value="{{ old('text_title') }}">
                            @error('text_title')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status:</label>
                            <select class="form-select" name="status">
                                <option value="active" selected>Ativa</option>
                                <option value="inactive">Desativada</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descrição:</label>
                            <textarea class="form-control" name="text_note" rows="5">{{ old('text_note') }}</textarea>
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
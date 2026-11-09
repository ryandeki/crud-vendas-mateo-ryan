@extends('layouts.main_layout')
@section('content')
@include('top_bar')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0 fs-5">Nova Avaliação para: {{ $item->nome }}</h4>
                </div>
                <div class="card-body">

                    @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('newReviewSubmit') }}" method="POST">
                        @csrf

                        <input type="hidden" name="item_id"
                            value="{{ \App\Services\Operations::encryptId($item->id) }}">

                        <div class="mb-3">
                            <label for="titulo" class="form-label font-weight-bold">Título da Avaliação</label>
                            <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="titulo"
                                name="titulo" value="{{ old('titulo') }}"
                                placeholder="Ex: Excelente produto! Recomendo." required>
                            @error('titulo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nota" class="form-label font-weight-bold">Nota (1 a 5)</label>
                            <select class="form-select @error('nota') is-invalid @enderror" id="nota" name="nota"
                                required>
                                <option value="" disabled {{ old('nota') ? '' : 'selected' }}>Selecione uma nota...
                                </option>
                                <option value="5" {{ old('nota') == '5' ? 'selected' : '' }}>5 ★ - Excelente</option>
                                <option value="4" {{ old('nota') == '4' ? 'selected' : '' }}>4 ★ - Muito Bom</option>
                                <option value="3" {{ old('nota') == '3' ? 'selected' : '' }}>3 ★ - Bom</option>
                                <option value="2" {{ old('nota') == '2' ? 'selected' : '' }}>2 ★ - Regular</option>
                                <option value="1" {{ old('nota') == '1' ? 'selected' : '' }}>1 ★ - Ruim</option>
                            </select>
                            @error('nota')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="descricao" class="form-label font-weight-bold">Descrição / Comentário</label>
                            <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao"
                                name="descricao" rows="4" placeholder="Conte com mais detalhes o que achou..."
                                required>{{ old('descricao') }}</textarea>
                            @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Enviar Avaliação</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
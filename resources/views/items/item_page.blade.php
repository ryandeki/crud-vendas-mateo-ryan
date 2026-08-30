@extends('layouts.main_layout')
@section('content')
@include('top_bar')
<div class="container-fluid overflow-hidden">
    <div class="row">
        <div class="col-auto ms-5">
            <p class="display-6 mb-5">{{ $item->nome }}</p>
            <p class="fs-2">R${{ $item->preco }}</p>
        </div>
        <div class="col-3 ms-auto me-5">
            <p class="text-muted small mt-2 mb-1">
                {{ $item->text_note ?? $item->descricao ?? 'Sem descrição' }}
            </p>
            <div class="row mt-5">
                <div class="col-auto">
                    <span class="badge {{ ['new' => 'bg-success', 'almost-new' => 'bg-warning', 'worn-out' => 'bg-danger'][$item->estado] }}">
                        {{ ['new' => 'Novo', 'almost-new' => 'Semi-novo', 'worn-out' => 'Desgastado'][$item->estado] }}
                    </span>
                </div>

                <div class="col-auto">
                    <span class="badge bg-secondary">{{ $item->category->nome }}</span>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-auto">
            <div class="row align-items-center">
                <i class="bi bi-person-circle fs-3 col-auto"></i>
                <p class="col-auto mb-0">{{ $item->user->username; }}</p>
                <small class="text-secondary col-auto">Anunciado em: {{ $item->created_at->format('d/m/Y H:i:s') }}</small>
                @if ($item->created_at != $item->updated_at)
                <small class="text-secondary col-auto">Atualizado em: {{ $item->updated_at->format('d/m/Y H:i:s') }}</small>
                @endif
            </div>
            <small class="text-secondary">E-mail: {{ $item->user->email }}</small>
        </div>
    </div>
</div>
@endsection
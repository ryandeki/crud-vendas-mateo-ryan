<?php

use App\Models\User;
use App\Models\Category;
?>

<div class="col-12 mb-3">
    <div class="card p-4 shadow-sm">
        <div class="row align-items-center">

            <div class="col">
                <div class="row">
                    <i class="fa-solid fa-circle-user"></i>
                    <p>{{ User::find($item->user_id)->username; }}</p>
                </div>

                <h4 class="text-dark fw-bold m-0">
                    {{ $item->text_title ?? $item->nome }}
                </h4>

                <div class="mt-1">
                    <span class="badge {{ ['new' => 'bg-success', 'almost-new' => 'bg-warning', 'worn-out' => 'bg-danger'][$item->estado] }}">
                        {{ ['new' => 'Novo', 'almost-new' => 'Semi-novo', 'worn-out' => 'Desgastado'][$item->estado] }}
                    </span>
                </div>

                <div class="mt-1">
                    <span class="badge bg-secondary">{{ Category::find($item->category_id)->nome }}</span>
                </div>

                <p class="text-muted small mt-2 mb-1">
                    {{ $item->descricao ?? 'Sem descrição' }}
                </p>

                <p class="text-dark mt-3 fs-3">R${{ $item->preco }}</p>

                <small class="text-secondary">
                    Criado em: {{ $item->created_at->format('d/m/Y H:i:s') }}
                </small>
                @if($item->created_at->ne($item->updated_at))
                <small class="text-secondary ms-4">
                    Atualizado em: {{ $item->updated_at->format('d/m/Y H:i:s') }}
                </small>
                @endif
            </div>

            <div class="col text-end d-flex justify-content-end align-items-center gap-2">
                @if ($item->user_id == session('user')['id'])
                <a href="{{ route('deleteItem', Crypt::encrypt($item->id)) }}" class="btn btn-danger px-3"
                    title="Excluir">
                    <i class="bi bi-trash"></i>
                </a>

                <a href="{{ route('edit.item', Crypt::encrypt($item->id)) }}" class="btn btn-secondary px-3"
                    title="Editar">
                    <i class="bi bi-pencil-square"></i>
                </a>
                @endif

                @if($item->status != 'active')
                <button class="btn btn-secondary px-3" disabled title="Item desativada">
                    <i class="bi bi-ban me-2"></i>Acessar
                </button>
                @else
                <a href="{{ route('item.page', \App\Services\Operations::encryptId($item->id)) }}" class="btn btn-primary px-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Acessar
                </a>
                @endif
            </div>

        </div>
    </div>
</div>
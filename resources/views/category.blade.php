<div class="col-12 mb-3">
    <div class="card p-4 shadow-sm">
        <div class="row align-items-center">

            <div class="col">
                <h4 class="text-dark fw-bold m-0">
                    {{ $category->text_title ?? $category->nome }}
                </h4>

                <div class="mt-1">
                    <span class="badge {{ ($category->status == 'active') ? 'bg-success' : 'bg-secondary' }}">
                        {{ $category->status == 'active' ? 'Ativa' : 'Desativada' }}
                    </span>
                </div>

                <p class="text-muted small mt-2 mb-1">
                    {{ $category->text_note ?? $category->descricao ?? 'Sem descrição' }}
                </p>

                <small class="text-secondary">
                    Criado em: {{ $category->created_at->format('d/m/Y H:i:s') }}
                </small>
                @if($category->created_at->ne($category->updated_at))
                <small class="text-secondary ms-4">
                    Atualizado em: {{ $category->updated_at->format('d/m/Y H:i:s') }}
                </small>
                @endif
            </div>

            <div class="col text-end d-flex justify-content-end align-items-center gap-2">
                <a href="{{ route('delete', Crypt::encrypt($category->id)) }}" class="btn btn-danger px-3"
                    title="Excluir">
                    <i class="bi bi-trash"></i>
                </a>

                <a href="{{ route('edit', Crypt::encrypt($category->id)) }}" class="btn btn-secondary px-3"
                    title="Editar">
                    <i class="bi bi-pencil-square"></i>
                </a>

                @if($category->status != 'active')
                <button class="btn btn-secondary px-3" disabled title="Categoria desativada">
                    <i class="bi bi-ban me-2"></i>Acessar
                </button>
                @else
                <a href="{{ route('category.page', Crypt::encrypt($category->id)) }}" class="btn btn-primary px-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Acessar
                </a>
                @endif
            </div>

        </div>
    </div>
</div>
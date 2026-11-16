<div class="col-12 mb-3">
    <div class="card p-4 shadow-sm">
        <div class="row align-items-center">

            <div class="col">
                <h5 class="text-dark fw-bold m-0">
                    {{ $review->titulo }}
                </h5>

                <div class="mt-1 d-flex align-items-center gap-2">
                    <span class="badge bg-warning text-dark fs-6">
                        {{ $review->nota }} ★
                    </span>
                    <small class="text-muted">
                        Por:
                        <strong>{{ $review->user->username ?? $review->user->name ?? $review->user->nome ?? $review->user->email ?? 'Usuário' }}</strong>
                    </small>
                </div>

                <p class="text-muted small mt-2 mb-1">
                    {{ $review->descricao ?? 'Sem descrição' }}
                </p>

                <small class="text-secondary">
                    Avaliado em: {{ $review->created_at->format('d/m/Y H:i:s') }}
                </small>

                @if($review->created_at->ne($review->updated_at))
                <small class="text-secondary ms-4">
                    Atualizado em: {{ $review->updated_at->format('d/m/Y H:i:s') }}
                </small>
                @endif
            </div>

            @if ($review->user_id === session('user')['id'])
            <div class="col-auto text-end">
                <a href="{{ route('deleteReview', \App\Services\Operations::encryptId($review->id)) }}"
                    class="btn btn-danger px-3" title="Excluir Avaliação">
                    <i class="bi bi-trash"></i>
                </a>
            </div>
            @endif

        </div>
    </div>
</div>
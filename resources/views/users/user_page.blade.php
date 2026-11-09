@extends('layouts.main_layout')

@include('top_bar')

@section('content')
<div class="row align-items-center mb-3" style="min-height: 50px">
    <i class="bi bi-person-circle col-auto fs-1"></i>
    <p class="col-auto mb-0 fs-1">{{ session('user')['username'] }}</p>
</div>

<hr>

<div class="row">
    <h2 class="mb-4">Informações de usuário</h2>

    @if(session('edit_success'))
    <div class="alert alert-success text-center">
        {{ session('edit_success') }}
    </div>
    @endif
    
    <form action="{{ route('user.edit.page') }}" method="GET" novalidate>
        @csrf

        <input type="hidden" id="id" name="id" value="{{ \App\Services\Operations::encryptId($user->id) }}">

        <div class="row">
            <div class="col-4 mb-3">
                <label for="text_username" class="form-label">Username:</label>
                <input type="text" class="form-control text-dark" name="text_username"
                    value="{{ $user->username }}" disabled>
                @error('text_username')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="col-4 mb-3">
                <label for="text_email" class="form-label">E-mail:</label>
                <input type="email" class="form-control text-dark" name="text_email"
                    value="{{ $user->email }}" disabled>
                @error('text_email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-4 mb-3 ms-auto me-auto">
            <button type="submit" class="btn btn-secondary w-100">Editar</button>
        </div>
    </form>

    <h2 class="mb-4">Endereço</h2>
    <form action="{{ route('user.adress.page') }}" method="GET" novalidate>
        @csrf

        <input type="hidden" id="id" name="id" value="{{ \App\Services\Operations::encryptId($user->id) }}">

        <div class="row">
            <div class="col-4 mb-3">
                <label for="input_cep" class="form-label">CEP:</label>
                <input type="number" class="form-control text-dark" name="input_cep"
                    value="{{ $user->adress ? $user->adress->cep : '' }}" disabled>
                @error('input_cep')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="col-4 mb-3">
                <label for="text_logradouro" class="form-label">Logradouro:</label>
                <input type="text" class="form-control text-dark" name="text_logradouro"
                    value="{{ $user->adress ? $user->adress->logradouro : '' }}" disabled>
                @error('text_logradouro')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-4 mb-3">
                <label for="input_numero" class="form-label">Número:</label>
                <input type="text" class="form-control text-dark" name="input_numero"
                    value="{{ $user->adress ? $user->adress->numero : '' }}" disabled>
                @error('input_numero')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-4 mb-3">
                <label for="text_complemento" class="form-label">Complemento:</label>
                <input type="text" class="form-control text-dark" name="text_complemento"
                    value="{{ $user->adress ? $user->adress->complemento : '' }}" disabled>
                @error('text_complemento')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-4 mb-3">
                <label for="text_cidade" class="form-label">Cidade:</label>
                <input type="text" class="form-control text-dark" name="text_cidade"
                    value="{{ $user->adress ? $user->adress->cidade : '' }}" disabled>
                @error('text_cidade')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-4 mb-3">
                <label for="text_bairro" class="form-label">Bairro:</label>
                <input type="text" class="form-control text-dark" name="text_bairro"
                    value="{{ $user->adress ? $user->adress->bairro : '' }}" disabled>
                @error('text_bairro')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-4 mb-3">
                <label for="text_uf" class="form-label">UF:</label>
                <input type="text" class="form-control text-dark" name="text_uf"
                    value="{{ $user->adress ? $user->adress->uf : '' }}" disabled>
                @error('text_uf')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-4 mb-3 ms-auto me-auto">
            <button type="submit" class="btn btn-secondary w-100">Editar</button>
        </div>
    </form>
</div>
@endsection
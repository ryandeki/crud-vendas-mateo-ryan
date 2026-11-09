@extends('layouts.main_layout')

@include('top_bar')

@section('content')
<div class="row align-items-center" style="min-height: 50px">
    <i class="bi bi-person-circle col-auto fs-1"></i>
    <p class="col-auto mb-0 fs-1">{{ session('user')['username'] }}</p>
</div>
<div class="row">
    <form action="{{ route('user.adress.confirm') }}" method="POST" novalidate>
        @csrf

        <input type="hidden" id="id" name="id" value="{{ \App\Services\Operations::encryptId($user->id) }}">

        <div class="row">
            <div class="col-4 mb-3">
                <label for="input_cep" class="form-label">*CEP:</label>
                <input type="number" class="form-control text-dark" name="input_cep" id="input_cep"
                    value="{{ $user->adress ? $user->adress->cep : old('input_cep') }}">
                @error('input_cep')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="col-4 mb-3">
                <label for="text_logradouro" class="form-label">Logradouro:</label>
                <input type="text" class="form-control text-dark" name="text_logradouro" id="text_logradouro"
                    value="{{ $user->adress ? $user->adress->logradouro : old('text_logradouro') }}" readonly>
                @error('text_logradouro')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-4 mb-3">
                <label for="input_numero" class="form-label">*Número:</label>
                <input type="text" class="form-control text-dark" name="input_numero" id="input_numero"
                    value="{{ $user->adress ? $user->adress->numero : old('input_numero') }}">
                @error('input_numero')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-4 mb-3">
                <label for="text_complemento" class="form-label">Complemento:</label>
                <input type="text" class="form-control text-dark" name="text_complemento" id="text_complemento"
                    value="{{ $user->adress ? $user->adress->complemento : old('text_complemento') }}">
                @error('text_complemento')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-4 mb-3">
                <label for="text_cidade" class="form-label">Cidade:</label>
                <input type="text" class="form-control text-dark" name="text_cidade" id="text_cidade"
                    value="{{ $user->adress ? $user->adress->cidade : old('text_cidade') }}" readonly>
                @error('text_cidade')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-4 mb-3">
                <label for="text_bairro" class="form-label">Bairro:</label>
                <input type="text" class="form-control text-dark" name="text_bairro" id="text_bairro"
                    value="{{ $user->adress ? $user->adress->bairro : old('text_bairro') }}" readonly>
                @error('text_bairro')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-4 mb-3">
                <label for="text_uf" class="form-label">UF:</label>
                <input type="text" class="form-control text-dark" name="text_uf" id="text_uf"
                    value="{{ $user->adress ? $user->adress->uf : old('text_uf') }}" readonly>
                @error('text_uf')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-4 mb-3">
                <label for="current_password" class="form-label">*Senha atual:</label>
                <input type="password" class="form-control text-dark" name="current_password">
                @error('current_password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        @if(session('edit_error'))
        <div class="alert alert-danger text-center col-4">
            {{ session('edit_error') }}
        </div>
        @endif

        <div class="col-4 mb-3 ms-auto me-auto">
            <button type="submit" class="btn btn-secondary w-100">Salvar</button>
        </div>
    </form>
</div>

<script>
    function limparFormularioCep() {
        document.getElementById('text_logradouro').value = '';
        document.getElementById('text_bairro').value = '';
        document.getElementById('text_cidade').value = '';
        document.getElementById('text_uf').value = '';
    }

    document.getElementById('input_cep').addEventListener('blur', function() {
        // Remove caracteres não numéricos do CEP digitado
        let cep = this.value.replace(/\D/g, '');

        if (cep.length === 8) {
            
            document.getElementById('text_logradouro').value = 'Buscando...';
            document.getElementById('text_bairro').value = 'Buscando...';
            document.getElementById('text_cidade').value = 'Buscando...';
            document.getElementById('text_uf').value = 'Buscando...';

            fetch('https://viacep.com.br/ws/' + cep + '/json/')
                .then(response => response.json())
                .then(data => {
                    if (!data.erro) {
                        document.getElementById('text_logradouro').value = data.logradouro;
                        document.getElementById('text_bairro').value = data.bairro;
                        document.getElementById('text_cidade').value = data.localidade;
                        document.getElementById('text_uf').value = data.uf;
                        
                        document.getElementById('input_numero').focus();
                    } else {
                        alert('CEP não encontrado.');
                        limparFormularioCep();
                    }
                })
                .catch(error => {
                    alert('Erro ao buscar o CEP. Tente preencher manualmente.');
                    limparFormularioCep();
                });
        } else {
            alert('Formato de CEP inválido.');
            limparFormularioCep();
        }
    });

</script>
@endsection
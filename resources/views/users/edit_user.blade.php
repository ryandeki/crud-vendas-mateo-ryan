@extends('layouts.main_layout')

@include('top_bar')

@section('content')
<div class="row align-items-center mb-3 ms-3" style="min-height: 50px">
    <i class="bi bi-person-circle col-auto fs-1"></i>
    <p class="col-auto mb-0 fs-1">{{ session('user')['username'] }}</p>
</div>

<hr>

<div class="row">

    <div class="container ms-4 mb-4 border border-dark rounded-4 p-0">
        <div class="bg-secondary p-3 rounded-top-4 border-bottom border-dark mb-3">
            <h2>Informações de usuário</h2>
        </div>

        <form action="{{ route('user.edit.confirm') }}" method="POST" novalidate>
            @csrf
    
            <input type="hidden" id="id" name="id" value="{{ \App\Services\Operations::encryptId($user->id) }}">
    
            <div class="row ms-3 mb-3">
                <div class="col-4 mb-3">
                    <label for="text_username" class="form-label">Username:</label>
                    <input type="text" class="form-control text-dark" name="text_username"
                        value="{{ $user->username }}">
                    @error('text_username')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
        
                <div class="col-4 mb-3">
                    <label for="text_email" class="form-label">E-mail:</label>
                    <input type="email" class="form-control text-dark" name="text_email"
                        value="{{ $user->email }}">
                    @error('text_email')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
        
                <div class="col-4 mb-3">
                    <label for="new_password" class="form-label">Nova senha:</label>
                    <input type="password" class="form-control text-dark" name="new_password">
                    @error('new_password')
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
                <button type="submit" class="btn btn-primary w-100">Salvar</button>
            </div>
        </form>
    </div>
</div>
@endsection
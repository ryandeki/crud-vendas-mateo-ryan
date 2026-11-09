@extends('layouts.main_layout')

@include('top_bar')

@section('content')
<div class="row align-items-center" style="min-height: 50px">
    <i class="bi bi-person-circle col-auto fs-1"></i>
    <p class="col-auto mb-0 fs-1">{{ session('user')['username'] }}</p>
</div>
<div class="row">
    @if(session('edit_success'))
    <div class="alert alert-success text-center">
        {{ session('edit_success') }}
    </div>
    @endif
    
    <form action="{{ route('user.edit.page') }}" method="GET" novalidate>
        @csrf

        <input type="hidden" id="id" name="id" value="{{ \App\Services\Operations::encryptId($user->id) }}">

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

        <div class="col-4 mb-3 ms-auto me-auto">
            <button type="submit" class="btn btn-secondary w-100">Editar</button>
        </div>
    </form>
</div>
@endsection
@extends('layouts.main_layout')

@section('content')
<div class="container min-vh-100 d-flex align-items-center justify-content-center py-4">
    <div class="row justify-content-center w-100">
        <div class="col-12 col-sm-9 col-md-5 col-lg-5">
            <div class="card p-3 p-md-4 shadow-sm">

                <div class="text-center mb-3">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Seller logo" class="img-fluid"
                        style="max-width: 220px;">
                </div>

                <div class="row justify-content-center">
                    <div class="col-12">
                        <form action="{{ route('login.submit')}}" method="POST" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="text_username" class="form-label">Username:</label>
                                <input type="email" class="form-control text-dark" name="text_username"
                                    value="{{ old('text_username') }}">
                                @error('text_username')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="text_password" class="form-label">Senha:</label>
                                <input type="password" class="form-control text-dark" name="text_password"
                                    value="{{ old('text_password') }}">
                                @error('text_password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100">LOGIN</button>
                            </div>
                        </form>
                        @if(session('login_error'))
                        <div class="alert alert-danger text-center">
                            {{ session('login_error') }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="text-center text-dark mt-2">
                    <small>&copy; {{ date('Y') }} Seller</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
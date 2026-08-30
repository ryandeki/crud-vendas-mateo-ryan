@extends('layouts.main_layout')
@section('content')
@include('top_bar')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col">

            <div class="col card p-5 text-center">
                <span class="display-3 mb-3"><i
                        class="fa-solid fa-triangleexclamation text-warning opacity-50"></i></span>
                <h4 class="text-primary mb-3">{{ $item->nome }}</h4>
                <p class="text">Confirma a exclusão desse item?</p>
                <div class="mt-3">
                    <a href="{{ route('home') }}" class="btn btn-primary px-5 m-2"><i
                            class="fa-solid fa-xmark me-2"></i>Não</a>
                    <a href="{{ route('delete.item.confirm', \App\Services\Operations::encryptId($item->id)) }}"
                        class="btn btn-danger px-5 m-2"><i class="fa-solid fa-trash me-2"></i>Sim</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
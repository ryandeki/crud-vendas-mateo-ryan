@extends('layouts.main_layout')

@section('content')

@include('top_bar')

<div class="container-fluid overflow-hidden px-4 mt-3">
    <h4 class="text-dark fw-bold m-0">Minhas Categorias</h4>
    @if(!$categories->isEmpty())
    <div class="row align-items-center mb-4">
        <div class="col text-end">
            <a href="{{ route('new') }}" class="btn btn-primary px-3">
                <i class="fa-regular fa-pen-to-square me-2"></i>Nova Categoria
            </a>
        </div>
    </div>
    @endif

    @if($categories->isEmpty())
    <div class="row mt-5">
        <div class="col text-center">
            <p class="mb-4 text-dark fs-5">Você ainda não tem nenhuma categoria cadastrada!</p>
            <a href="{{ route('new') }}" class="btn btn-primary px-4 py-2">
                <i class="fa-regular fa-pen-to-square me-2"></i>Criar Sua Primeira Categoria
            </a>
        </div>
    </div>
    @else
    <div class="row">
        @foreach($categories->sortByDesc('created_at') as $category)
        @include('category')
        @endforeach
    </div>
    @endif

</div>

@endsection
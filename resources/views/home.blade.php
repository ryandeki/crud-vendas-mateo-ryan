@extends('layouts.main_layout')

@section('content')

@include('top_bar')

<div class="container-fluid overflow-hidden px-4 mt-3">
    <h4 class="text-dark fw-bold m-0">Página Inicial</h4>
    @if($items->isEmpty())
    <div class="row mt-5">
        <div class="col text-center">
            <p class="mb-4 text-dark fs-5">Nenhum item anunciado para compra</p>
            <a href="{{ route('newItem') }}" class="btn btn-primary px-4 py-2">
                <i class="fa-regular fa-pen-to-square me-2"></i>Anuncie um item!
            </a>
        </div>
    </div>
    @else
    <div class="row align-items-center mb-4">
        <div class="col text-end">
            <a href="{{ route('newItem') }}" class="btn btn-primary px-3">
                <i class="fa-regular fa-pen-to-square me-2"></i>Anunciar um novo item
            </a>
        </div>
    </div>

    <div class="row">
        @foreach($items->sortByDesc('created_at') as $item)
        @include('items.item')
        @endforeach
    </div>
    @endif

</div>

@endsection
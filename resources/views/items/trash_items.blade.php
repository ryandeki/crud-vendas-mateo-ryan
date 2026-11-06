@extends('layouts.main_layout')

@section('content')

@include('top_bar')

<div class="container-fluid overflow-hidden px-4 mt-3">
    <h4 class="text-dark fw-bold m-0">Lixeira</h4>
    @if($items->isEmpty())
    <div class="row mt-5">
        <div class="col text-center">
            <p class="mb-4 text-dark fs-5">Você não tem nenhum item na lixeira</p>
        </div>
    </div>
    @else

    <div class="row">
        @foreach($items->sortByDesc('deleted_at') as $item)
        @include('items.item')
        @endforeach
    </div>
    @endif

</div>

@endsection
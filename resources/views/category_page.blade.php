@extends('layouts.main_layout')
@section('content')
@include('top_bar')
<div class="container-fluid overflow-hidden">
    <div class="row">
        <div class="col text-center">
            <p class="display-6 mb-0">{{ $category->nome }}</p>
            <p class="text-muted small mt-2 mb-1">
                {{ $category->text_note ?? $category->descricao ?? 'Sem descrição' }}
            </p>
        </div>
    </div>
</div>
@endsection
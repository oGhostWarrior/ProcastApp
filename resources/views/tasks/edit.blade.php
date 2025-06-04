@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Teste de Procrastinação') }}
    </h2>
@endsection

    @section('content') {{-- Use 'content' ou 'slot', mas seja consistente --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('tasks.update', $task) }}">
                        @csrf
                        @method('PUT')
                        @include('tasks.form', ['task' => $task]) {{-- Passa a tarefa para preencher o formulário --}}
                        <button class="mt-4">
                            {{ __('Atualizar Tarefa') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

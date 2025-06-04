@extends('layouts.app') {{-- Mantemos layouts.app --}}

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Criar Nova Tarefa') }} {{-- TÍTULO CORRIGIDO --}}
    </h2>
@endsection

@section('content') {{-- Use 'content' ou 'slot', mas seja consistente --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf
                        @include('tasks.form', ['task' => null]) {{-- Inclui o formulário reutilizável --}}
                        <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Salvar Tarefa') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

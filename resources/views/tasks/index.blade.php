@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Minhas Tarefas') }} {{-- TÍTULO CORRIGIDO --}}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        {{-- Botão Nova Tarefa - HTML puro com classes Tailwind --}}
                        <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Nova Tarefa') }}
                        </a>
                    </div>

                    @if($tasks->isEmpty())
                        <p>Nenhuma tarefa cadastrada ainda. Que tal criar uma?</p>
                    @else
                        <ul class="divide-y divide-gray-200">
                            @foreach($tasks as $task)
                                <li class="py-4 flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold {{ $task->status === 'completed' ? 'line-through text-gray-500' : '' }}">{{ $task->title }}</h3>
                                        @if($task->description)
                                            <p class="text-sm text-gray-600">{{ $task->description }}</p>
                                        @endif
                                        @if($task->due_date)
                                            <p class="text-xs text-gray-500">Prazo: {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y H:i') }}</p>
                                        @endif
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('tasks.edit', $task) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta tarefa?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                        </form>
                                        @if($task->status === 'pending')
                                            <form action="{{ route('tasks.update', $task) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="completed">
                                                <input type="hidden" name="title" value="{{ $task->title }}"> {{-- Adicione os campos necessários para validação --}}
                                                <input type="hidden" name="priority" value="{{ $task->priority }}">
                                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600">
                                                    Concluir
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

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
                    <h3 class="text-2xl font-bold mb-4">Olá, {{ $user->name }}!</h3>

                    @if($motivationalPhrase)
                        <div class="bg-indigo-50 border-l-4 border-indigo-500 text-indigo-700 p-4 mb-6" role="alert">
                            <p class="font-bold">Frase Motivacional do Dia:</p>
                            <p>"{{ $motivationalPhrase->phrase }}" @if($motivationalPhrase->author)- {{ $motivationalPhrase->author }}@endif</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h4 class="text-xl font-semibold mb-2">Seu Tipo de Procrastinação:</h4>
                            @if($procrastinationType)
                                <p class="text-lg text-gray-700 font-medium">{{ $procrastinationType->name }}</p>
                                <p class="text-sm text-gray-600">{{ $procrastinationType->description }}</p>
                            @else
                                <p>Você ainda não fez o teste de procrastinação. <a href="{{ route('procrastination-test.index') }}" class="text-indigo-600 hover:underline">Faça agora!</a></p>
                            @endif
                        </div>

                        <div>
                            <h4 class="text-xl font-semibold mb-2">Seu Progresso:</h4>
                            <p class="text-gray-700">Tarefas Concluídas (Total): <span class="font-bold">{{ $totalTasksCompleted }}</span></p>
                            <p class="text-gray-700">Tarefas Concluídas (Hoje): <span class="font-bold">{{ $tasksCompletedToday }}</span></p>
                            <p class="text-gray-700">Tarefas Concluídas (Esta Semana): <span class="font-bold">{{ $tasksCompletedThisWeek }}</span></p>
                            <p class="text-gray-700">Tempo Total de Foco (Minutos): <span class="font-bold">{{ $totalFocusMinutes }}</span></p>

                            {{-- Exemplo de barra de progresso simples (pode ser mais complexo com metas) --}}
                            <div class="mt-4">
                                <h5 class="text-lg font-medium mb-1">Progresso Geral:</h5>
                                @php
                                    $progressPercentage = ($totalTasksCompleted > 0) ? min(100, $totalTasksCompleted / 10 * 100) : 0; // Exemplo: 10 tarefas para 100%
                                @endphp
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                                </div>
                                <p class="text-right text-sm text-gray-600 mt-1">{{ round($progressPercentage) }}%</p>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
@endsection

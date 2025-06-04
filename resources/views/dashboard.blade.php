@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Bem-vindo(a) ao seu Anti-Procrastinação!</h3>

                    <p class="mb-4">Aqui você pode gerenciar suas tarefas, focar com a Técnica Pomodoro e acompanhar seu progresso.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-indigo-100 p-6 rounded-lg shadow-md">
                            <h4 class="text-xl font-semibold text-indigo-800 mb-2">Minhas Tarefas</h4>
                            <p class="text-gray-700 mb-4">Crie, organize e conclua suas atividades.</p>
                            <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Ver Tarefas
                            </a>
                        </div>

                        <div class="bg-green-100 p-6 rounded-lg shadow-md">
                            <h4 class="text-xl font-semibold text-green-800 mb-2">Foco Pomodoro</h4>
                            <p class="text-gray-700 mb-4">Use o temporizador para sessões de foco ininterrupto.</p>
                            <a href="{{ route('pomodoro.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Iniciar Foco
                            </a>
                        </div>

                        <div class="bg-purple-100 p-6 rounded-lg shadow-md">
                            <h4 class="text-xl font-semibold text-purple-800 mb-2">Meu Progresso</h4>
                            <p class="text-gray-700 mb-4">Acompanhe suas estatísticas e seu tipo de procrastinação.</p>
                            <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Ver Perfil
                            </a>
                        </div>
                    </div>

                    @if (!Auth::user()->procrastinationTestResult)
                        <div class="mt-8 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                            <p class="font-bold">Atenção!</p>
                            <p>Para uma experiência mais personalizada, faça nosso <a href="{{ route('procrastination-test.index') }}" class="underline font-medium">Teste de Procrastinação</a>.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

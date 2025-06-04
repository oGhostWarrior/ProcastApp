<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title> {{-- Usará o nome do seu app definido no .env --}}

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="{{ mix('js/app.js') }}" defer></script>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-center justify-center min-h-screen bg-gray-100 sm:items-center sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-md mx-auto p-6 bg-white shadow-md rounded-lg text-center">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-4">
                    Pare de Procrastinar, Comece a Agir!
                </h1>
                <p class="text-lg text-gray-700 mb-6">
                    Sua jornada para a produtividade começa aqui.
                    Organize suas tarefas, use a técnica Pomodoro e acompanhe seu progresso.
                </p>

                <div class="space-y-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Ir para o Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Fazer Login
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Criar Conta
                        </a>
                    @endauth
                </div>

                <div class="mt-8 text-center text-sm text-gray-500">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </div>
            </div>
        </div>
    </body>
</html>

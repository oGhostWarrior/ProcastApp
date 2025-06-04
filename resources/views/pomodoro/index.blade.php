@extends('layouts.app') {{-- Mantemos layouts.app --}}

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Foco Pomodoro') }} {{-- TÍTULO CORRIGIDO --}}
    </h2>
@endsection

@section('content') {{-- Use 'content' ou 'slot', mas seja consistente --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <h3 class="text-3xl font-bold mb-6">Hora de Focar!</h3>

                    <div id="pomodoro-timer" class="text-6xl font-extrabold mb-8 text-indigo-700">
                        25:00
                    </div>

                    <p id="pomodoro-status" class="text-xl mb-4 text-gray-600">Modo: Foco</p>
                    <p id="pomodoro-cycle" class="text-md mb-8 text-gray-500">Ciclos concluídos: 0</p>

                    <div class="flex justify-center space-x-4">
                        {{-- SUBSTITUINDO X-COMPONENTS POR HTML PURO COM CLASSES TAILWIND --}}
                        <button id="start-button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Iniciar Foco') }}
                        </button>
                        <button id="pause-button" class="hidden inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Pausar') }}
                        </button>
                        <button id="reset-button" class="hidden inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Reiniciar') }}
                        </button>
                    </div>

                    <div class="mt-8 text-sm text-gray-500">
                        <p>Duração do Foco: {{ $defaultFocusDuration }} min</p>
                        <p>Duração do Descanso: {{ $defaultBreakDuration }} min</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Lógica do temporizador Pomodoro em JavaScript
            // ... (Seu código JavaScript permanece o mesmo) ...
            const timerDisplay = document.getElementById('pomodoro-timer');
            const statusDisplay = document.getElementById('pomodoro-status');
            const cycleDisplay = document.getElementById('pomodoro-cycle');
            const startButton = document.getElementById('start-button');
            const pauseButton = document.getElementById('pause-button');
            const resetButton = document.getElementById('reset-button');

            let timer;
            let totalSeconds;
            let isPaused = true;
            let isFocusMode = true;
            let cyclesCompleted = 0;
            let currentSessionId = null; // Para armazenar o ID da sessão no banco de dados

            // Garanta que essas variáveis estão sendo passadas do controller
            const focusDuration = {{ $defaultFocusDuration * 60 }}; // segundos
            const breakDuration = {{ $defaultBreakDuration * 60 }}; // segundos
            const longBreakDuration = {{ $defaultLongBreakDuration * 60 }}; // segundos
            const cyclesBeforeLongBreak = {{ $defaultCyclesBeforeLongBreak }};

            function updateDisplay() {
                const minutes = Math.floor(totalSeconds / 60);
                const seconds = totalSeconds % 60;
                timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }

            async function startTimer() {
                if (!isPaused) return;

                isPaused = false;
                startButton.classList.add('hidden');
                pauseButton.classList.remove('hidden');
                resetButton.classList.remove('hidden');

                if (currentSessionId === null) {
                    // Inicia uma nova sessão no backend
                    try {
                        const response = await fetch('{{ route('pomodoro.start') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                focus_duration: {{ $defaultFocusDuration }},
                                break_duration: {{ $defaultBreakDuration }},
                            }),
                        });
                        const data = await response.json();
                        if (response.ok) {
                            currentSessionId = data.session_id;
                        } else {
                            console.error('Erro ao iniciar sessão:', data.message);
                        }
                    } catch (error) {
                        console.error('Erro de rede:', error);
                    }
                }


                timer = setInterval(() => {
                    if (totalSeconds <= 0) {
                        clearInterval(timer);
                        playSound(); // Opcional: Adicione um som
                        if (isFocusMode) {
                            cyclesCompleted++;
                            cycleDisplay.textContent = `Ciclos concluídos: ${cyclesCompleted}`;
                            statusDisplay.textContent = 'Modo: Descanso';

                            if (cyclesCompleted % cyclesBeforeLongBreak === 0) {
                                totalSeconds = longBreakDuration;
                            } else {
                                totalSeconds = breakDuration;
                            }
                            isFocusMode = false;
                        } else {
                            statusDisplay.textContent = 'Modo: Foco';
                            totalSeconds = focusDuration;
                            isFocusMode = true;
                        }
                        // Reinicia o timer automaticamente para o próximo modo
                        isPaused = true; // Permite o próximo ciclo iniciar
                        if (currentSessionId) {
                            endSession(currentSessionId); // Registra o fim da sessão atual
                            currentSessionId = null; // Zera para a próxima iniciar uma nova
                        }
                        startTimer(); // Inicia o próximo ciclo
                    } else {
                        totalSeconds--;
                        updateDisplay();
                    }
                }, 1000);
            }

            async function endSession(sessionId) {
                try {
                    const response = await fetch('{{ route('pomodoro.end') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ session_id: sessionId }),
                    });
                    const data = await response.json();
                    if (!response.ok) {
                        console.error('Erro ao encerrar sessão:', data.message);
                    }
                } catch (error) {
                    console.error('Erro de rede ao encerrar sessão:', error);
                }
            }


            function pauseTimer() {
                clearInterval(timer);
                isPaused = true;
                startButton.classList.remove('hidden');
                pauseButton.classList.add('hidden');
            }

            function resetTimer() {
                clearInterval(timer);
                isPaused = true;
                isFocusMode = true;
                cyclesCompleted = 0;
                totalSeconds = focusDuration;
                updateDisplay();
                statusDisplay.textContent = 'Modo: Foco';
                cycleDisplay.textContent = 'Ciclos concluídos: 0';
                startButton.classList.remove('hidden');
                pauseButton.classList.add('hidden');
                resetButton.classList.add('hidden');

                if (currentSessionId) {
                    endSession(currentSessionId); // Garante que a sessão atual seja finalizada
                    currentSessionId = null;
                }
            }

            function playSound() {
                // Opcional: Implemente um som curto ao final de cada ciclo
                // let audio = new Audio('/path/to/your/sound.mp3');
                // audio.play();
            }

            // Event Listeners
            startButton.addEventListener('click', startTimer);
            pauseButton.addEventListener('click', pauseTimer);
            resetButton.addEventListener('click', resetTimer);

            // Inicialização
            totalSeconds = focusDuration;
            updateDisplay();
        </script>
    @endpush
@endsection

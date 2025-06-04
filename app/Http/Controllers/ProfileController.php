<?php

namespace App\Http\Controllers;

use App\Models\MotivationalPhrase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Exibe o perfil do usuário, progresso e frase motivacional.
     */
    public function show()
    {
        $user = Auth::user();

        // **Dados do Tipo de Procrastinação**
        $procrastinationType = $user->procrastinationTestResult ? $user->procrastinationTestResult->procrastinationType : null;

        // **Dados de Progresso**
        $totalTasksCompleted = $user->tasks()->where('status', 'completed')->count();
        $tasksCompletedToday = $user->tasks()->where('status', 'completed')
                                    ->whereDate('updated_at', Carbon::today())
                                    ->count();
        $tasksCompletedThisWeek = $user->tasks()->where('status', 'completed')
                                     ->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                     ->count();

        $totalFocusMinutes = $user->pomodoroSessions()->sum('focus_duration');


        // **Frase Motivacional Diária**
        // Seleciona uma frase aleatória
        $motivationalPhrase = MotivationalPhrase::inRandomOrder()->first();


        return view('profile.show', compact(
            'user',
            'procrastinationType',
            'totalTasksCompleted',
            'tasksCompletedToday',
            'tasksCompletedThisWeek',
            'totalFocusMinutes',
            'motivationalPhrase'
        ));
    }
}

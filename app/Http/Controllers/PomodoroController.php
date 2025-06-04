<?php

namespace App\Http\Controllers;

use App\Models\PomodoroSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Para manipulação de datas/horas

class PomodoroController extends Controller
{
    /**
     * Exibe a tela do temporizador Pomodoro.
     */
    public function index()
    {
        // Aqui você pode passar configurações padrão do pomodoro
        $defaultFocusDuration = 25; // minutos
        $defaultBreakDuration = 5;  // minutos
        $defaultLongBreakDuration = 15; // minutos
        $defaultCyclesBeforeLongBreak = 4;

        // O temporizador em si será JavaScript ou Livewire no frontend
        return view('pomodoro.index', compact(
            'defaultFocusDuration',
            'defaultBreakDuration',
            'defaultLongBreakDuration',
            'defaultCyclesBeforeLongBreak'
        ));
    }

    /**
     * Registra o início de uma sessão Pomodoro.
     * (Isso pode ser chamado por um AJAX do frontend)
     */
    public function start(Request $request)
    {
        $request->validate([
            'focus_duration' => 'required|integer|min:1',
            'break_duration' => 'required|integer|min:1',
        ]);

        // Simplesmente registra o início. O 'ended_at' será null até o fim da sessão.
        $session = Auth::user()->pomodoroSessions()->create([
            'focus_duration' => $request->focus_duration,
            'break_duration' => $request->break_duration,
            'started_at' => Carbon::now(),
            'ended_at' => null, // Será atualizado no método `end`
        ]);

        return response()->json(['message' => 'Sessão Pomodoro iniciada.', 'session_id' => $session->id]);
    }

    /**
     * Registra o fim de uma sessão Pomodoro.
     * (Isso será chamado por um AJAX do frontend)
     */
    public function end(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:pomodoro_sessions,id',
        ]);

        $session = PomodoroSession::find($request->session_id);

        if (!$session || $session->user_id !== Auth::id()) {
            return response()->json(['message' => 'Sessão não encontrada ou não pertence ao usuário.'], 403);
        }

        $session->ended_at = Carbon::now();
        $session->save();

        return response()->json(['message' => 'Sessão Pomodoro concluída.']);
    }
}

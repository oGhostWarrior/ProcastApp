<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Certifique-se de ter essa linha
use App\Http\Controllers\ProcrastinationTestController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PomodoroController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome'); // Ou redirecione para login se preferir
});

// Rotas de Autenticação Manual (substituindo Breeze)
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


// Rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    // Redireciona para o teste se não o fez
    Route::get('/dashboard', function () {
        if (!Auth::user()->procrastinationTestResult) {
            return redirect()->route('procrastination-test.index');
        }
        return view('dashboard'); // Ou sua view de dashboard principal
    })->name('dashboard');

    // Rotas do teste de procrastinação
    Route::get('/test-procrastination', [ProcrastinationTestController::class, 'index'])->name('procrastination-test.index');
    Route::post('/test-procrastination', [ProcrastinationTestController::class, 'store'])->name('procrastination-test.store');

    // Rotas das tarefas (CRUD)
    Route::resource('tasks', TaskController::class);

    // Rotas do Pomodoro
    Route::get('/pomodoro', [PomodoroController::class, 'index'])->name('pomodoro.index');
    Route::post('/pomodoro/start', [PomodoroController::class, 'start'])->name('pomodoro.start');
    Route::post('/pomodoro/end', [PomodoroController::class, 'end'])->name('pomodoro.end');

    // Rotas do perfil e estatísticas
    Route::get('/my-profile', [ProfileController::class, 'show'])->name('profile.show');
});

// Remova as rotas Auth::routes() ou a inclusão de auth.php se existirem
// Ex: // Auth::routes();
// Ex: // require __DIR__.'/auth.php';

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // --- Relacionamentos ---

    /**
     * Um usuário pode ter muitos resultados de testes de procrastinação, mas geralmente um.
     * Usamos hasOne porque esperamos apenas um resultado ativo por usuário no seu MVP.
     */
    public function procrastinationTestResult()
    {
        return $this->hasOne(ProcrastinationTestResult::class);
    }

    /**
     * Um usuário pode ter muitas tarefas.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Um usuário pode ter muitas sessões Pomodoro.
     */
    public function pomodoroSessions()
    {
        return $this->hasMany(PomodoroSession::class);
    }
}

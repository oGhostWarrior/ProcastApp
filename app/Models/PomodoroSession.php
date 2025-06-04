<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PomodoroSession extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'focus_duration',
        'break_duration',
        'started_at',
        'ended_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'started_at' => 'datetime', // Converte para objeto Carbon
        'ended_at' => 'datetime',   // Converte para objeto Carbon
    ];

    // --- Relacionamentos ---

    /**
     * Uma sessão Pomodoro pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

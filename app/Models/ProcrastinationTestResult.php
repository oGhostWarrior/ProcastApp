<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcrastinationTestResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'procrastination_type_id',
        'answers', // Para armazenar as respostas como JSON
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'answers' => 'array', // Converte automaticamente o campo 'answers' de/para array JSON
    ];

    // --- Relacionamentos ---

    /**
     * Um resultado de teste pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Um resultado de teste pertence a um tipo de procrastinação.
     */
    public function procrastinationType()
    {
        return $this->belongsTo(ProcrastinationType::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcrastinationType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    // --- Relacionamentos ---

    /**
     * Um tipo de procrastinação pode ser associado a muitos resultados de testes.
     */
    public function procrastinationTestResults()
    {
        return $this->hasMany(ProcrastinationTestResult::class);
    }
}

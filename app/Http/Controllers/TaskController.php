<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Exibe a lista de tarefas do usuário.
     */
    public function index()
    {
        $tasks = Auth::user()->tasks()->orderBy('due_date')->get();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Exibe o formulário para criar uma nova tarefa.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Armazena uma nova tarefa no banco de dados.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        Auth::user()->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
            'status' => 'pending', // Sempre começa como pendente
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso!');
    }

    /**
     * Exibe o formulário para editar uma tarefa existente.
     */
    public function edit(Task $task)
    {
        // Garante que o usuário é o dono da tarefa
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }
        return view('tasks.edit', compact('task'));
    }

    /**
     * Atualiza uma tarefa no banco de dados.
     */
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,completed',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
            'status' => $request->status,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada com sucesso!');
    }

    /**
     * Remove uma tarefa do banco de dados.
     */
    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tarefa excluída com sucesso!');
    }
}

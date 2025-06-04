<?php

namespace App\Http\Controllers;

use App\Models\ProcrastinationTestResult;
use App\Models\ProcrastinationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProcrastinationTestController extends Controller
{
    /**
     * Exibe o formulário do teste de procrastinação.
     */
    public function index()
    {
        // Verifica se o usuário já fez o teste
        if (Auth::user()->procrastinationTestResult) {
            // Se já fez, redireciona para o dashboard ou para a tela de perfil
            return redirect()->route('dashboard')->with('info', 'Você já realizou o teste de procrastinação.');
        }

        // Você pode carregar as perguntas do teste aqui, talvez de um array ou do banco de dados.
        // Para simplicidade inicial, vamos usar um array mockado.
        $questions = [
            [
                'id' => 1,
                'question' => 'Quando você tem uma tarefa grande, como você geralmente se sente?',
                'options' => [
                    'a' => 'Perdido(a) e sobrecarregado(a).',
                    'b' => 'Ansioso(a) com a possibilidade de falhar.',
                    'c' => 'Preferiria fazer algo mais divertido agora.',
                    'd' => 'Distraído(a) com outras coisas, mesmo que menos importantes.'
                ]
            ],
            [
                'id' => 2,
                'question' => 'Com que frequência você adia o início de uma tarefa até o último minuto?',
                'options' => [
                    'a' => 'Quase sempre, preciso de um prazo iminente para começar.',
                    'b' => 'Frequentemente, por medo de que não saia perfeito.',
                    'c' => 'Sempre que posso encontrar algo mais prazeroso para fazer.',
                    'd' => 'Quando me sinto confuso(a) sobre por onde começar.'
                ]
            ],
            // Adicione mais perguntas aqui para cobrir os tipos de procrastinação
            // Lembre-se de mapear as respostas para os tipos de procrastinação
        ];

        return view('procrastination_test.index', compact('questions'));
    }

    /**
     * Processa as respostas do teste e salva o resultado.
     */
    public function store(Request $request)
    {
        // Validação básica (ajuste conforme suas perguntas)
        $request->validate([
            'q1' => 'required',
            'q2' => 'required',
            // Adicione validação para todas as perguntas
        ]);

        $user = Auth::user();

        // Evita que o usuário faça o teste múltiplas vezes (se desejar)
        if ($user->procrastinationTestResult) {
            return redirect()->route('dashboard')->with('error', 'Você já realizou o teste de procrastinação.');
        }

        // Lógica para determinar o tipo de procrastinação
        // Esta é a parte mais complexa e crucial. Você pode usar:
        // 1. Um sistema de pontos por resposta.
        // 2. Regras condicionais (if/else if) baseadas nas respostas.
        // 3. Para um MVP, comece com algo simples, talvez apenas algumas regras que levam a um tipo.

        $answers = $request->all(); // Armazena todas as respostas

        // Exemplo Simplificado de Lógica de Tipagem:
        $typeDetermined = null;
        if ($answers['q1'] === 'b' || $answers['q2'] === 'b') { // Exemplo para Ansioso/Perfeccionista
            $typeDetermined = ProcrastinationType::where('name', 'Perfeccionista')->first();
            if (!$typeDetermined) { // Se o tipo não existe, crie um ou use um padrão
                $typeDetermined = ProcrastinationType::firstOrCreate(['name' => 'Perfeccionista']);
            }
        } elseif ($answers['q1'] === 'c' || $answers['q2'] === 'c') { // Exemplo para Receptivo ao Prazer
            $typeDetermined = ProcrastinationType::where('name', 'Receptivo ao Prazer')->first();
            if (!$typeDetermined) {
                 $typeDetermined = ProcrastinationType::firstOrCreate(['name' => 'Receptivo ao Prazer']);
            }
        }
        // ... adicione mais lógica para outros tipos

        // Se nenhum tipo for determinado, use um padrão ou marque como nulo
        if (!$typeDetermined) {
            $typeDetermined = ProcrastinationType::where('name', 'Indeciso')->first(); // Exemplo de fallback
            if (!$typeDetermined) {
                 $typeDetermined = ProcrastinationType::firstOrCreate(['name' => 'Indeciso']);
            }
        }


        ProcrastinationTestResult::create([
            'user_id' => $user->id,
            'procrastination_type_id' => $typeDetermined ? $typeDetermined->id : null,
            'answers' => json_encode($answers), // Armazena as respostas em JSON
        ]);

        return redirect()->route('dashboard')->with('success', 'Teste de procrastinação concluído com sucesso!');
    }
}

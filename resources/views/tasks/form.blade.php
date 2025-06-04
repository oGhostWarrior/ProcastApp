<div class="mb-4">
    <label for="title" class="block font-medium text-sm text-gray-700">Título da Tarefa</label>
    <input id="title" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="text" name="title" value="{{ old('title', $task->title ?? '') }}" required autofocus />
    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
</div>

<div class="mb-4">
    <label for="description" class="block font-medium text-sm text-gray-700">Descrição (Opcional)</label>
    <textarea id="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="description">{{ old('description', $task->description ?? '') }}</textarea>
    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
</div>

<div class="mb-4">
    <label for="due_date" class="block font-medium text-sm text-gray-700">Prazo (Opcional)</label>
    <input id="due_date" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="datetime-local" name="due_date" value="{{ old('due_date', isset($task->due_date) ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d\TH:i') : '') }}" />
    @error('due_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
</div>

<div class="mb-4">
    <label for="priority" class="block font-medium text-sm text-gray-700">Prioridade</label>
    <select id="priority" name="priority" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
        <option value="low" {{ old('priority', $task->priority ?? '') == 'low' ? 'selected' : '' }}>Baixa</option>
        <option value="medium" {{ old('priority', $task->priority ?? '') == 'medium' ? 'selected' : '' }}>Média</option>
        <option value="high" {{ old('priority', $task->priority ?? '') == 'high' ? 'selected' : '' }}>Alta</option>
    </select>
    @error('priority') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
</div>

@if($task) {{-- Apenas para edição --}}
    <div class="mb-4">
        <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
        <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
            <option value="pending" {{ old('status', $task->status ?? '') == 'pending' ? 'selected' : '' }}>Pendente</option>
            <option value="completed" {{ old('status', $task->status ?? '') == 'completed' ? 'selected' : '' }}>Concluída</option>
        </select>
        @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
@endif

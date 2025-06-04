@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Teste de Procrastinação') }}
    </h2>
@endsection

    @section('content') {{-- Use 'content' ou 'slot', mas seja consistente --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Descubra seu tipo de procrastinação!</h3>
                    <form method="POST" action="{{ route('procrastination-test.store') }}">
                        @csrf

                        @foreach($questions as $q)
                            <div class="mb-4">
                                <p class="font-medium mb-2">{{ $q['id'] }}. {{ $q['question'] }}</p>
                                @foreach($q['options'] as $key => $option)
                                    <label class="inline-flex items-center mt-2">
                                        <input type="radio" class="form-radio" name="q{{ $q['id'] }}" value="{{ $key }}" required>
                                        <span class="ml-2 text-gray-700">{{ $option }}</span>
                                    </label><br>
                                @endforeach
                                @error('q' . $q['id'])
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Concluir Teste') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

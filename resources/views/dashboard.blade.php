<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Survey List
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 text-gray-900">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
            
            @endif
            
            @livewire('survey-display')
        </div>
    </x-app-layout>

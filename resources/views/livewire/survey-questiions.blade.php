<main class="flex-1 flex items-center justify-center w-full">
    <x-filament::section class="w-full max-w-2xl mx-auto">
        <x-slot name="heading">
            Survey Questions
        </x-slot>

        <form wire:submit.prevent="create" class="bg-white p-6 rounded shadow-md w-full">
            @foreach($survey->questions as $index => $question)
                @php
                    $options = array_map('trim', explode(',', $question->options));
                    $required = $question->is_required == 1 ? 'required' : '';
                @endphp

                <div class="mb-6">
                    <p class="font-semibold text-gray-800">{{ $question->question_text }}</p>

                    @if($question->question_type === 'text')
                        <textarea 
                            id="question_{{ $question->id }}" 
                            wire:model.defer="responses.{{ $question->id }}" 
                            class="mt-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline"
                            {{ $required }}
                            >
                        </textarea>

                    @elseif($question->question_type === 'rating')
                        <x-filament::input.wrapper class="mt-2">
                            <x-filament::input.select wire:model.defer="responses.{{ $question->id }}">
                                <option value=""></option>
                                @for ($rating = 1; $rating <= $question->rating_scale; $rating++)
                                    <option value="{{ $rating }}">{{ $rating }}</option>
                                @endfor
                            </x-filament::input.select>
                        </x-filament::input.wrapper>

                    @elseif($question->question_type === 'single_choice')
                        <div class="mt-2 space-y-2">
                            @foreach($options as $key => $option)
                                <div>
                                    <input 
                                        type="radio" 
                                        id="single_choice_{{ $question->id }}_{{ $key }}" 
                                        name="responses[{{ $question->id }}]" 
                                        wire:model.defer="responses.{{ $question->id }}" 
                                        value="{{ $option }}"
                                        class="mr-2">
                                    <label for="single_choice_{{ $question->id }}_{{ $key }}">{{ $option }}</label>
                                </div>
                            @endforeach
                        </div>

                    @elseif($question->question_type === 'multiple_choice')
                        <div class="mt-2 space-y-2">
                            @foreach($options as $key => $option)
                                <div>
                                    <input 
                                        type="checkbox"
                                        id="multiple_choice_{{ $question->id }}_{{ $key }}" 
                                        wire:model.defer="responses.{{ $question->id }}.{{ $key }}" 
                                        value="{{ $option }}"
                                        class="mr-2">
                                    <label for="multiple_choice_{{ $question->id }}_{{ $key }}">{{ $option }}</label>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach

            <div class="mt-6 flex items-center space-x-2">
                {{-- Submit button hidden during loading --}}
                <input 
                    type="submit" 
                    value="Submit" 
                    wire:loading.attr="disabled"
                    wire:target="create"
                    class="bg-blue-500 text-white font-bold py-2 px-4 rounded shadow hover:bg-blue-700 focus:outline-none focus:shadow-outline disabled:opacity-50 disabled:cursor-not-allowed">
            
                {{-- Show loading indicator only during submit --}}
                <x-filament::loading-indicator 
                    wire:loading 
                    wire:target="create" 
                    class="h-5 w-5 text-blue-500" />
            </div>
            
        </form>
    </x-filament::section>

</main>
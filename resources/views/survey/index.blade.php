<x-layouts.app>
  <div class="bg-gray-50 text-gray-800">

    <!-- Navbar -->
    @include('survey.nav')

    {{-- *csr*

{{-- *csr*
=> issued.
=> 0246401787 -:- bonny --}}

    <div class="flex-1 flex items-center justify-center w-full mt-4" >
      <div class="w-full max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-center mb-6">Survey List</h1>
        <p class="text-center text-gray-600 mb-4">Select a survey to start.</p>
        <div class="bg-white p-6 rounded shadow-md">
          <p class="text-gray-800 mb-4">Please select a survey from the list below:</p>
          <ul class="list-disc pl-5">
            @livewire('survery-list')
          </ul>
      
    </div>

    <!-- Footer -->
    <footer class="bg-gray-100 py-6 mt-12 text-center text-gray-500 text-sm">
      © 2025 Survey. All rights reserved.
    </footer>

  </div>

    
</x-layouts.app>



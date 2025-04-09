<x-layouts.app>
  <div class="bg-gray-50 text-gray-800">

    <!-- Navbar -->
    @include('survey.nav')

{{-- *csr*
=> issued.
=> 0246401787 -:- bonny --}}

    <div class="mt-4 container flex">
       @livewire('survey-questiions',['record' => $record])
    </div>

    <!-- Footer -->
    <footer class="bg-gray-100 py-6 mt-12 text-center text-gray-500 text-sm">
      © 2025 Survey. All rights reserved.
    </footer>

  </div>

    
</x-layouts.app>

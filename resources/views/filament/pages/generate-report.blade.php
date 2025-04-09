<x-filament-panels::page>
  <div x-data="reportdata">
    <x-filament::section>
      <x-filament-panels::form>

        <x-filament::input.wrapper>
          <select x-model="report_type" class="filament-forms-select-component w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500">
            <option value="All">All Sentiment</option>
            <option value="positive">Positive</option>
            <option value="negative">Negative</option>
            <option value="neutral">Neutral</option>
          </select>
        </x-filament::input.wrapper>

        <div class="flex justify-between gap-x-4 mt-4">
          <div class="w-1/2">
            <label class="block text-sm font-medium text-gray-700 mb-1">From date</label>
            <x-filament::input.wrapper>
              <x-filament::input
                type="date"
                x-model="from_date"
                placeholder="From date"
              />
            </x-filament::input.wrapper>
          </div>

          <div class="w-1/2">
            <label class="block text-sm font-medium text-gray-700 mb-1">To date</label>
            <x-filament::input.wrapper>
              <x-filament::input
                type="date"
                x-model="to_date"
                placeholder="To date"
              />
            </x-filament::input.wrapper>
          </div>
        </div>

        <x-filament::button class="mt-6" size="sm" x-on:click="generatereport">
          Generate Report
        </x-filament::button>

      </x-filament-panels::form>
    </x-filament::section>
  </div>
</x-filament-panels::page>

<script>
  function reportdata() {
    return {
      report_type: 'All',
      from_date: '',
      to_date: '',
      generatereport() {
        if (this.from_date === "") {
          alert('From date can\'t be empty');
          return;
        }

        if (this.to_date === "") {
          alert('To date can\'t be empty');
          return;
        }

        console.log('Generating report with:', this.report_type, this.from_date, this.to_date);

        window.open(`/report-generate/${this.report_type}/${this.from_date}/${this.to_date}`, '_blank');
      }
    }
  }
</script>
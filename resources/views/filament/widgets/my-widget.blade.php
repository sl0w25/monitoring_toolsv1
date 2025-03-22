<x-filament-widgets::widget>
    <x-filament::section>
        <div wire:poll.2s>
        <!-- Payout Statistics Section -->
        <div class="bg-white p-4 rounded-lg shadow-md mb-6">
            {{-- <h2 class="text-xl font-semibold">Beneficiaries Statistics</h2> --}}
            <div  class="mt-4">
                {{-- <p>Total Beneficiaries: {{ $data['bene_id'] }}</p>
                <p>Male: {{ $data['male'] }} &nbsp;|&nbsp; Female: {{ $data['female'] }}</p>
                <p>Total Absent: {{ $data['absent'] }}</p>
                <p>Total Present: {{ $data['present'] }}</p>
                <p>Total Hired: {{ $data['hired'] }}</p>
                <p>Total Wait Listed: {{ $data['w_listed'] }}</p> --}}

            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-m font-medium text-gray-500 uppercase tracking-wider">
                            Province
                        </th>
                        <th class="px-6 py-3 text-left text-m font-medium text-gray-500 uppercase tracking-wider">
                            Absent
                        </th>
                        <th class="px-6 py-3 text-left text-m font-medium text-gray-500 uppercase tracking-wider">
                            Present
                        </th>
                        <th class="px-6 py-3 text-left text-m font-medium text-gray-500 uppercase tracking-wider">
                            Hired
                        </th>
                        <th class="px-6 py-3 text-left text-m font-medium text-gray-500 uppercase tracking-wider">
                            Wait Listed
                        </th>
                        <th class="px-6 py-3 text-left text-m font-medium text-gray-500 uppercase tracking-wider">
                            Beneficiaries
                        </th>
                        <th class="px-6 py-3 text-left text-m font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($provinces as $province)
                        <tr x-data="{ open: false, loading: false }" :class="open ? 'bg-gray-50' : ''">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $province['name'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $province['absent'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $province['present'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $province['hired'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $province['w_listed'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $province['bene'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <!-- Modal Trigger Button -->
                                <button
                                    @click="loading = true; open = true; setTimeout(() => loading = false, 500)"
                                    class="flex items-center bg-blue-600 text-black px-4 py-1 rounded shadow hover:bg-green-700 focus:outline-none"
                                    x-data
                                    x-init="$dispatch('update-municipalities', {{ json_encode($province['municipality']) }})">
                                    View
                                </button>


                                <!-- Modal -->
                                <div
                                    x-show="open"
                                    x-cloak
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opa   -50 backdrop-blur-sm"
                                    @click.away="open = false"
                                    aria-hidden="true"
                                    aria-modal="true"
                                    role="dialog"
                                    style="backdrop-filter: blur(10px);"
                                >
                                    <div
                                        class="bg-white rounded-lg shadow-lg w-full max-w-4xl p-6 relative md:w-2/3"
                                        @keydown.escape.window="open = false"
                                    >


                                        <!-- Loading Spinner -->
                                        <div x-show="loading" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-75">
                                            <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                            </svg>
                                        </div>



                                        <!-- Modal Content -->
                                        <div x-show="!loading" x-data="{
                                            municipalities: {{ json_encode($province['municipality']) }},
                                            currentPage: 1,
                                            perPage: 8,
                                            formatNumber(number) {
                                                if (isNaN(number)) return number; // Return as is if not a number
                                                return new Intl.NumberFormat('en-US').format(number);
                                            },
                                            get paginatedMunicipalities() {
                                                let start = (this.currentPage - 1) * this.perPage;
                                                let visible = this.municipalities.slice(start, start + this.perPage);
                                                return visible.map(municipality => ({
                                                    ...municipality,
                                                    absent: this.formatNumber(municipality.absent),
                                                    present: this.formatNumber(municipality.present),
                                                    hired: this.formatNumber(municipality.hired),
                                                    w_listed: this.formatNumber(municipality.w_listed),
                                                    bene: this.formatNumber(municipality.bene)
                                                }));
                                            },
                                            get totalPages() {
                                                return Math.ceil(this.municipalities.length / this.perPage);
                                            }
                                        }"

                                        >
                                            <h4 class="text-lg font-semibold mb-4 text-gray-800">
                                                Statistics for {{ $province['name'] }}
                                            </h4>
                                            <p>Total Beneficiaries: {{ $province['bene'] }}</p>
                                            <p>Total Absent: {{ $province['absent'] }}</p>
                                            <p>Total Present: {{ $province['present'] }}</p>
                                            <p>Total Hired: {{ $province['hired'] }}</p>
                                            <p>Total Wait Listed: {{ $province['w_listed'] }}</p>

                                            <table class="table-auto w-full divide-y divide-gray-200">
                                                <thead>
                                                    <tr>
                                                    <th class="px-6 py-3 text-left text-m font-medium text-gray-500 uppercase tracking-wider">Municipality</th>
                                                    <th class="px-6 py-3 text-left text-m font-medium text-gray-500 uppercase tracking-wider">Absent</th>
                                                    <th class="px-6 py-3 text-left text-m font-medium text-gray-500 uppercase tracking-wider">Present</th>
                                                    <th class="px-6 py-3 text-left text-m font-medium text-gray-500 uppercase tracking-wider">Hired</th>
                                                    <th class="px-6 py-3 text-left text-m font-medium text-gray-500 uppercase tracking-wider">Wait Listed</th>
                                                    <th class="px-6 py-3 text-left text-m font-medium text-gray-500 uppercase tracking-wider">Beneficiaries</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    <template x-for="municipality in paginatedMunicipalities" :key="municipality.municipality">
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap" x-text="municipality.municipality"></td>
                                                            <td class="px-6 py-4 whitespace-nowrap" x-text="municipality.absent"></td>
                                                            <td class="px-6 py-4 whitespace-nowrap" x-text="municipality.present"></td>
                                                            <td class="px-6 py-4 whitespace-nowrap" x-text="municipality.is_hired"></td>
                                                            <td class="px-6 py-4 whitespace-nowrap" x-text="municipality.w_listed"></td>
                                                            <td class="px-6 py-4 whitespace-nowrap" x-text="municipality.bene"></td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                            <!-- Pagination Controls -->
                                            <div class="mt-4 flex justify-between items-center">
                                                <button
                                                    @click="currentPage = Math.max(1, currentPage - 1)"
                                                    class="px-3 py-1 bg-gray-200 rounded shadow hover:bg-gray-300"
                                                    :disabled="currentPage === 1"
                                                >
                                                    Previous
                                                </button>
                                                <span x-text="'Page ' + currentPage + ' of ' + totalPages"></span>
                                                <button
                                                    @click="currentPage = Math.min(totalPages, currentPage + 1)"
                                                    class="px-3 py-1 bg-gray-200 rounded shadow hover:bg-gray-300"
                                                    :disabled="currentPage === totalPages"
                                                >
                                                    Next
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Close Button -->
                                        <!-- <button
                                            @click="open = false"
                                            class="absolute top-4 right-0 text-gray-500 hover:text-gray-700 focus:outline-none"
                                            aria-label="Close Modal"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button> -->

                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
        <script src="//unpkg.com/alpinejs" defer></script>
    </x-filament::section>
</x-filament-widgets::widget>

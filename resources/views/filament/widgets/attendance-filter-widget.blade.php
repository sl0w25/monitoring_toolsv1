<div>
    <div class="grid grid-cols-3 gap-4 mb-4">
        <!-- Province Filter -->
        <div>
            <label for="province" class="block text-sm font-medium text-gray-700">Province</label>
            <select wire:model="province" id="province" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All Provinces</option>
                @foreach(App\Models\LocationInfo::select('province')->distinct()->pluck('province') as $province)
                    <option value="{{ $province }}">{{ $province }}</option>
                @endforeach
            </select>
        </div>

        <!-- Municipality Filter -->
        <div>
            <label for="municipality" class="block text-sm font-medium text-gray-700">Municipality</label>
            <select wire:model="municipality" id="municipality" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All Municipalities</option>
                @foreach(App\Models\LocationInfo::select('municipality')->distinct()->pluck('municipality') as $municipality)
                    <option value="{{ $municipality }}">{{ $municipality }}</option>
                @endforeach
            </select>
        </div>

        <!-- Barangay Filter -->
        <div>
            <label for="barangay" class="block text-sm font-medium text-gray-700">Barangay</label>
            <select wire:model="barangay" id="barangay" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All Barangays</option>
                @foreach(App\Models\LocationInfo::select('barangay')->distinct()->pluck('barangay') as $barangay)
                    <option value="{{ $barangay }}">{{ $barangay }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">#</th>
                    <th class="px-4 py-2 border-b">Barangay</th>
                    <th class="px-4 py-2 border-b">First Name</th>
                    <th class="px-4 py-2 border-b">Middle Name</th>
                    <th class="px-4 py-2 border-b">Last Name</th>
                    <th class="px-4 py-2 border-b">Ext</th>
                    <th class="px-4 py-2 border-b">Time of Payout</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $attendance)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border-b">{{ $attendance->barangay }}</td>
                        <td class="px-4 py-2 border-b">{{ $attendance->first_name }}</td>
                        <td class="px-4 py-2 border-b">{{ $attendance->middle_name }}</td>
                        <td class="px-4 py-2 border-b">{{ $attendance->last_name }}</td>
                        <td class="px-4 py-2 border-b">{{ $attendance->ext_name }}</td>
                        <td class="px-4 py-2 border-b">{{ $attendance->time_in }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-2 border-b text-center" colspan="7">No attendance records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Always visible modal -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- Left Section -->
    <div class="p-6 rounded-lg shadow-lg bg-white dark:bg-gray-900">
        <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Information</h2>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Province</label>
            <input type="text" disabled value="{{ $familyHead->province }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Municipality</label>
            <input type="text" disabled value="{{ $familyHead->municipality }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Barangay</label>
            <input type="text" disabled value="{{ $familyHead->barangay }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">First Name</label>
            <input type="text" disabled value="{{ $familyHead->first_name }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Middle Name</label>
            <input type="text" disabled value="{{ $familyHead->middle_name }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Last Name</label>
            <input type="text" disabled value="{{ $familyHead->last_name }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>
    </div>

    <!-- Right Section -->
    <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-lg">
        <h2 class="text-lg font-semibold mb-4 text-right text-gray-900 dark:text-white">&nbsp;</h2>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Philsys ID Number</label>
            <input type="text" disabled value="{{ $familyHead->philsys_number }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Birthdate</label>
            <input type="text" disabled
                   value="{{ \Carbon\Carbon::createFromDate($familyHead->birth_year, $familyHead->birth_month, $familyHead->birth_day)->format('F j, Y') }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Sex</label>
            <input type="text" disabled value="{{ $familyHead->sex }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Contact Number</label>
            <input type="text" disabled value="{{ $familyHead->contact_number }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Sector</label>
            <input type="text" disabled value="{{ $familyHead->target_sector }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Civil Status</label>
            <input type="text" disabled value="{{ $familyHead->civil_status }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>
    </div>
</div>

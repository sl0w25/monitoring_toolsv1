<!-- Always visible modal -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- Left Section -->
    <div class="p-6 rounded-lg shadow-lg bg-white dark:bg-gray-900">
        <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Information</h2>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">DSWD ID No.</label>
            <input type="text" disabled value="{{ $familyHead->dswd_id }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Full Name</label>
            <input type="text" disabled value="{{ $familyHead->first_name . ' ' . $familyHead->middle_name . ' ' . $familyHead->last_name . ' ' . $familyHead->ext }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Race Category</label>
            <input type="text" disabled value="{{ $familyHead->category_race }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Position</label>
            <input type="text" disabled value="{{ $familyHead->target_sector }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Division</label>
            <input type="text" disabled value="{{ $familyHead->target_sector }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Section/Unit/Program/Center</label>
            <input type="text" disabled value="{{ $familyHead->civil_status }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Contact Number</label>
            <input type="text" disabled value="{{ $familyHead->contact_number }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>

    </div>

    <!-- Right Section -->
    <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-lg">
        <h2 class="text-lg font-semibold mb-4 text-right text-gray-900 dark:text-white">&nbsp;</h2>


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
            <label class="block text-gray-700 dark:text-gray-300">Health Consent</label>
            <input type="text" disabled value="{{ $familyHead->health_consent }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">In Case of Emergency</label>
            <input type="text" disabled value="{{ $familyHead->contact_person . ' ' . $familyHead->contact_number2 }}"
                   class="w-full border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg
                          text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800">
        </div>


    </div>
</div>

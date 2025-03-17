<div>
    <h4 class="text-lg font-semibold mb-4 text-gray-800">
        Municipality Details for {{ $province }}
    </h4>

    <table class="table-auto w-full text-left border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">Municipality</th>
                <th class="px-4 py-2">Unpaid</th>
                <th class="px-4 py-2">Paid</th>
                <th class="px-4 py-2">Beneficiaries</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($municipalities as $municipality)
                <tr>
                    <td class="px-4 py-2">{{ $municipality->name }}</td>
                    <td class="px-4 py-2">{{ $municipality->unpaid }}</td>
                    <td class="px-4 py-2">{{ $municipality->paid }}</td>
                    <td class="px-4 py-2">{{ $municipality->bene }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $municipalities->links() }}
    </div>
</div>

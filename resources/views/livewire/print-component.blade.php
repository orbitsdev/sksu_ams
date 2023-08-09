<div class="print-container max-w-4xl mt-4 mx-auto border-2 border-gray-200">
    <!-- Add your content here, using Blade syntax -->
    <div class="sklogo rounded p-6 pt-4 flex items-start justify-between">
        <!-- ... -->
    </div>

    <div class="flex justify-between px-6 mt-9 text-gray-900 font-semibold">
        <!-- ... -->
    </div>

    <div class="mt-2">
        <div class="px-6 overflow-x-auto">
            <div class="inline-block min-w-full py-2 align-middle">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th scope="col" class="py-3.5 text-left font-semibold text-gray-900">Name</th>
                            <th scope="col" class="py-3.5 text-left font-semibold text-gray-900">Position</th>
                            <th scope="col" class="py-3.5 text-center font-semibold text-gray-900">Morning in & out</th>
                            <th scope="col" class="py-3.5 text-right font-semibold text-gray-900">Afternoon in & out</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse ($samples as $item)
                        <tr>
                            <td class="whitespace-nowrap py-2 text-left text-gray-500">Karla Balhinon</td>
                            <td class="whitespace-nowrap py-2 text-ledt text-gray-500">Staff</td>
                            <td class="whitespace-nowrap py-2 text-center text-gray-500">{{ now()->format('h:i a') }} | {{ now()->format('h:i a') }}</td>
                            <td class="whitespace-nowrap py-2 text-right text-gray-500">{{ now()->format('h:i a') }} | {{ now()->format('h:i a') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-500">No data available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

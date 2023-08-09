<div>
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .print-container {
                visibility: visible !important;
                width: 100%;
                margin: 20px 0; /* Set some margins for better layout */
            }

            .print-container * {
                visibility: visible !important;
            }

            /* Center the content horizontally */
            .center-content {
                text-align: center;
            }

            /* Define page breaks to start a new page on specific elements */
            .page-break {
                page-break-after: always;
            }
        }
    </style>

    <div class="border border-gray-50 p-6">
        <!-- Your input fields and controls go here -->
        <!-- ... -->
    </div>

    <div class="max-w-4xl m-auto flex mt-6 justify-end">
        <x-button class="ok" icon="printer" spinner="print" wire:click="print">Print</x-button>
    </div>

    <div class="print-container max-w-4xl mt-4 mx-auto border-2 border-gray-200">
        <div class="center-content">
            <!-- SKSU logo and other header details -->
            <!-- ... -->
        </div>

        <div class="flex justify-between px-6 mt-9 text-gray-900 font-semibold">
            <div>
                <p>College of Health and Sciences</p>
                <p>{{ now()->format('F d, Y') }}</p>
            </div>

            <div>
                <p>Diploma in Midwifery</p>
            </div>
        </div>

        <!-- Table for displaying attendance data -->
        <div class="mt-2">
            <div class="px-6 overflow-x-auto">
                <div class="inline-block min-w-full py-2 align-middle">
                    <table class="min-w-full">
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

    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('aaa', function() {
                window.print();
            });
        });
    </script>
</div>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Test Results — Lab / X-Ray</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session("success"))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session("success") }}</div>
                @endif

                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Token</th>
                            <th class="px-4 py-2 text-left">Patient</th>
                            <th class="px-4 py-2 text-left">Appointment Status</th>
                            <th class="px-4 py-2 text-left">Test Result Status</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($appointments as $appt)
                            <tr>
                                <td class="px-4 py-2">{{ $appt->queue_token }}</td>
                                <td class="px-4 py-2">{{ $appt->patient->full_name }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-800">{{ ucfirst($appt->status) }}</span>
                                </td>
                                <td class="px-4 py-2">
                                    {{ $appt->testResult ? ucfirst(str_replace("_", " ", $appt->testResult->status)) : "Not entered" }}
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route("test-results.create", $appt->id) }}" class="text-indigo-600 hover:underline">
                                        {{ $appt->testResult ? "Edit Results" : "Enter Results" }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-4 text-gray-500">No appointments yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Appointments</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session("success"))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session("success") }}</div>
                @endif
                <a href="{{ route("patients.index") }}" class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Register Patient First
                </a>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Token</th>
                            <th class="px-4 py-2 text-left">Patient</th>
                            <th class="px-4 py-2 text-left">Date</th>
                            <th class="px-4 py-2 text-left">Time</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($appointments as $appt)
                            <tr>
                                <td class="px-4 py-2">{{ $appt->queue_token }}</td>
                                <td class="px-4 py-2">{{ $appt->patient->full_name }}</td>
                                <td class="px-4 py-2">{{ $appt->appointment_date }}</td>
                                <td class="px-4 py-2">{{ $appt->appointment_time }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-800">{{ ucfirst($appt->status) }}</span>
                                </td>
                                <td class="px-4 py-2">
                                    @if ($appt->status === "booked")
                                        <form method="POST" action="{{ route("appointments.check-in", $appt) }}">
                                            @csrf
                                            @method("PATCH")
                                            <button type="submit" class="px-3 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700">
                                                Check In
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-4 text-gray-500">No appointments booked yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

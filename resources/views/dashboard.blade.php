<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Dashboard") }} - {{ Auth::user()->role->name ?? "User" }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <div class="text-sm text-gray-500">Total Patients</div>
                    <div class="text-3xl font-bold text-indigo-600">{{ \App\Models\Patient::count() }}</div>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <div class="text-sm text-gray-500">Appointments Booked</div>
                    <div class="text-3xl font-bold text-indigo-600">{{ \App\Models\Appointment::count() }}</div>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <div class="text-sm text-gray-500">Test Results</div>
                    <div class="text-3xl font-bold text-indigo-600">{{ \App\Models\TestResult::count() }}</div>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <div class="text-sm text-gray-500">Certificates Issued</div>
                    <div class="text-3xl font-bold text-indigo-600">{{ \App\Models\Certificate::count() }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Recent Appointments</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Token</th>
                            <th class="px-4 py-2 text-left">Patient</th>
                            <th class="px-4 py-2 text-left">Date</th>
                            <th class="px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse (\App\Models\Appointment::with("patient")->latest()->take(5)->get() as $appt)
                            <tr>
                                <td class="px-4 py-2">{{ $appt->queue_token }}</td>
                                <td class="px-4 py-2">{{ $appt->patient->full_name }}</td>
                                <td class="px-4 py-2">{{ $appt->appointment_date }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-800">{{ ucfirst($appt->status) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-4 text-gray-500">No appointments yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>


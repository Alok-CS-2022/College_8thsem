<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Patients</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session("success"))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session("success") }}</div>
                @endif
                <div class="flex justify-between items-center mb-4">
                    <a href="{{ route("patients.create") }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        + Register New Patient
                    </a>
                    <form method="GET" action="{{ route("patients.index") }}" class="flex gap-2">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search name, passport, phone, case ID, or cert ID" class="rounded border-gray-300 w-72">
                        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Search</button>
                        @if ($search)
                            <a href="{{ route("patients.index") }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Clear</a>
                        @endif
                    </form>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Passport No.</th>
                            <th class="px-4 py-2 text-left">Full Name</th>
                            <th class="px-4 py-2 text-left">Destination</th>
                            <th class="px-4 py-2 text-left">Phone</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($patients as $patient)
                            <tr>
                                <td class="px-4 py-2">{{ $patient->passport_number }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route("patients.show", $patient) }}" class="text-indigo-600 hover:underline">{{ $patient->full_name }}</a>
                                </td>
                                <td class="px-4 py-2">{{ $patient->destination_country }}</td>
                                <td class="px-4 py-2">{{ $patient->phone }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route("appointments.create", ["patient" => $patient->id]) }}" class="text-indigo-600 hover:underline">Book Appointment</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-4 text-gray-500">No patients found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

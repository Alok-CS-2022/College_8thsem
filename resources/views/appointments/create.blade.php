<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Book Appointment</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session("success"))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session("success") }}</div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route("appointments.store") }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Patient</label>
                        <select name="patient_id" class="mt-1 block w-full rounded border-gray-300" required>
                            <option value="">-- Select Patient --</option>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}" {{ (string) $selectedPatientId === (string) $patient->id ? "selected" : "" }}>
                                    {{ $patient->full_name }} ({{ $patient->passport_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Appointment Date</label>
                        <input type="date" name="appointment_date" class="mt-1 block w-full rounded border-gray-300" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Appointment Time</label>
                        <input type="time" name="appointment_time" class="mt-1 block w-full rounded border-gray-300" required>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Book Appointment
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

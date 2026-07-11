<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $patient->full_name }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div><dt class="text-gray-500">Passport</dt><dd>{{ $patient->passport_number }}</dd></div>
                    <div><dt class="text-gray-500">Date of Birth</dt><dd>{{ $patient->date_of_birth }}</dd></div>
                    <div><dt class="text-gray-500">Gender</dt><dd>{{ $patient->gender }}</dd></div>
                    <div><dt class="text-gray-500">Phone</dt><dd>{{ $patient->phone }}</dd></div>
                    <div><dt class="text-gray-500">Destination</dt><dd>{{ $patient->destination_country }}</dd></div>
                    <div><dt class="text-gray-500">Manpower Agency</dt><dd>{{ $patient->manpower_agency ?? "—" }}</dd></div>
                    <div class="col-span-2"><dt class="text-gray-500">Address</dt><dd>{{ $patient->address }}</dd></div>
                </dl>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Timeline</h3>
                <ul class="space-y-3">
                    @forelse ($events as $event)
                        <li class="flex gap-4 text-sm border-l-2 border-indigo-300 pl-4">
                            <span class="text-gray-500 whitespace-nowrap">{{ \Carbon\Carbon::parse($event["date"])->format("Y-m-d H:i") }}</span>
                            <span>{{ $event["label"] }}</span>
                        </li>
                    @empty
                        <li class="text-gray-500">No events yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>

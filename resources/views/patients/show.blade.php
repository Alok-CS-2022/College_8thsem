<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $patient->full_name }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session("success"))
                <div class="p-4 bg-green-100 text-green-800 rounded">{{ session("success") }}</div>
            @endif
            @if ($errors->any())
                <div class="p-4 bg-red-100 text-red-800 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
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
            @foreach ($medicalCases as $case)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-2">Medical Case #{{ $case->id }}</h3>
                    <p class="text-sm text-gray-500 mb-4">Status: {{ ucfirst(str_replace('_', ' ', $case->status)) }}</p>
                    <div class="space-y-2 mb-4">
                        @forelse ($case->notes as $note)
                            <div class="text-sm border-l-2 border-gray-300 pl-3">
                                <span class="text-xs uppercase text-gray-400">{{ $note->type }}</span> —
                                <span class="text-xs text-gray-500">{{ $note->user->name ?? 'Unknown' }}, {{ $note->created_at->format('Y-m-d H:i') }}</span>
                                <p>{{ $note->content }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">No notes yet.</p>
                        @endforelse
                    </div>
                    <form method="POST" action="{{ route('medical-case-notes.store', $case) }}" class="space-y-2">
                        @csrf
                        <select name="type" class="rounded border-gray-300 text-sm">
                            <option value="administrative">Administrative</option>
                            <option value="medical">Medical</option>
                            <option value="review">Review</option>
                        </select>
                        <textarea name="content" rows="2" class="block w-full rounded border-gray-300 text-sm" placeholder="Add a note..." required></textarea>
                        <button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded text-xs hover:bg-indigo-700">Add Note</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
